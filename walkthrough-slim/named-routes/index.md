---
title: Named routes
permalink: /walkthrough-slim/named-routes/
---

* TOC
{:toc}

All you have to do to extend functionality of your application is add a route and its handler. But there is one small
catch, you usually call a route from many places in your templates and it is not a very good idea to use plain URL to
do this. Because you use a templating engine, you can use some kind of transformation for all in-app links. 

The reason is simple: sometimes you need to change the route definition to describe better what the route is doing,
move the route to another "module" or wrap group of routes using a common [middleware](https://www.slimframework.com/docs/concepts/middleware.html).
Other reason is localisation of your app to another language. When you change the route definition in `src/routes.php`,
you will have to change **all** links to it this route all over your source code. Take a look at following example:

~~~ php?start_inline=1
$app->get('/any/route/[{param}]', function(Request $request, Response $response, $args) {
    //some code here
});
~~~

Such route can be linked from your template with following code:

~~~ html
<a href="/any/route/123">Link to route</a>
~~~

Or from PHP code like this:

~~~ php?start_inline=1
$app->get('/any/other-route', function(Request $request, Response $response, $args) {
    return $response->withHeader('Location', '/any/route/123');
});
~~~

A better approach is to give the route a name which is unique and there is much smaller chance that you will want to
change that name in future. Hint: you should make up names which you will never change. You can also have route names
in language of your source code (many people do write their code in english although the application itself is in
another language).

~~~ php?start_inline=1
$app->get('/any/route/[{param}]', function(Request $request, Response $response, $args) {
    //some code here
})->setName('uniqueRouteName');
~~~

{: .note}
The `param` part of the URL is not mandatory thanks to squared brackets.

You can then create URLs using *router* object like this: `$this->router->pathFor('uniqueRouteName');` or this:
`$this->router->pathFor('uniqueRouteName', ['param' => '123']);` in your route handlers. But usually you rather want
to create links in your templates. You can always pass *router* object into the template and call `pathFor()` method,
but I tried to simplify this for you. I made a `{link}` macro which you can use in your templates to generate links
easily. Instead of calling `pathFor()` method on *router* object, you simply type:

~~~ html
<a href="{link uniqueRouteName}">Link to route</a>
~~~

Or with parameters:

~~~ html
<a href="{link uniqueRouteName ['param' => 123]}">Link to route</a>
~~~

{: .note}
You can find the definition of this `{link}` macro in `src/dependencies.php`.

### Task -- use named routes
1) Go through your `src/routes.php` file and make up a unique route identifier for all your routes -- use `setName()`
   method.
2) Scan your templates and replace all hardcoded routes in `<a href="...">` and `<form action="...">` tags with
   `{link}` macro.
   
{: .note}
To distinguish modules of your application, you can make up route names in form `module:action`, e.g. `people:add`,
`meeting:view` etc.

{: .solution}
~~~ php?start_inline=1
$app->get('/flintstones', function (Request $request, Response $response, $args) {
    echo "Hello World!";
});
~~~

## Routes and folder nesting
Another good reason why to use named routes and the `{link}` macro is nesting of directories and routes.
Remind yourself that when you use relative path for `href` or `src` attribute, the browser tries to append
that relative path to URL found in its address bar. For example: a page found on URL `path/or/route/123` which
renders `<a href="../other-route/456">link</a>` tag - when user clicks this link, he is redirected to URL
`path/or/other-route/456`. When a browser opens URL like this, it cannot tell by any means whether the route
is real directory tree or [`.htaccess`](/course/technical-support/#configuration-of-modrewrite) trick which
simply allows to pass any route to application which executes appropriate handler based on string matching.
It can either be a real tree structure with static `index.html` file:

    /path
    +-/or
      +-/route
        +-/123
          +-/index.html
        +-/456
          +-/index.html
       
or a PHP application with `.htaccess` file and *mod_rewrite* enabled:

    path
    +-/index.php
    +-/.htaccess
        
Because the web browser cannot distinguish between routes and physical directories, it cannot simply determine
the root of your application and you cannot use relative paths. One would expect the relative path to append to
application's real root directory, but unfortunately this does not work.

To use absolute URLs is also **not** a good remedy to this issue! You can never tell whether your application
will be executed in the root of a domain directory tree and therefore you cannot simply use URL which starts
with `/` character: `<a href="/path/or/other-route/456"></a>` -- this takes you to URL `domain.com/path/or/other-route/456`.
You always have to expect some path prefix because your application can be placed in a real subdirectory: `domain.com/~login/path/or/other-route/456`.
But this means that you have to use some magic variable (see next sections).

The `{link}` macro handles all this hard work for you. It actually generates absolute URLs **with** path to root
of your application.

## How to link images or another static content
Images and other static files are part of your application but they do not have named route. They are simply uploaded
to a server's filesystem.

I also took care of this too. You can find variable called `{$basePath}` in your templates which simply points
to a directory root of your application. Take a look into `templates/layout.latte` file where `{$basePath}`
variable is used to link Bootstrap and jQuery JS/CSS files: 

~~~ html
<link rel="stylesheet" href="{$basePath}/css/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="{$basePath}/css/bootstrap/css/bootstrap-theme.min.css">
<script type="text/javascript" src="{$basePath}/js/jquery.js"></script>
<script type="text/javascript" src="{$basePath}/css/bootstrap/js/bootstrap.min.js"></script>
~~~

## What would the code look like without named routes
It is possible to work without named routes but it is quiet confusing. Imagine that you have following route
structure in your application:
 
~~~ php?start_inline=1
$app->get('/moduleM1', function($request, $response, $args) { /*...*/ });
$app->get('/moduleM1/actionA', function($request, $response, $args) { /*...*/ });
$app->get('/moduleM1/actionB', function($request, $response, $args) { /*...*/ });
$app->get('/moduleM2/actionC', function($request, $response, $args) { /*...*/ });
~~~

HTML code for `/moduleM1`:

~~~ html
<!-- using relative URLs -->
<a href="actionA">Link to action A</a>
<a href="actionB">Link to action B</a>
<a href="../moduleM2/actionC">Link to action C on module M2</a>
<!-- using absolute URLs -->
<a href="{$basePath}/moduleM1/actionA">Link to action A</a>
<a href="{$basePath}/moduleM1/actionB">Link to action B</a>
<a href="{$basePath}/moduleM2/actionC">Link to action C on module M2</a>
~~~

HTML code for `/moduleM1/actionA`:

~~~ html
<!-- using relative URLs -->
<a href="..">Link to main</a>
<a href="../actionB">Link to action B</a>
<a href="../../moduleM2/actionC">Link to action C on module M2</a>
<!-- using absolute URLs -->
<a href="{$basePath}/moduleM1">Link to main</a>
<a href="{$basePath}/moduleM1/actionB">Link to action B</a>
<a href="{$basePath}/moduleM2/actionC">Link to action C on module M2</a>
~~~

When you use relative paths, you have to adjust **all** routes according to expected URL. Absolute paths are more
persistent but still you have to hunt and modify too many links once you decide to change the route definition which
is error prone.

## Summary
It is important to understand the principle of relative and absolute paths because there are good use-cases for both
path styles. I prepared the `{link}` macro for you in the project skeleton and you can use it along with named routes
easily to avoid reasoning about correct URL for any `href` attribute.

Both approaches stated in this chapter are inspired by [*Nette*](https://nette.org/) framework which uses `{link}` macro
and `{$basePath}` variable in __similar__ manner. You may remember that *Latte* templating engine originates from this
framework.

### New Concepts and Terms
- Named routes
- `{link routeName}` macro
- `{$basePath}` variable