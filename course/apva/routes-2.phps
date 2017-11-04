<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response, $args) {
    // Render index view
    return $this->view->render($response, 'index.latte');
})->setName('index');

$app->post('/test', function (Request $request, Response $response, $args) {
    //read POST data
    $input = $request->getParsedBody();

    //log
    $this->logger->info('Your name: ' . $input['person']);

    return $response->withHeader('Location', $this->router->pathFor('index'));
})->setName('redir');

$app->get('/people', function($request, $response) {
  $stmt = $this->db->query('SELECT * FROM person');
  $persons = $stmt->fetchAll();
  foreach($persons as $person) {
    echo $person['first_name'];
    echo $person['last_name'];
  }
});

$app->get('/people-new', function($request, $response) {
  $stmt = $this->db->query('SELECT * FROM person');
  $persons = $stmt->fetchAll();
  $this->view->addParam('persons', $persons);
  return $this->view->render($response, 'people.latte');
});
