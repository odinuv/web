<?php

$app->get('/add-person', function(Request $request, Response $response, $args) {
    $this->view->render($response, 'person-add.latte');
});

$app->post('/add-person', function(Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    if (empty($data['first_name']) || empty($data['last_name']) || empty($data['nickname'])) {
        $tplVars['message'] = 'Please fill in both names and nickname';
    } else {
        // everything filled
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO person (first_name, last_name, nickname, birth_day) 
                VALUES (:first_name, :last_name, :nickname, :birth_day)"
            );
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':nickname', $data['nickname']);
            if (empty($data['birth_day'])) {
                $stmt->bindValue(':birth_day', null);
            } else {
                $stmt->bindValue(':birth_day', $data['birth_day']);
            }
            $stmt->execute();
            $tplVars['message'] = "Person added";
        } catch (PDOException $e) {
            $this->logger->error($e->getMessage());
            $tplVars['message'] = "Failed to insert person (" . $e->getMessage() . ")";
        }
    }
    $this->view->render($response, 'person-add.latte', $tplVars);
});