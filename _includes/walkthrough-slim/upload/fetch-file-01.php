<?php

$app->get('/fetch-file', function(Request $request, Response $response, $args) {
    $id = $request->getQueryParam('id');
    if(!empty($id)) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM file WHERE id_file = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $fileInfo = $stmt->fetch();
            if($fileInfo) {
                //now you can check if visitor has privilege to download requested file
                $settings = $this->get('settings');
                $directory = $settings['uploadDir'];
                $fh = fopen($directory . DIRECTORY_SEPARATOR . $fileInfo['file_name'], 'r');
                $stream = new \Slim\Http\Stream($fh);
                //set headers and send file contents
                return $response
                    ->withHeader('Content-Type', $fileInfo['file_type'])
                    ->withHeader('Content-Disposition', 'inline; filename="' . $fileInfo['file_name_orig'] . '"')
                    ->withBody($stream);
            } else {
                return $response->withStatus(404)->write('File not found');
            }
        } catch(PDOException $e) {
            return $response->withStatus(500)->write($e->getMessage());
        }
    } else {
        return $response->withStatus(403)->write('Specify file id');
    }
})->setName('download');