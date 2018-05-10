---
title: Flash messages
permalink: /walkthrough-slim/flash-messages/
---

* TOC
{:toc}

There is a small problem with redirecting user after a *POST* action: you usually want to display some kind of
confirmation (or error) message once the user is redirected to the next page. It is a good practice to inform a user
about success or failure of his action. Because of the redirect, it is not easy to pass a message along. There are
few options what you can do:

- **Not**-redirect the *POST* route to *GET* route and display message as result of *POST* route -- bad idea, leads to
  duplication of code, problems with reload (repeated execution).
- Use query parameter to pass concrete message, e.g. `/another-route?message=Successfully created.` -- but the user can
  play with value of the message, possible [XSS](/articles/security/xss/) vulnerability.
- Use query parameter in redirect URL to trigger display of a message, e.g. `/another-route?m=1` -- annoying, you have
  to determine which message to display.
- Put a note into [`$_SESSION`](/articles/cookies-sessions/#sessions) array to display a message on next
  opportunity -- this is actually the best solution so far, but do not try to implement it by yourself, there is a lot
  of libraries for that.

Let's take a look at the problem again: displaying errors is often easy, as you generally re-render a form, you can
easily pass error messages into a template and display them:

~~~ php?start_inline=1
$app->get('/some-route', function(Request $request, Response $response, $args) {
    //render the form without error message
    return $this->view->render($response, 'some-route.latte');
})->setName('some');

$app->post('/some-route', function(Request $request, Response $response, $args) {
    $data = $request->getQueryParam();
    if(everyhing_is_fine($data)) {
        try {
            //insert record into DB or update DB record
            //...
            //redirect to GET route
            return $response->withHeader('Location', $this->router->pathFor('anotherRoute'));
        } catch(Exception $e) {
            //set custom error message and log exception
            $tplVars['error'] = 'Some DB exception.';
        }
    } else {
        //set custom error message
        $tplVars['error'] = 'You missed some input fields.';
    }
    //re-render the form here with message and form fields
    $tplVars['form'] = $data;
    return $this->view->render($response, 'some-route.latte', $tplVars);
});

$app->get('/another-route', function(Request $request, Response $response, $args) {
    //we need to display a message in this route which confirms previous POST action somehow
})->setName('anotherRoute');
~~~

Template `some-route.latte`:

~~~ html
<!-- display error only when the variable $error is present -->
{if isset($error)}
<p>{$error}</p>
{/if}
<form method="post">
    <!-- some fields and submit button -->
</form>
~~~

This approach is not very systematic, but works fine. The problem lies in the `return $response->withHeader('Location', $this->router->pathFor('anotherRoute'));`
line, because in that case, the target route does not know where the visitor is coming from and does not know that
it should display any message.

You have to think about each route as if it is a completely separate piece of code. Each HTTP request is handled by only
one route implementation and only one script execution. It is therefore impossible to pass values between routes via
ordinary PHP variable. This is not possible, because PHP script is re-executed for each HTTP request and the state of
variable `$a` in following example is forgotten in subsequent requests:

~~~ php?start_inline=1
//a variable which can be accessed by both routes (via use() statement)
$a = 0;
//you either execute this route and the program ends and frees up all its memory...
$app->get('/first-route', function(Request $request, Response $response, $args) use ($a) {
    $a = $a + 5;    //$a is 5 now
    return $response->withHeader('Location', $this->router->pathFor('anotherRoute'));
});
//...or this route and the program ends and frees up all its memory
$app->get('/second-route', function(Request $request, Response $response, $args) use ($a) {
    echo $a;        //$a is back to 0
})->setName('anotherRoute');
~~~

Sorry for that, you have to think about PHP scripts in a bit different way -- the PHP is not an application which runs
all the time on the server, it only runs for the given time when it is handling the HTTP request. When there are no
requests, the PHP application is just a bunch of files on server's hard drive. Applications written in Java, Python or
JavaScript work differently -- they are in fact active even when there are no incoming HTTP request. But they also
have to implement their own HTTP server.

## Installing flash messages library
Each framework has an ecosystem of libraries which extends its functionality. It is a good idea to search for flash
message implementation curated especially for Slim framework.

### Task -- install the library using composer
Go to documentation page of [`slim/flash` package](https://www.slimframework.com/docs/v3/features/flash.html) and
install it using `composer require` command. You have to have [Composer](/course/technical-support/#composer) installed on your PC.

{: .solution}
~~~
composer require slim/flash
~~~

Next step is to register `flash` as dependency of your application in `src/dependencies.php`.

{: .solution}
~~~ php?start_inline=1
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
~~~

You should be able to reference the library in routes and middleware by using `$this->flash` now.

## Using the library
You probably saw the example in the documentation of the library. You should have noticed `addMessage()` and
`getMessages()` methods. Their names are self-describing. Unfortunately the docs does not explain anything more about
principle of flash messages.

Messages are either "positive" or "negative". They can also be in other category, but these two are definitely the
most general ones. You usually want to visually distinguish positive and negative messages (you can use
[Bootstrap's](/walkthrough-slim/css/bootstrap/) `alert alert-danger` and `alert alert-success` classes on a paragraph).
For this reason, a good flash message library uses so called *message bags* to differentiate between categories
of messages -- that is the first argument of `addMessage()` method. A message bag is just an array named by the
programmer.

The `addMessage()` method actually stores the message into a $_SESSION under the given *message bag* name. You can check
it out using this commands:

~~~ php?start_inline=1
$this->flash->addMessage('success', 'Successfully performed an action!');
print_r($_SESSION);
exit;
~~~

There should be a `slimFlash` key in the printout of `$_SESSION` variable and inside that is another key called
`success`.

The `getMessages()` method simply retrieves that array from session and erases it, so the user won't be confused
after he navigates to another page by a forgotten flash message.

### Task -- set flash message in *POST* route and display it after redirect
Pick some *POST* route which you already have defined in your application. You should select a *POST* route which
redirects after a success. Add row which sets the *flash message* with appropriate *message bag* name.

{: .solution}
~~~ php?start_inline=1
$app->post('...', function(Request $request, Response $response, $args) use ($a) {
    try {
        //insert or modify record in database
        //...
        //set flash message
        $this->flash->addMessage('success', 'Successfully performed an action!');
        //redirect
        return $response->withHeader('Location', $this->router->pathFor('...'));
    } catch(Exception $e) {
        $this->logger->error($e->getMessage());
        $tplVars['error'] = $e->getException();
    }
    //re-render template
    return $this->view->render($response, 'template.latte', $tplVars);
});
~~~

Following step is to display flash messages. You can either display flash messages in layout template globally which
might be very convenient, because you do not have to worry about retrieving flash messages from their storage, or
hand-pick routes which should display them. You can register a middleware to pass flash messages to each possible
template.

Register middleware to pass flash messages into Latte templates in `middleware.php`, use
[`addParam()` method](https://github.com/ujpef/latte-view#addparamname-param) described in *latte-view* documentation:

{: .solution}
~~~ php?start_inline=1
$app->add(function (Request $request, Response $response, callable $next) {
    $this->view->addParam('flash', $this->flash);
    return $next($request, $response);
});
~~~

Display messages in `layout.latte`:

{: .solution}
~~~ html
{var $fm = $flash->getMessages()}
{if !empty($fm['success'])}
    {foreach $fm['success'] as $m}
        <p>{$m}</p>
    {/foreach}
{/if}
{if !empty($fm['error'])}
    {foreach $fm['error'] as $m}
        <p>{$m}</p>
    {/foreach}
{/if}
~~~

{: .note}
The `getMessages()` method always picks and erases flash messages from session storage. Notice that I used this method
in the template, not in the middleware -- the middleware only passes the flash object into template scope. In the
middleware, you cannot be 100% sure, whether the actual route will or will not render a template based on given layout.

### Task -- observe behaviour of flash messages
Because flash messages are stored in session and the `getMessages()` method clears that storage, they are displayed only
once. You should observe that after redirect, the message or messages are present and after reload of the page, the
flash messages are gone.

## Summary
Flash messages are a useful concept which you can use to display one-time confirmation or error messages. Before you
try to implement flash messages by yourself, try to find library which plays along with your framework.

### New Concepts and Terms
- Flash messages

### Control question
- Why and when use flash messages?
- What are message bags?
- Where and when display flash messages? 