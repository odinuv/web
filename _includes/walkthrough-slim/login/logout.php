<?php
$app->group('/auth', function() {
    $this->get('/profile', function(Request $request, Response $response, $args) {
        //...
    })->setName('profile');
    $this->post('/logout', function(Request $request, Response $response, $args) {
        session_destroy();
        return $response->withHeader('Location', $this->router->pathFor('index'));
    })->setName('logout');
})->add(function($request, $response, $next) {
    //...
});