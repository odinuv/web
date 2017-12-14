<?php
$app->get('/height-form', function(Request $request, Response $response, $args) {
    //...
})->setName('heightForm');

$app->post('/height-form', function(Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    try {
        //update individual records
        foreach($data['height'] as $id => $h) {
            $stmt = $this->db->prepare('UPDATE person SET height = :h WHERE id_person = :id');
            //store null or actual value
            $stmt->bindValue(':h', !empty($h) ? intval($h) : null);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        }
        //redirect back to form
        return $response->withHeader('Location', $this->router->pathFor('heightForm'));
    } catch (PDOException $e) {
        $this->logger->error($e->getMessage());
        exit($e->getMessage());
    }
});