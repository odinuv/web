<?php

$app->get('/add-person', function(Request $request, Response $response, $args) {
    //we have to prefill some default values to avoid warnings
    $tplVars['person'] = [
        'first_name' => '',
        'last_name' => '',
        'nickname' => '',
        'birth_day' => '',
        'gender' => 'male',
        'height' => ''
    ];
    $this->view->render($response, 'person-add.latte', $tplVars);
});

$app->post('/add-person', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    if (empty($data['first_name']) || empty($data['last_name']) || empty($data['nickname'])) {
        $tplVars['message'] = 'Please fill in both names and nickname';
    } elseif (empty($data['gender']) || ($data['gender'] != 'male' && $data['gender'] != 'female')) {
        $tplVars['message'] = 'Gender must be either "male" or "female"';
    } else {
        // everything filled
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO person (first_name, last_name, nickname, birth_day, height, gender) 
                VALUES (:first_name, :last_name, :nickname, :birth_day, :height, :gender)"
            );
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':nickname', $data['nickname']);
            $stmt->bindValue(':gender', $data['gender']);

            if (empty($data['birth_day'])) {
                $stmt->bindValue(':birth_day', null);
            } else {
                $stmt->bindValue(':birth_day', $data['birth_day']);
            }

            if (empty($_POST['height']) || empty(intval($data['height']))) {
                $stmt->bindValue(':height', null);
            } else {
                $stmt->bindValue(':height', intval($data['height']));
            }
            $stmt->execute();
            $tplVars['message'] = "Person added";
        } catch (PDOException $e) {
            $this->logger->error($e->getMessage());
            $tplVars['message'] = "Failed to insert person (" . $e->getMessage() . ")";
        }
    }
    $tplVars['person'] = $data;
    $this->view->render($response, 'person-add.latte', $tplVars);
});