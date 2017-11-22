---
title: Named routes
permalink: /walkthrough-slim/named-routes/
---

* TOC
{:toc}

Web applications have usually some kind of navigation bar (a menu). It is useful to highlight or in any other
way visually distinguish currently active item from others. This short article is about determining which menu item
should be highlighted.

The reasoning about this issue is hard because you have one common template with menu and you have to highlight
one given `<a>` tag. It means, that you have to treat every possible state of that menu. Let's look at an example,
the menu that is in `templates/layout.latte` can simply look like this:

~~~ html
<nav>
    <a href="{link index}">List of persons</a>
    <a href="{link add}">Add new person</a>
</nav>
~~~

The problem is, that the menu elements does not look different whether you visit *List of persons* or *Add new person*
page. But the menu is always there, so we need to cover every possible situation (i.e. the `index` route is active or
`add` route is active -- only one route can be active at a time). We need to build something like this to achive
desired behaviour:  

~~~ html
<nav>
    <a href="{link index}">
        {if $routeName == 'index'}
            <strong>List of persons</strong>
        {else}
            List of persons
        {/if}
    </a>
    <a href="{link add}">
        {if $routeName == 'add'}
            <strong>Add new person</strong>
        {else}
            Add new person
        {/if}
    </a>
</nav>
~~~

This template code universally highlights the menu item that currently matches some variable called `$routeName`.
It is possible to provide this variable in every route by hand (`$tplVars['routeName'] = 'currentRouteName';`),
but there is a better and more universal way. Slim framework provides us with *request* object, which also contains
information about a route. You can access this object and get route name using `$request->getAttribute('route')->getName()`
method. But again, it is tedious to do this in every route. We can use [middleware](https://www.slimframework.com/docs/concepts/middleware.html)
mechanism of the framework to construct a new middleware which injects `$routeName` variable into every template
and do not think about this anymore.

{: .note}
It is a good practice to make some effort and avoid duplication of code whenever it is possible.

To achieve this, start with modification of settings in `src/settings.php` file and add key called
`determineRouteBeforeAppMiddleware` to the end of settings file:

~~~ php?start_inline=1
return [
    'settings' => [
        //... some other settings ...
        'determineRouteBeforeAppMiddleware' => true,
    ],
];
~~~

Than add new middleware in `src/middleware.php`:

~~~ php?start_inline=1
use Slim\Exception\NotFoundException;

$app->add(function (Request $request, Response $response, callable $next) {
    $route = $request->getAttribute('route');
    if (empty($route)) {
        throw new NotFoundException($request, $response);
    }
    //inject routeName to template variables
    $this->view->addParam('routeName', $route->getName());
    return $next($request, $response);
});
~~~

{: .note}
Presented steps are inspired by [Slim cookbook article](https://www.slimframework.com/docs/cookbook/retrieving-current-route.html).

## Summary
Now your application should highlight currently active menu item. You will learn how to make the highlight look even
better in the upcoming [CSS](/walkthrough-slim/css) or [Bootstrap](/walkthrough-slim/css/bootstrap) article.

### New Concepts and Terms
- Named routes
- `{link routeName}` macro
- `{$basePath}` variable