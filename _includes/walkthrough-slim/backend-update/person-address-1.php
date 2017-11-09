<?php

$app->get('/set-address', function(Request $request, Response $response, $args) {
    try {
        //retrieve all locations
        $stmt = $this->db->query("SELECT id_location, city, street_name, street_number
                        FROM location
                        ORDER BY city");
        $tplVars['locations'] = $stmt->fetchAll();
        $this->view->render($response, 'person-address.latte', $tplVars);
    } catch (PDOException $e) {
        $this->logger->error($e->getMessage());
        exit($e->getMessage());
    }
})->setName('set-address');