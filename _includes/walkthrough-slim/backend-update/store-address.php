<?php

$app->get('/set-address', function(Request $request, Response $response, $args) {
    //...
})->setName('set-address');

$app->post('/set-address', function(Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    if (empty($data['id'])) {
        exit("Parameter 'id' is missing.");
    }
    $data = $request->getParsedBody();
    try {
        $lid = !empty($data['location_id']) ? $data['location_id'] : null;
        $stmt = $this->db->prepare("UPDATE person SET id_location = :lid WHERE id_person = :id");
        $stmt->bindValue(":id", $data['id']);
        $stmt->bindValue(":lid", $lid);
        $stmt->execute();
        //redirect back to address selection page
        return $response->withHeader('Location', $this->router->pathFor('set-address') . '?id=' . $data['id']);
    } catch (PDOException $e) {
        $this->logger->error($e->getMessage());
        exit($e->getMessage());
    }
})->setName('store-address');
