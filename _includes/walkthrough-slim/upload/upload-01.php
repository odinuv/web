<?php

$app->get('/file-upload', function(Request $request, Response $response, $args) {
    return $this->view->render($response, 'upload.latte');
})->setName('upload');

$app->post('/file-upload', function(Request $request, Response $response, $args) {
    //fetch target folder from settings
    $settings = $this->get('settings');
    $directory = $settings['uploadDir'];
    //check if the uploaded file is OK
    $uploadedFiles = $request->getUploadedFiles();
    $uploadedFile = $uploadedFiles['user_file'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        //generate random unique filename
        do {
            $fileName = sha1(rand());
        } while(file_exists($directory . DIRECTORY_SEPARATOR . $fileName));
        //store the file
        try {
            //moveTo can throw exception on failure
            $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $fileName);
            //redirect back to upload form
            return $response->withHeader('Location', $this->router->pathFor('upload'));
        } catch(Exception $e) {
            //file move exception
            $this->logger->error($e->getMessage());
            exit($e->getMessage());
        }
    } else {
        exit('File upload failed.');
    }
});