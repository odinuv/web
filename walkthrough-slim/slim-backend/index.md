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

And the callback definition is:

{% highlight php %}
function (Request $request, Response $response, $args) {
    echo "Hello World!";
}
{% endhighlight %}

{: .note}
The last line of the original function `});` is particularly confusing because `}` 
belongs to the handler, and `);` belongs to the `$app->get` call.

If you read the introduction about [functions](todo), you may still be missing the 
name of the function. This is correct, because the callback --- as we used it in the
`routes.php` file was defined as an **anonymous function**. To write the equivalent code
without using an anonymous function you would have to do:

{% highlight php %}
function handleGetHello (Request $request, Response $response, $args) {
    echo "Hello World!";
}

$app->get('/hello', 'handleGetHello');
{% endhighlight %}

{: .note}
There function `handleGetHello` in the `$app->get` line is passed as a string. If you write 
`handleGetHello()`, you immediatelly call the function. However, in this case we want to call 
the function only when something happens (i.e when a particular HTTP request is encountered). 
So we only tell the `$app->get` function what function it should call when it needs to.

The above code is also acceptable, but is unnecessarily verbose, because the function
`handleGetHello` will ever be used only in one place. Therefore the piece of
code which I started with is used much more often.

### Request and Response
In the above simple request handler, you don't have to worry about the
 `Request $request, Response $response, $args` stuff in the handler. Now let's see what 
 it is good for. Every request handler (regardless of the URL and HTTP method) has the
 same [*signature*](todo):

{% highlight php %}
function (Request $request, Response $response, $args) {}
{% endhighlight %}

This means that the handler takes 
[three parameters](https://www.slimframework.com/docs/objects/router.html#route-callbacks):

- an object representing the HTTP request (generated automatically by the Slim framework)
- an object representing the HTTP response (empty and expected to be filled by the handler)
- a list of values for [route placeholders](todo)

The notation `Request $request` means that the argument `$request` is of type `Request`. 
This is called a 
[type declaration](http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration) 
(or type hint) in PHP. The `Request` class actually refers to the
`\Psr\Http\Message\ServerRequestInterface` class. This is done in the very beginning of the 
`routes.php` file by the line `use \Psr\Http\Message\ServerRequestInterface as Request;`. The 
`\Psr\Http\Message\ServerRequestInterface` class is part of 
[PHP specification](http://www.php-fig.org/psr/psr-7/). 

This probably sounds a lot complicated. But there are few important points to understand:

- The route handler has access to everything sent in the HTTP request in some object in the `$request` variable.
- The route handler is expected to write the response in the HTTP response represented by some object in the `$response` variable.

{: .note}
In the first example, I didn't use the `$response` object, and instead I used `echo` directly to write 
to the output. Yes, that is a shortcut, which is possible too.

## Working With Request and Response
Working with Request and Response is important when you need to get some data from the end-user. 

### Task --- Create a Simple Form
Now create another route, name it e.g. `/enter-name` and make sure it outputs a simple
[HTML Form] with a text field and a button.

{: .solution}
{% highlight php %}
$app->get('/enter-name', function (Request $request, Response $response, $args) {
    echo "
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset='utf-8'>
            <title>Enter Name</title>
        </head>
        <body>
            <form method='post'>
                <input type='text' name='name'>
                <button type='submit' name='save'>Send</button>
            </form>
        </body>
    </html>";
});
{% endhighlight %}

Note that the part `method='post'` is important for the next bit.
Now if you visit the url `/enter-name` in web browser, you should see the form. 
Fill it in and click the button. You should see an error:

    Method not allowed. Must be one of: GET, GET

This means exactly what it says. Your application was able to recognize the URL
and find a corresponding route, but that route does not allow the particular 
[HTTP method](todo) you used in the request --- the `POST` method (as specified in
`method='post` in the `<form>` field). This is expected, because we used
`$app->get('/enter-name', ...` in our route.

### Task -- Add a POST Handler
The solution is to add another route for the same URL and method `post`. This route
will handle the HTTP request created when the form is submitted. Use the following
code as the body of the handler:

{% highlight php %}
    $input = $request->getParsedBody();
    echo "The end-user entered name:" . $input['name'];
{% endhighlight %}

{: .solution}
{% highlight php %}
$app->post('/enter-name', function (Request $request, Response $response, $args) {
    $input = $request->getParsedBody();
    echo "The end-user entered name:" . $input['name'];
});
{% endhighlight %}

Now when you send the form, you'll

{% highlight php %}
{% include /walkthrough-slim/slim-backend/routes.php %}

Whi

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

