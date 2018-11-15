<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'phpQuery.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

class CodecademyBackend
{
    /**
     * Database connection.
     *
     * @var PDO
     */
    private $db;

    /**
     * Minimum required number of points.
     */
    const POINTS_REQUIRED = 90;

    /**
     * Hash for administrative password.
     */
    const PASSWORD_HASH = PASSWORDHASH;


    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        try {
            $this->db = new PDO('pgsql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            $this->terminate(500, 'Database connection error');
        }
    }


    /**
     * Terminate processing with an HTTP status.
     *
     * @param int $code HTTP status code.
     * @param string $message String message.
     * @param string $extendedMessage Extended error message.
     */
    private function terminate($code, $message, $extendedMessage = "")
    {
        if ($extendedMessage) {
            ob_clean();
            echo json_encode(array("message" => $extendedMessage));
        }
        header($_SERVER['SERVER_PROTOCOL'] . " $code " . $message, true, $code);
        exit;
    }


    /**
     * Run the backend to process a HTTP request.
     */
    public function run()
    {
        ob_start();
        if (!isset($_POST['act'])) {
            $this->terminate(400, 'Bad Request', 'No request');
        }
        try {
            switch ($_POST['act']) {
                case 'getUser':
                    if (empty($_POST['email'])) {
                        $this->terminate(400, 'Bad Request', 'No email');
                    } else {
                        echo json_encode($this->getUser($_POST['email']));
                        $this->terminate(200, 'OK');
                    }
                    break;
                case 'setUserName':
                    if (empty($_POST['userName']) || empty($_POST['email']) || empty($_POST['idUser'])) {
                        $this->terminate(400, 'Bad Request', 'No email, username or ID');
                    } else {
                        try {
                            $this->setUser($_POST['userName'], $_POST['email'], $_POST['idUser']);
                            echo json_encode($this->getUser($_POST['email']));
                            $this->terminate(200, 'OK');
                        } catch (InvalidArgumentException $e) {
                            $this->terminate(400, 'Bad Request', $e->getMessage());
                        }
                        $this->terminate(200, 'OK');
                    }
                    break;
                case 'refreshAll':
                    if (empty($_POST['ack']) || password_hash($_POST['ack'], PASSWORD_BCRYPT) == self::PASSWORD_HASH) {
                        $this->terminate(401, 'Unauthorized', 'Admin password missing or invalid.');
                    }
                    echo json_encode($this->refreshAllActiveUsers());
                    $this->terminate(200, 'OK');
                    break;
                case 'importUsers':
                    if (empty($_POST['ack']) || password_hash($_POST['ack'], PASSWORD_BCRYPT) == self::PASSWORD_HASH) {
                        $this->terminate(401, 'Unauthorized', 'Admin password missing or invalid.');
                    }
                    echo json_encode($this->importUsers($_POST['data']));
                    $this->terminate(200, 'OK');
                    break;
                default:
                    $this->terminate(400, 'Bad Request', 'Unknown Request');
            }
        } catch (Exception $e) {
            $this->terminate(500, 'Internal Server Error', $e->getMessage());
        }
    }

    /**
     * Check if the email is in database of students.
     *
     * @param string $email University email.
     * @return array User data structure.
     */
    public function getUser($email)
    {
        $stmt = $this->db->prepare(
            "SELECT id_user, username, first_name, last_name FROM www.users WHERE email = :email"
        );
        $stmt->bindValue(':email', trim($email));
        $stmt->execute();

        if ($row = $stmt->fetch()) {
            $result['valid'] = true;
            if ($row['username']) {
                $result['profileUrl'] = 'http://www.codecademy.com/' . $row['username'];
            } else {
                // user name not yet entered
                $result['profileUrl'] = '';
            }
            $result['idUser'] = $row['id_user'];
            $result['userName'] = $row['username'];
            $result['firstName'] = $row['first_name'];
            $result['lastName'] = $row['last_name'];
            // fetch latest result
            $stmt = $this->db->prepare(
                "SELECT points, acquired FROM www.results WHERE id_user = :id_user ORDER BY acquired DESC LIMIT 1"
            );
            $stmt->bindValue(':id_user', $row['id_user']);
            $stmt->execute();
            if ($row = $stmt->fetch()) {
                $result['pointsAmount'] = $row['points'];
                $result['pointsAcquired'] = $row['acquired'];
                $result['pointsSufficient'] = ($row['points'] >= self::POINTS_REQUIRED);
            } else {
                $result['pointsAmount'] = '';
                $result['pointsAcquired'] = '';
                $result['pointsSufficient'] = '';
            }
        } else {
            $result['valid'] = false;
            $result['profileUrl'] = '';
            $result['idUser'] = '';
        }
        return $result;
    }


    /**
     * Assign a codecademy username to a given registered email (and user Id)
     *
     * @param string $userName Codecademy username.
     * @param string $email Student email.
     * @param int $idUser Student user id (for validation of email).
     */
    private function setUser($userName, $email, $idUser)
    {
        $userName = trim($userName);
        $email = trim($email);
        $idUser = intval($idUser);

        if (!preg_match('%^[^\s?:\\\\#@//]+$%', $userName)) {
            throw new \InvalidArgumentException("Zadané uživatelské jméno vypadá divně.");
        }
        // cross validate user id a email
        $stmt = $this->db->prepare("SELECT id_user FROM www.users WHERE (email = :email) AND (id_user = :id_user)");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id_user', $idUser);
        $stmt->execute();
        if (!$row = $stmt->fetch()) {
            throw new \InvalidArgumentException('Uživatel nebo email není v databázi.');
        }

        // check if the username is not in use
        $stmt = $this->db->prepare("SELECT username FROM www.users WHERE (username = :username) AND (email != :email)");
        $stmt->bindValue(':username', $userName);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            throw new \InvalidArgumentException('Ehm, uživatelské jméno již někdo použil.');
        }

        // set new username
        $stmt = $this->db->prepare("UPDATE www.users SET username = :username WHERE email=:email");
        $stmt->bindValue(':username', $userName);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $points = $this->refreshUserPoints($userName, $idUser);
        // send notification email
        @mail(
            $email,
            'APV Codecademy confirmation',
            "I noted that your Codecademy username is $userName, \r\nyou have $points points, score ".
            "is being updated periodically.\r\n\r\nS pozdravem\r\n\tJiri Lysek",
            "From: jiri.lysek@mendelu.cz\r\nBcc: jiri.lysek@mendelu.cz"
        );

    }


    /**
     * Refresh (get and store) points on CA for a given user.
     *
     * @param string $userName Codecademy user name.
     * @param int $idUser Database user ID.
     * @return int Number of points on CA.
     * @throws Exception In case of error
     */
    private function refreshUserPoints($userName, $idUser)
    {
        if (!$userName) {
            // no username, no points
            return 0;
        }
        // get points on CA
        $points = 0;
        try {
            $points = $this->acquireUserPoints($userName);
            // store points even in case of error
            $stmt = $this->db->prepare(
                "INSERT INTO www.results (id_user, points, acquired, tracking_username)
            VALUES (:id_user, :points, CURRENT_TIMESTAMP, :tracking_username)"
            );
            $stmt->bindValue(':id_user', $idUser);
            $stmt->bindValue(':points', $points);
            $stmt->bindValue(':tracking_username', $userName);
            $stmt->execute();
        } catch (Exception $e) {
            // store points even in case of error
            $stmt = $this->db->prepare(
                "INSERT INTO www.results (id_user, points, acquired, tracking_username)
            VALUES (:id_user, :points, CURRENT_TIMESTAMP, :tracking_username)"
            );
            $stmt->bindValue(':id_user', $idUser);
            $stmt->bindValue(':points', $points);
            $stmt->bindValue(':tracking_username', $userName);
            $stmt->execute();
            throw $e;
        }


        return $points;
    }


    /**
     * Get user points on Codecademy.
     *
     * @param string $userName Codecademy user name.
     * @return integer Number of points.
     * @throw InvalidArgumentException
     */
    private function acquireUserPoints($userName)
    {
        $points = null;
        $url = 'https://www.codecademy.com/'.$userName;
        //$url = 'https://23.21.180.190/'.$userName;

        // send HTTP request to CA
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_CERTINFO, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            if ($data = curl_exec($ch)) {
                phpQuery::newDocument($data);
                if (preg_match('#<h1>\s*404\s*error\s*<\\\\*/h1>#is', $data)) {
                    throw new \InvalidArgumentException('This Codecademy account does not exist.');
                } elseif ($points = pq('.profile-time .grid-col-3:nth-child(2) h3')->html()) {
                    // check tag
                    if (!preg_match('#\[\s*apv\s*\]#is', $data)) {
                        throw new \InvalidArgumentException('Account exists, but there is no [APV] text found in the profile page.');
                    }
                } else {
                    throw new \InvalidArgumentException(
                        'Error loading page. Check whether your profile is public.'
                    );
                }
            } else {
                throw new \InvalidArgumentException('Server communication error ' . curl_error($ch));
            }
        } else {
            throw new \InvalidArgumentException('Communication error.');
        }
        return (int)$points;
    }


    /**
     * Refresh points for all active users.
     *
     * @return array Array of arrays with items 'points', 'userName', 'firstName', 'lastName'
     */
    private function refreshAllActiveUsers()
    {
        $stmt = $this->db->prepare(
            "SELECT first_name, last_name, username, email, id_user FROM www.users WHERE active = 1"
        );
        $stmt->execute();
        $ret = [];
        while ($row = $stmt->fetch()) {
            try {
                $points = $this->refreshUserPoints($row['username'], $row['id_user']);
            } catch (\InvalidArgumentException $e) {
                $points = null;
            }
            $ret[] = array(
                'points' => $points,
                'userName' => $row['username'],
                'firstName' => $row['first_name'],
                'lastName' => $row['last_name'],
                'email' => $row['email']
            );
        }
        return $ret;
    }


    /**
     * Import users into database
     *
     * @param string $csvData CSV file exported from UIS.
     * @return array Array of array with items 'email', 'firstName', 'lastName', 'update'
     */
    private function importUsers($csvData)
    {
        // process the CSV file
        $header = true;
        $columnHeaders = [];
        $users = [];
        foreach (explode("\n", $csvData) as $lineIndex => $line) {
            $columns = explode(";", $line);
            if ($header && (count($columns) > 3)) {
                $columnHeaders = $columns;
                if (!in_array('Příjmení', $columnHeaders) || !in_array('Jméno', $columnHeaders) || !in_array('Login', $columnHeaders)) {
                    throw new \InvalidArgumentException("Some of the columns 'Příjmení', 'Jméno', 'Login' are missing.");
                }
                $header = false;
                continue;
            }
            if (!$header) {
                foreach ($columns as $index => $value) {
                    $value = trim($value);
                    if ($columnHeaders[$index] == 'Příjmení') {
                        $row['lastName'] = $value;
                    } elseif ($columnHeaders[$index] == 'Jméno') {
                        $row['firstName'] = $value;
                    } elseif ($columnHeaders[$index] == 'Login') {
                        $row['email'] = $value . '@node.mendelu.cz';
                    }
                }
                if (empty($row['email']) || empty($row['firstName']) || empty($row['lastName'])) {
                    throw new \InvalidArgumentException("Invalid line $lineIndex: $line.");
                } else {
                    $users[] = $row;
                }
            }
        }
        if ($header) {
            throw new \InvalidArgumentException("Invalid header line.");
        }

        // save users in database
        $this->db->query("START TRANSACTION;");
        foreach ($users as $index => $user) {
            // check if the user exists (may be same or different student, we don't know)
            $stmt = $this->db->prepare("SELECT id_user FROM www.users WHERE email = :email");
            $stmt->bindValue(':email', $user['email']);
            $stmt->execute();
            if ($idUser = $stmt->fetchColumn(0)) {
                // email already exists
                $stmt = $this->db->prepare(
                    "UPDATE www.users SET username = NULL, first_name = :first_name, last_name = :last_name,
                    active = 1 WHERE email = :email;"
                );
                $stmt->bindValue(':email', $user['email']);
                $stmt->bindValue(':first_name', $user['firstName']);
                $stmt->bindValue(':last_name', $user['lastName']);
                $stmt->execute();
                // record that the last number of points is unknown
                $stmt = $this->db->prepare(
                    "INSERT INTO www.results (points, acquired, id_user)
                    VALUES (0, CURRENT_TIMESTAMP, :id_user);"
                );
                $stmt->bindValue(':id_user', $idUser);
                $stmt->execute();
                $users[$index]['update'] = 1;
            } else {
                // new email
                $stmt = $this->db->prepare(
                    "INSERT INTO www.users (email, first_name, last_name, active)
                    VALUES (:email, :first_name, :last_name, 1);"
                );
                $stmt->bindValue(':email', $user['email']);
                $stmt->bindValue(':first_name', $user['firstName']);
                $stmt->bindValue(':last_name', $user['lastName']);
                $stmt->execute();
                $users[$index]['update'] = 0;
            }
        }
        $this->db->query("COMMIT;");
        return $users;
    }
}

// Initialize self if a POST request has been made
if (!empty($_POST)) {
    $ctrl = new CodecademyBackend();
    $ctrl->run();
}