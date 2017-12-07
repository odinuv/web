<?php
$app->group('/auth', function() use($app) {
    $app->post('/logout', function(Request $request, Response $response, $args) {
        session_destroy();
        return $response->withHeader('Location', $this->router->pathFor('login'));
    })->setName('logout');
})->add(function($request, $response, $next) {
    //...
});