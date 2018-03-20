---
title: FAQ - Frequently asked questions
permalink: /course/faq/
---

* TOC
{:toc}

This place should navigate you quickly to important sections and tries to gather answers for questions of typical
beginner. If you have any other question and you think that it should be answered here, mail [me](mailto:jiri.lysek@mendelu.cz). 

## Questions (almost) impossible to answer

### How does it all work together? I have written all the code, it works, but I do not know why!
Well, working web application is a complicated thing. Do not trust anybody who tells you opposite. You have to know
quiet a lot of technologies (e.g. HTTP, HTML, CSS, PHP, SQL and a bit of JavaScript) to build one. The advantage of
web technologies is that you only need a text-editor to code a HTML page or PHP script.

You have to study all building blocks separately and then connect all the ends together. Start with plain
[HTML](/walkthrough-slim/html-forms/), then try plain [PHP](/walkthrough-slim/backend-intro/), then generate some HTML
code in PHP script. Important part are [HTML forms](/walkthrough-slim/html-forms/) and [receiving values](/walkthrough-slim/backend-intro/receiving-values/).
Mix in some [templating engine](/walkthrough-slim/templates/) magic, add a [framework](/walkthrough-slim/slim-intro/)
and you are good to go. There is no simple answer for this, you have to study.

### Should I use framework/library A instead of framework/library B, why you teach us Slim and Latte?
Well it depends... on lot of things (e.g. state and quality of documentation, state of development -- is it still beta,
size of developer community, how deeply is the technology rooted in community, is it new or old...). I tried to choose
simple technologies which will give you a good start to learn more advanced ones later (especially frameworks).

Slim framework is simple and it suits very well for our task. For bigger application it would be better to use something
more sophisticated. Great advantage of Slim is that everything it does is traceable, there is very little magic --
e.g. database, logger and templating engine are defined in `src/dependencies.php` file. *Request* or *Response* objects
used as parameters of route handlers are [well](https://www.slimframework.com/docs/v3/objects/request.html)
[documented](https://www.slimframework.com/docs/v3/objects/response.html) and they are there to access *input* and
*output* of PHP script in object-oriented fashion. The [middleware](https://www.slimframework.com/docs/v3/concepts/middleware.html)
mechanism is also very transparent.

Latte has very convenient syntax and good support in various editors (compare with syntax of [Blade](https://laravel.com/docs/5.6/blade) --
those `@` macros look weird to me). Latte is also very secure and quiet fast. Nevertheless the templating engines are
all alike.

### My code is different than someone else's, how is that possible?
There are multiple ways how to implement anything. It is OK to have your own way. Always try to read and understand code
of other people, you can either enrich yourself with new knowledge or help somebody else. In the end, the user is most
interested whether your application works or not. 

## General questions

### What is a route or routing?
Route is a combination of HTTP method (*GET*, *POST* or others) and a path, e.g. `GET /persons` or `POST /new-person`.
Routing is a mechanism which is implemented in a framework to map routes on actual code.

Check out this [article](/articles/web/#http-protocol) and this [walkthrough](/walkthrough-slim/passing-values/#when-to-use-get-or-post-method).
Take a look at [named routes](/walkthrough-slim/named-routes/) too. 

An important note is thar routes are *virtual*, the paths in your address bar are not paths to actual files or folders.
This *magic* is enabled by [mod_rewrite](/course/technical-support/#configuration-of-modrewrite) plugin of
[Apache web server](/course/technical-support/#apache-web-server). 

### Why do we use some "framework", how does it work?
Framework is a software which defines skeleton of your project and provides some basic means to write an application
(e.g. logging and routing in Slim). Check out this [walkthrough](/walkthrough-slim/slim-intro/#project-structure).

There are many frameworks for PHP, some of them provide more functionality and some of them less -- [Slim](https://www.slimframework.com/)
is a micro-framework and does not provide much functions, but it is very easy to use.

Framework is usually created by community of developers who share similar opinions about implementation of common
functions. Each framework has [documentation](https://www.slimframework.com/docs/).

In reality, you always want to use some framework as you do not want to write your own solution for everything and you
need to deliver results in reasonable time. Great advantage is that bugs in framework's code are fixed by others (you
just update to newer version). Once you learn to use one framework, you will find easier to learn and use another one --
they all have similar core concepts.

Never write your own framework (unless you have 10+ years of experience and a team of developers and really lot of time).

## PHP questions

### My code is too long, how do I organise it?
Use [include](http://php.net/manual/en/function.include.php) or [require](http://php.net/manual/en/function.require.php)
functions. Take a look [here](/walkthrough-slim/login/#tidy-up-your-code).

### What is Composer and how do I install it?
Composer is a tool for downloading PHP libraries. You usually find a command in form `composer require someting` on
a web site of particular library which downloads the source code into `/vendor` folder.

You can read more detailed [description](/course/technical-support/#composer) or try to [use it](/walkthrough-slim/slim-intro/#task----play-with-composer).

Before you can use it on your computer, you have to install [PHP](/course/technical-support/#php-as-command-line-script-interpreter)
as command line tool.

## When to use *GET* and when to use *POST*?
Generally, *POST* should be used to modify state (obviously to modify or remove record in database, less obviously for
logout). Use *GET* whenever you want to let users revisit that same page in current state (e.g. save the link to
favourites or share URL with others).

Take a look [here](/walkthrough-slim/passing-values/#when-to-use-get-or-post-method).

## Templating engine questions

### What is templating engine and why do we use it?
Templating engine is a library which takes as input HTML code with some macros in specific syntax and generates HTML code.
We want to use it to divide PHP code and HTML code, because generating HTML in you PHP can look very ugly:

{: .solution}
{% highlight php %}
{% include /faq/ugly.php %}
{% endhighlight %}

In the example above, note that HTML in `echo` is just a string, therefore it is tedious and error prone to write code
this way.

It has many benefits:

- separation of concerns -- PHP and HTML in separate files, different people with different specialisation can work
  independently, there is an interface between template and PHP code (names of variables)
- security (no [XSS](/articles/security/xss/))
- real approach -- templating is common approach to generate HTML code

### How does template engine work
It transforms HTML code with macros to executable PHP code. The actual code that get executed is the PHP file generated
by this transformation.

Here is a quick example of templating engine input and possible output:

~~~ html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{$title|capitalize}</title>
    </head>
    <body>
        {if $something}
            <p>
                {$somethingElese}
            </p>
        {/if}
    </body>
</html>
~~~

~~~ php
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php htmlspecialchars(strtoupper($title)); ?></title>
    </head>
    <body>
        <?php if($something) { ?>
            <p>
                <?php echo htmlspecialchars($somethingElese); ?>
            </p>
        <?php } ?>
    </body>
</html>
~~~

{: .note}
That thing behind `|` is a [filter](https://github.com/nette/latte#filters) -- it is a convenient way to transform
values in template.

### How do the variables come into the template?
There is an interface between a PHP code and a template. PHP simply pushes variables into template and template tells,
what variable it needs to work (if it is documented). Templating engine usually receives an associative array.
The keys in that array are extracted and become variables in context of transformed template (actual PHP code -- see
previous question).

The tricky part is, when you need to pass an array into the template (i.e. a result of database query). Arrays in PHP
can be multi-dimensional, and you can combine associative and ordinal arrays together. See following example.

PHP code:

~~~ php?start_inline=1
$app->get(function($request, $response, $args) {
    $tplVars = [];  //an empty array
    $tplVars['title'] = 'Title of a page';  //a key title with a scalar value
    $tplVars['data'] = [    //a key data which contains another ordinal array (no keys given)
        [                   //but this array contains yet another associative arrays!
            'first_name' => 'John',
            'last_name' => 'Test'
        ],
        [
            'first_name' => 'Jane',
            'last_name' => 'Example'
        ]
    ];
    //$tplVars['data'][0]['first_name'] contains 'John'
    //$tplVars['data'][1]['last_name'] contains 'Example'
    return $this->view->render($response, 'template.latte', $tplVars);
});
~~~

Template will have access to scalar variable `$title` and array `$data`:

~~~ html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{$title}</title>
    </head>
    <body>
        {foreach $data as $v}
            <p>
                {$v['first_name']} {$v['last_name']}
            </p>
        {/foreach}
    </body>
</html>
~~~

Result that is received by the browser:

~~~ html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Title of a page</title>
    </head>
    <body>
        <p>
            John Test
        </p>
        <p>
            Jane Example
        </p>
    </body>
</html>
~~~

### Templating engine errors are difficult to read and point to strange places.
This is unfortunately true. The source of this problem comes from the general idea of templating engine itself --
it transforms HTML code with macros to executable PHP code. The actual code that get executed is the PHP file somewhere
in cache and therefore the errors are so difficult to read.

You can open the compiled template in cache and look for the line with error. You should be able to identify problem
source by the surrounding HTML code.