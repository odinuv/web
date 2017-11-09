<?php

$app->get('/update-person', function(Request $request, Response $response, $args) {
    $this->view->render($response, 'person-update.latte');
})->setName('update-person');

$app->post('/update-person', function(Request $request, Response $response, $args) {
    //hardcoded ID of person
    $personId = 1;
    $data = $request->getParsedBody();
    if (empty($data['first_name']) || empty($data['last_name']) || empty($data['nickname'])) {
        $tplVars['message'] = 'Please fill in both names and nickname';
    } elseif (empty($data['gender']) || ($data['gender'] != 'male' && $data['gender'] != 'female')) {
        $tplVars['message'] = 'Gender must be either "male" or "female"';
    } else {
        // everything filled
        try {
            $stmt = $this->db->prepare(
                "UPDATE person SET first_name = :first_name, last_name = :last_name, 
				nickname = :nickname, birth_day = :birth_day, gender = :gender, height = :height
				WHERE id_person = :id_person"
            );
            $stmt->bindValue(':id_person', $personId);
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':nickname', $data['nickname']);
            $stmt->bindValue(':gender', $data['gender']);

            if (empty($data['birth_day'])) {
                $stmt->bindValue(':birth_day', null);
            } else {
                $stmt->bindValue(':birth_day', $data['birth_day']);
            }

            if (empty($data['height']) || empty(intval($data['height']))) {
                $stmt->bindValue(':height', null);
            } else {
                $stmt->bindValue(':height', intval($data['height']));
            }
            $stmt->execute();
            $tplVars['message'] = "Person updated";
        } catch (PDOException $e) {
            $this->logger->error($e->getMessage());
            $tplVars['message'] = "Failed to update person (" . $e->getMessage() . ")";
        }
    }
    $this->view->render($response, 'person-update.latte', $tplVars);
});

