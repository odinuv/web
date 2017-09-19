---
title: Slim Backend
permalink: /walkthrough-slim/slim-backend/
---

* TOC
{:toc}

In the [previous chapter](../html-forms/), you have learned how to set up an application 
using the [Slim Framework](todo). You should now what [Composer](todo) is. You should understand
the basic Slim project structure, how to set up database credentials and where the applications
log is. In this part of the walkthrough I will show how to actually do something.

The main piece of code where you want to works is the `routes.php` file in the `src` directory.
The file already contains some code so that your application [can be tested](todo). Instead of
explaining what the code does I want you to directly start with editing it and I'll explain along
the way. Before you do any modifications, do check that your application [already works](todo).

## Adding a New Route
The `routes.php` file contains (as the name suggest **routes**). A *route* is a combination
of [HTTP method](todo) and [URL](todo). For example `GET http://example.com/my-list/` is route. 
Because most applications are independent on the domain they run on, the route in the application 
is written as `GET /my-list/`. If the application understands **handles** the route, it means that
understands it and it shows something to the end-user. Otherwise the URL does not exist and the
end-user will see a 404 Not Found error.

The `routes.php` file contains all the routes, your application can handle. Let's look at a simple
route:

{% highlight php %}
$app->get('/hello', function (Request $request, Response $response, $args) {
    echo "Hello World!";
});
{% endhighlight %}

Go ahead and add this piece of code at the end of your `routes.php` file. Upload the changed file to
the server (if necessary) and visit the `/hello` URL. You should see a "Hello World!" message in your
browser. 

The `$app` variable contains the 
[Slim Application](https://www.slimframework.com/docs/objects/application.html) object. The 
variable is already initialized elsewhere (in `public/index.php` file) so it is ready to use.
The Application has a method `get` (and also `post`, `put` and other [HTTP verbs](todo)) 
which configures a route. The method 
[accepts two parameters](https://www.slimframework.com/docs/objects/router.html#how-to-create-routes).
The first is the name of the route and the second is the a function which handles the 
route --- a callback (something that is *called back* when a request to that particular route is made).
Because the above code may still look a little bit messy, let's separate it:

The call to the `get` function is:

{% highlight php %}
$app->get('/hello', callback);
{% endhighlight %}

And the callback defintion is:

{% highlight php %}
function (Request $request, Response $response, $args) {
    echo "Hello World!";
}
{% endhighlight %}

If you read the introduction about [functions](todo), you may still be missing the 
name of the function. This is correct, because the callback --- as we used it in the
`routes.php` file was defined as an **anonymous function**. To write the equivalent code
without using an anoynmous function you would have to do:

{% highlight php %}
function handleGetHello (Request $request, Response $response, $args) {
    echo "Hello World!";
}

$app->get('/hello', handleGetHello);
{% endhighlight %}

This is also acceptable, but is unnecessarily verbose, because the function
`handleGetHello` will ever be used only in one place. Therefore the piece of
code which I stareted with is used much more often.


{% highlight php %}
{% include /walkthrough-slim/slim-backend/routes.php %}


<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/[{name}]', function (Request $request, Response $response, $args) {
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
{% endhighlight %}

