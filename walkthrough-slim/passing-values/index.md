---
title: Passing values
permalink: /walkthrough-slim/passing-values/
---

* TOC
{:toc}

Meaningful interaction with web application is based on ability of the client (a web browser) to pass values from the
visitor (a person) to the web server. HTTP protocol offers a few *communication styles*. These styles are called methods
and you already encountered *GET* and *POST* method earlier. There are some other methods like *PUT*, *DELETE* and
*OPTIONS* which are used for *APIs*. The combination of HTTP method and address is called a *route* in Slim -- you
can take a look at previous walkthrough article about [named routes](/walkthrough-slim/named-routes).

The main difference is that a request made with *GET* method should not have a body and **the only** way to pass values
to the server is in the URL. Thus the parameters are visible and the visitor can copy the URL and store it as favourite
or send it using e.g. email to another person which can click that link and view the site in exactly same state.

{: .note}
Of course the state of the page can also depend on values stored in [cookies or session](/articles/cookies-sessions/).

Contrary, the *POST* method usually passes values in the body of HTTP request. That makes the state of application after
a request via *POST* method unique and unrepeatable. This makes the *POST* request suitable for modifications of data
or other one time actions. And because you do not want to modify same record multiple times, you usually tell the
browser to redirect to another URL in your code after handling the *POST* request. This is explained in
[the delete chapter](/walkthrough-slim/backend-delete/#redirect-after-post).

In the case when you do not redirect using `Location` header after *POST* request, the browser behaves a bit differently:

- When the user presses enter key in address bar or navigate button, the browser just tries to fetch current URL with
  *GET* method. This can lead to an error if your application cannot handle the *GET* request to a *POST* route. 
- After pressing F5 key or reload button, the browser asks with a dialog whether to repeat the request with same payload
  of data or not. The user is told in the dialog that it might not be a good idea. It might be useless or even
  inappropriate to repeat a request as the action was already performed once.

{: .note}
The *POST* request also has a URL which can hold some parameters. Sometimes you do not need to pass any values in the
body, you just want to exploit the behaviour of the browser for *POST* method requests (to delete a record you can
simply use *POST* route with `id` parameter in URL). Or maybe you want to have two routes with same URL but with
different functionality for each HTTP method (e.g. use *GET* to display a form and *POST* to process submitted values).

## Task -- observe browser behaviour after *POST* request
Create a *GET* route with a simple form which sends some data to a *POST* route. The post rout should **not** redirect.
You can simply print incoming data using `print_r()` function. After form submission press reload and observe browser's
warning message about form re-submission.

Route definitions in `src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/passing-values/post-demo.php %}
{% endhighlight %}

Form template in `templates/post-demo.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/passing-values/post-demo.latte %}
{% endhighlight %}

## When to use *GET* or *POST* method?
Use *GET* method for actions like:

- general navigation from page to page
- search or filtering
- change of order
- pagination
- pass required parameters (such as ID of record) to **display** a form

Use *POST* method for actions like:

- register a user
- send an email
- insert or update of a record
- deletion of a record
- login and even logout to prevent [CSRF](/articles/security/csrf/)
- generally, modifications of data in a database

There can be exceptions, but they have to be justified.

## Anatomy of URL
You know the URL from browser's address bar, but usually you see only required parts of the URL. The URL can contain
much more information:

- protocol -- `http://`, `https://`, `ftp://`, ...
- username and password (optional) -- `user:pass` + `@`
- server address or hostname -- `something.com`, `127.0.0.1`, ...
- port (optional) -- `:` + `8080`
- path -- `/`, `/path/to/folder`, `/path/to/file.php`, ...
- query (optional) -- `?d=123&confirm=t`
- hash (optional) -- `#anything`

And here is an example: `http://user:password@server.com:123/path/to/a/file.php?query=param#hashValue`

# Task -- try to build full URL to you devel folder
Make a URL with login and password which can be used to open your `/~xlogin/devel` folder on Akela server.

{: .solution}
<div markdown='1'>
    You should come up with something like this: `https://xlogin:password@akela.mendelu.cz/~xlogin/devel`.
</div>

{: .note}
It is obviously not a good idea to share such URL with anybody as the login and password is clearly visible in plain
text.

## Building URLs with parameters
You typically need to build URLs in templates (in `<a>` and `<form>` tags) and less often in PHP code to perform
a redirect.

In templates use `{link}` macro introduced in the walkthrough chapter called [named routes](/walkthrough-slim/named-routes).
The `{link}` macro does not allow to define query parameters but you can simply define them as any other variable
substitution in a template:

~~~ html
<a href="{link nameOfRoute}?id={$id}">Click me!</a>
~~~

In PHP code, you usually use `Location` header to redirect (but there are some other ways -- you can generate `<meta>`
tag in the `<head>` section of page with `http-equiv="refresh"` and `content` attribute to achieve redirect too).
As described in [named routes](/walkthrough-slim/named-routes) chapter, you should use the *router* object to generate
URLs ([docs](https://www.slimframework.com/docs/objects/router.html)). Again, the `pathFor()` method generates a simple
string with URL so you can append a query parameters easily using the [string concatenation operator](http://php.net/manual/en/language.operators.string.php).

~~~ php?start_inline=1
$app->post('/some/route', function(Request $request, Response $response, $args) {
    $id = $request->getQueryParam('id');
    //do some DB stuff
    return $response->withHeader(
        'Location',
        $this->router->pathFor('anotherUniqueRouteName') . '?id=' . $id
    );
})->setName('uniqueRouteName');
~~~

{: .note}
The function of `Location` header is simple: once backend pushes such header into the response, the browser executes
a new HTTP request using *GET* method and downloads and displays content from new location. The actual response is
usually rendered for a very short moment (it might seem that it is not rendered at all). This makes reading of
occasional error reports difficult (hint: use logger or disable the `Location` header for a while).

Use `getQueryParam('paramName')` method on `$request` object to obtain value of selected parameter. More info in the
[framework docs](https://www.slimframework.com/docs/objects/request.html).

### Using route placeholders
Slim framework router can use [placeholders](https://www.slimframework.com/docs/objects/router.html#route-placeholders)
in route definitions. Placeholders are named slots in the route path and you can substitute them with a value. You can
use them similarly as query parameters. Following route definitions have placeholders for mandatory `id` and optional
`filter` values. Use `$args` array to access placeholder values.

~~~ php?start_inline=1
$app->get('/show/user/{id}', function(Request $request, Response $response, $args) {
    $id = $args['id'];
})->setName('uniqueRouteName');
~~~

~~~ php?start_inline=1
$app->get('/show/user/{id}[/{filter}]', function(Request $request, Response $response, $args) {
    $id = $args['id'];
    $filter = isset($args['filter']) ? $args['filter'] : null;
})->setName('uniqueRouteName');
~~~

You need to supply values as associative array to build a URL for a route with placeholders.

~~~ html
<a href="{link uniqueRouteName ['id' => $id, 'filter' => '2018']}">Click me!</a>
~~~

~~~ php?start_inline=1
$app->post('/process/{id}', function(Request $request, Response $response, $args) {
    $id = $args['id'];
    //do some DB stuff
    return $response->withHeader(
        'Location',
        $this->router->pathFor('uniqueRouteName', ['id' => $id, 'filter' => '2018'])
    );
});
~~~

{: .note}
Be careful when using placeholders. You can easily define very general route definition (`$app->get('/{anything}', function() { ... }`)
which would automatically collect all incoming requests belonging to other routes. 

## Passing *POST* data
This is rather simple -- use `<form>` with `method` attribute set to `post` and remember that you can also use the
`action` parameter which specifies the URL for form submission. If you specify **no** `action` parameter, then the
current location (the URL of currently displayed page) is used as value for `action` parameter.

Current location is used as `action` attribute value:

~~~ html
<form method="post">...</form>
~~~

Action with route URL generated by `link` macro and a query parameter:

~~~ html
<form method="post" action="{link routeName}?id={$id}">...</form>
~~~

To access *POST* data use method `getParsedBody()` of `$request` object. It returns an associative array with keys
and values given by form input fields.

## Summary
This chapter of the book taught you how to build URLs and how to pass values using *GET* and *POST* HTTP methods.
Everything that you read here is recapitulation from previous chapters or logical extension of knowledge that you
already have. I just wanted to put all the information related to URLs and value passing to one place.

Remember that the `{link}` macro or router's `pathFor()` method simply generates a string -- an URL for a route. You can
append query parameters to that URL very easily.

### New Concepts and Terms
- *GET* vs *POST*
- passing values via URL parameters
- passing values via *POST* data
- route placeholders