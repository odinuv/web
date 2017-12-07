<?php
$app->group('/auth', function() use($app) {
    $app->get('/', function(Request $request, Response $response, $args) {
        //URL: /auth/
        //...
    })->setName('index');
    $app->get('/profile', function(Request $request, Response $response, $args) {
        //URL: /auth/profile
        return $this->view->render($response, 'profile.latte', [
            'user' => $_SESSION['user']
        ]);
    })->setName('profile');
})->add(function($request, $response, $next) {
    if(!empty($_SESSION['user'])) {
        return $next($request, $response);
    } else {
        return $response->withHeader('Location', $this->router->pathFor('index'));
    }
});

$app->route('/', function(Request $request, Response $response, $args) {
    //redirect to index (can divert to login without authorisation data in $_SESSION)
    return $response->withHeader('Location', $this->route->pathFor('index'));
});