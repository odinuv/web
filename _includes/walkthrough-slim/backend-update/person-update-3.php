<?php

$app->get('/update-person', function(Request $request, Response $response, $args) {
    $personId = $request->getQueryParam('id');
    if (empty($personId)) {
        exit("Parameter 'id' is missing.");
    }
    try {
        $stmt = $this->db->prepare("SELECT * FROM person WHERE id_person = :id_person");
        $stmt->bindValue(':id_person', $personId);
        $stmt->execute();
        $tplVars['person'] = $stmt->fetch();
        if (!$tplVars['person']) {
            exit("Cannot find person with ID: $personId");
        }
    } catch (PDOException $e) {
        $this->logger->error($e->getMessage());
        exit("Cannot get person " . $e->getMessage());
    }
    $this->view->render($response, 'person-update.latte', $tplVars);
})->setName('update-person');

$app->post('/update-person', function(Request $request, Response $response, $args) {
    //...
});