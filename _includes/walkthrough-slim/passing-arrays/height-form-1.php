<?php
$app->get('/height-form', function(Request $request, Response $response, $args) {
    try {
        //select persons from database (young or with unknown height)
        $stmt = $this->db->query('
            SELECT * FROM person
            WHERE
              birth_day >= NOW() - INTERVAL \'20\' YEAR
              OR height IS NULL
            ORDER BY last_name, first_name
        ');
        $stmt->execute();
    } catch (PDOException $e) {
        $this->logger->error($e->getMessage());
        exit($e->getMessage());
    }
    $tplVars['pageTitle'] = 'Persons List';
    $tplVars['persons'] = $stmt->fetchAll();
    $this->view->render($response, 'height-form.latte', $tplVars);
})->setName('heightForm');;
