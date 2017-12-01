<?php

$app->get('/file-upload', function(Request $request, Response $response, $args) {
    //fetch persons from database
    try {
        $stmt = $this->db->query('SELECT * FROM person ORDER BY last_name');
        $tplVars['persons'] = $stmt->fetchAll();
    } catch(PDOException $e) {
        exit($e->getMessage());
    }
    return $this->view->render($response, 'upload.latte', $tplVars);
})->setName('upload');

$app->post('/file-upload', function(Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $settings = $this->get('settings');
    $directory = $settings['uploadDir'];
    $uploadedFiles = $request->getUploadedFiles();
    $uploadedFile = $uploadedFiles['user_file'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        do {
            $fileName = sha1(rand());
        } while(file_exists($directory . DIRECTORY_SEPARATOR . $fileName));
        try {
            //moveTo can throw exception on failure
            $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $fileName);
        } catch(Exception $e) {
            //file move exception
            $this->logger->error($e->getMessage());
            exit($e->getMessage());
        }
        try {
            $stmt = $this->db->prepare('INSERT INTO file
			                            (id_person, file_name, file_name_orig, file_type)
								        VALUES
								        (:idp, :fn, :fno, :ft)');
            $stmt->bindValue(':idp', $data['id_person']);
            $stmt->bindValue(':fn', $fileName);
            $stmt->bindValue(':fno', $uploadedFile->getClientFilename());
            $stmt->bindValue(':ft', $uploadedFile->getClientMediaType());
            $stmt->execute();
            return $response->withHeader('Location', $this->router->pathFor('upload'));
        } catch(PDOException $e) {
            //delete the file
            unlink($directory . DIRECTORY_SEPARATOR . $fileName);
            //DB exception
            $this->logger->error($e->getMessage());
            exit($e->getMessage());
        }
    } else {
        exit('File upload failed.');
    }
});