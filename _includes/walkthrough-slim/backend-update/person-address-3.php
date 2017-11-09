<?php

$app->get('/set-address', function(Request $request, Response $response, $args) {
    $personId = $request->getQueryParam('id');
    if (empty($personId)) {
        exit("Parameter 'id' is missing.");
    }
    try {
        //retrieve the person by his id
        $stmt = $this->db->prepare("SELECT * FROM person WHERE id_person = :id");
        $stmt->bindValue(":id", $_GET['id']);
        $stmt->execute();
        $person = $stmt->fetch();
        if($person) {   //was person found?
            $stmt = $this->db->query("SELECT id_location, city, street_name, street_number
                            FROM location
                            ORDER BY city");
            $tplVars['locations'] = $stmt->fetchAll();
            $tplVars['person'] = $person;
            $this->view->render($response, 'person-address.latte', $tplVars);
        } else {
            exit('No person found');
        }
    } catch (PDOException $e) {
        $this->logger->error($e->getMessage());
        exit($e->getMessage());
    }
})->setName('set-address');