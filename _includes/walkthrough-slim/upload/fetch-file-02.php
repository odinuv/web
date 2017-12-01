<?php

$app->get('/fetch-file', function(Request $request, Response $response, $args) {
    //reset cache related headers
    header_remove('Cache-Control');
    header_remove('Pragma');
    header_remove('Expires');
    $id = $request->getQueryParam('id');
    if(!empty($id)) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM file WHERE id_file = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $fileInfo = $stmt->fetch();
            if($fileInfo) {
                if(!empty($request->getHeader('If-Modified-Since'))) {
                    //we know that client has some version, because the file
                    //is always same, we just tell him to use cached version
                    return $response->withStatus(304);
                } else {
                    $settings = $this->get('settings');
                    $directory = $settings['uploadDir'];
                    $fh = fopen($directory . DIRECTORY_SEPARATOR . $fileInfo['file_name'], 'r');
                    $stream = new \Slim\Http\Stream($fh);
                    $origName = $fileInfo['file_name_orig'];
                    //set headers and send file contents
                    //add header with last modification time
                    $lastModified = gmdate('D, d M Y H:i:s ', time()) . 'GMT';
                    return $response
                        ->withHeader('Content-Type', $fileInfo['file_type'])
                        ->withHeader('Content-Disposition', 'inline; filename="' . $origName . '"')
                        ->withHeader('Last-Modified', $lastModified)
                        ->withBody($stream);
                }
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