<?php
$app->get('/add-contact', function(Request $request, Response $response, $args) {
    //get id parameter from query
    $id = $request->getQueryParam('id');
    if(empty($id)) {
        exit('Specify person ID');
    }
    try {
        /* select all contacts of given person and print them
        $stmt = $this->db->prepare('...');
        $tplVars['contacts'] = $stmt->fetchAll();
        */
        $stmt = $this->db->query('SELECT * FROM contact_type ORDER BY name');
        $tplVars['types'] = $stmt->fetchAll();
        $tplVars['id'] = $id;   //pass ID into template
        return $this->view->render($response, 'add-contact.latte', $tplVars);
    } catch (Exception $e) {
        $this->logger->error($e->getMessage());
        exit('Loading contact types failed.');
    }
})->setName('addContact');