<?php
$app->group('/auth', function() {
    $this->get('/profile', function(Request $request, Response $response, $args) {
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