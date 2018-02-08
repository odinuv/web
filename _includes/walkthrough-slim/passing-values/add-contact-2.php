<?php
$app->post('/add-contact', function(Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    if(!empty($data['id']) && !empty($data['idct']) && !empty($data['contact'])) {
        try {
            //insert contact into database
            $stmt = $this->db->prepare('INSERT INTO contact
                                        (id_contact_type, id_person, contact)
                                        VALUES
                                        (:idct, :id, :c)');
            $stmt->bindValue(':id', $data['id']);
            $stmt->bindValue(':idct', $data['idct']);
            $stmt->bindValue(':c', $data['contact']);
            $stmt->execute();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            exit('Inserting contact failed.');
        }
    } else {
        exit('Specify required parameters.');
    }
    return $response->withHeader('Location', $this->router->pathFor('addContact').'?id='.$data['id']);
})->setName('addContact');