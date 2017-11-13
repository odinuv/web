<?php

$app->post('/delete', function(Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    if(!empty($data["id_person"])) {
        try {
            $stmt = $this->db->prepare("DELETE FROM person WHERE id_person = :idp");
            $stmt->bindValue(":idp", $data["id_person"]);
            $stmt->execute();
            echo "PERSON DELETED";
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    } else {
        exit('Specify ID of person to delete.');
    }
})->setName('delete');