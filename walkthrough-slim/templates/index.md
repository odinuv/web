---
title: Templates
permalink: /walkthrough-slim/templates/
---

* TOC
{:toc}

In the [previous chapter](../slim-backend/), you have learned how to handle HTTP requests with
[Slim Framework](https://www.slimframework.com/). You should be able to create your own routes and access values entered
in HTML forms by the end-user. I have also discouraged you from generating HTML pages 
directly within the route handlers.

In theory, generating a HTML page is nothing complicated. In practice, it gets cluttered quickly 
and it is prone to [Cross Site Scripting attacks](/articles/security/xss/) and other errors. The solution to
this is to use templates.

The advantage of using templates is that they simplify both the PHP and HTML code and
that they protect your code against [Cross Site Scripting vulnerabilities](/articles/security/xss/).
The templates disadvantage is that you need to learn another language. HTML
templates are called templates, because they are HTML pages with placeholders. The
actual value of the placeholders is supplied when the template is *rendered*
(which usually means -- sent to a web browser). Only then the template becomes a
valid HTML page that is sent to the web client. Then it is HTML page is *rendered* on the
end-user's screen. 

{: .note}
Yes, there are two renderings. First the template is rendered into an HTML page. Second the
HTML page is rendered on the user screen. Each is a completely different process, but they are
called the same. Here, we'll be working with the first one.

## Templating Engines
Template engine is a library which processes an HTML page with **macros**
(snippets of a template language) and produces a valid HTML page.
There are many templating engines available for PHP, some of the popular engines
are: [*Smarty*](https://www.smarty.net/), [*Latte*](https://latte.nette.org/en/), 
[*Twig*](https://twig.symfony.com/). All of them (and many others) can be used as
parts of their respective [frameworks](../slim-intro/) or standalone. In the following
examples I will stick to using the standalone *Latte* templating engine. The
choice is rather arbitrary, as all templating engines work in a very similar way, have
almost the same features and they even have a somewhat similar syntax.

### Getting Started with Latte
If you followed the previous steps --- if you used the 
[prepared skeleton](https://bitbucket.org/apvmendelu/slim-based-project/src/master/) --- I have good news for you. Latte is ready to use in your project.
Actually, you should already have a route in you `routes.php` file similar to one below:

~~~ php?start_inline=1
<?php 
$app->get('/sample', function (Request $request, Response $response, $args) {
    // Render sample view
    return $this->view->render($response, 'sample.latte');
});
~~~

So what does the line `$this->view->render($response, 'sample.latte');` do ? 
It uses the `view` property of the Slim application, which happens to be a
little [utility class](https://github.com/ujpef/latte-view). Its most important method is 
`render` which takes a response object and a name of template file and returns 
a response object with a rendered HTML page. That means we can directly return the 
response in the handler and it will be sent to the web client. The name of the 
template file refers to a file in the `templates` directory. 
Go ahead and visit the `/sample` URL in your application. If it works, your 
application just used a Latte template.

### Templates
In the the `templates` directory, you should have a file named `sample.latte` 
with contents similar to this:

{% highlight html %}
{% include /walkthrough-slim/templates/sample.latte %}
{% endhighlight %}

The template code is HTML document with placeholders or [macros] enclosed in 
curly braces `{}`. Everything in curly braces is Latte, everything else is 
plain old HTML. In the above template, there are the following pieces of Latte code:

- `{extends layout.latte}` --- a reference to **layout template** (see below)
- `{block title}...{/block}` and `{block body}...{/block}` --- code which defines contents of a template block, the block itself is defined in the layout template
- `{link sample-process}` --- a `link` [macro](/walkthrough-slim/named-routes/)

To understand what the **layout template** is and how **blocks** work, you have to look 
in `layout.latte` file:

{% highlight html %}
{% include /walkthrough-slim/templates/layout.latte %}
{% endhighlight %}

The above is also a latte template, it contains only two pieces of Latte code
`{include title}` and `{include body}`. Otherwise it is a valid HTML page
(though rather empty). Both blocks of code use the [`include` macro](https://latte.nette.org/en/macros#toc-file-including) which
defines a block of the given name (`title` and `body`) and expects some other
template to fill in their contents. And that is exactly what the `sample.latte`
template does. It takes the `layout.latte` template and then fills in the
missing pieces for `title` and `body`. 

Sounds complicated? Can't you put all the HTML code in one template? Why bother with
the blocks? The answer is laziness. Imagine that your application contains 30 pages
(not that much actually). Each one of them will contain the same HTML header
as you can see in the layout template (the header loads 
[Bootstrap](../css/bootstrap/) and [jQuery](/articles/javascript/jquery/) libraries). Sure, you 
can copy it 30 times, but what if you later need to add another library in all your pages?

In short, using layout templates allows you to share common code, which in turn
allows you to save hell of a time. Also it helps to reduce repeated, which allows you
to concentrated only on the important stuff.

### Macros
Template engine offers plenty of [macros](https://latte.nette.org/en/macros) which simplify
generation of the HTML code. In the above example, I used the `{extends}` 
(uses a layout template), `{block}` (defines a block) and `{include}` (includes a block) 
macros. However, the most important is the `{$variable`} macro, which allows you to 
safely (without the possibility of a [Cross Site Scripting attack](/articles/security/xss/)) insert 
parameters in the HTML code. Try adding the following route in your application:

~~~ php?start_inline=1
<?php
$app->get('/variables', function (Request $request, Response $response, $args) {
	$this->view->addParam('pageTitle', 'Template engine sample');
	return $this->view->render($response, 'sample-1.latte');
});
~~~

Template file `sample-1.latte`:

{% highlight html %}
{% include /walkthrough-slim/templates/sample-1.latte %}
{% endhighlight %}

The template expects the `pageTitle` variable (parameter) and puts it in the `<title>` and
`<h1>` elements. The route handler must provide value for the variable, which is 
done using the `$this->view->addParam` call. The first argument of the `addParam`
method is the name of the variable (`pageTitle`) and the second parameter is 
an arbitrary value.

### Task -- Simplify Template
Have you noticed that the `sample-1.latte` template in the above example is not 
using the layout template? Go ahead and modify it so that it uses it.

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/templates/sample-2.latte %}
{% endhighlight %}

### Advanced Macros
You can put comments in the templates as well:

{% highlight html %}
{* this is a comment *}
{% endhighlight %}

Contrary to comments in HTML, comments in templates will not be contained in the resulting page.
There are also more complicated macros:

{% highlight html %}
{% include /walkthrough-slim/templates/flintstones-1.latte %}
{% endhighlight %}

And a corresponding route to fill in the parameters:

{% highlight php %}
{% include /walkthrough-slim/templates/flintstones-1.php %}
{% endhighlight %}

There are two options how the macros can be written in latte. In the template above, the
flintstones array is printed using the longer syntax `{foreach}{/foreach}` and `{if}{/if}`
which is more similar to the PHP syntax. The rubbles array is printed using the shorter
syntax `n:foreach` and `n:if`, which disturbs the flow of the HTML code much less. The
choice is yours.

The statement `{$role|capitalize}` applies the built-in Latte `capitalize`
[filter](https://latte.nette.org/en/filters). Be sure to check the 
[manual](https://latte.nette.org/en/macros) for other useful features.
In the PHP code, I need to define all the variables: `$flintstones`, `$rubbles`, `$pageTitle` and
`$showBold`.

### Task -- Simplify Template
For the sake of practicing, go ahead and again simplify the `flintstones-1.latte` template
so that it uses the layout template.

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/templates/flintstones-2.latte %}
{% endhighlight %}

It is also possible to simplify the PHP code a little bit, if you 
pass all the template variables as an [associative array](/walkthrough-slim/backend-intro/array/).

{% highlight php %}
{% include /walkthrough-slim/templates/flintstones-2.php %}
{% endhighlight %}

In the PHP code, I need to define all the variables: `$flintstones`, `$rubbles`, `$pageTitle` and
`$showBold` in an associative array. I have taken the liberty to shorten the name of the
variable `$templateVariables` to just `$tplVars`.

If you find passing variables between a PHP script and a template confusing, have a look at
the following schema.

{: .image-popup}
![Schematic of template variables](/walkthrough-slim/templates/template-schema.svg)

## Task -- Contact form
Let's convert the [contact form](../backend-intro/array/#task----improve-contact-form)
we did in one of the [earlier chapter](../backend-intro/array/) into a template.

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/templates/contact-form.php %}
{% endhighlight %}

Template file `form-5.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/templates/contact-form.latte %}
{% endhighlight %}

{: .note}
I have simplified the condition
`if ($templateVariables['currentUser']['firstName'] != '')` to
`if ($templateVariables['currentUser']['firstName'])` because the
automatic [boolean conversion](/walkthrough-slim/backend-intro/#boolean-conversions) allows us to do it.

{: .note}
You need to convert the entities &amp;lt; and &amp;gt; in the message back to the characters `<` and `>`.
Now Latte does this conversion automatically for you.

## Task -- Person Form
Using templates, create a form like the one below. Assume that you have a variable `$person`
which contains the default values for the form inputs. The `person` variable should be an associative
array with the keys `id`, `first_name`, `last_name`, `nickname`, `birth_day`, `height`.

{: .solution}
~~~ php?start_inline=1
<?php
// This is not a solution. It is only a hint, what the PHP script should contain
// Existing user
$person = [
    'id' => 123,
    'first_name' => 'John',
    'last_name' => 'Doe',
    'nickname' => 'johnd',
    'birth_day' => '1996-01-23',
    'height' => 173,
];
/*
// New user
$person = [
    'id' => null
    'first_name' => '',
    'last_name' => '',
    'nickname' => '',
    'birth_day' => null,
    'height' => null,
];
*/
~~~

{: .solution}
<div markdown='1'>
Wondering about the route name? `add-person` or `person-add` are good URLs.
</div>

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/templates/person-form.php %}
{% endhighlight %}

Template file `person-form.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/templates/person-form.latte %}
{% endhighlight %}

## Summary
Using a template engine requires you to learn its macro language. However it
does lead to a cleaner [and safer](/articles/security/xss/) HTML and PHP code. You don't need to struggle so much
with using [proper quotes](../backend-intro/#working-with-strings).
When using templates, don't forget that
the variables defined inside a template are only those passed via the `addParam` or
`addParams` methods! Variables from the PHP script are not available in the
template automatically. Also keep in mind that while a HTML Template is very similar to
a HTML page, it cannot be interpreted by the web browser, only the corresponding template
engine is capable of processing it and producing a valid HTML page.

Now you should be familiar with the principle of a PHP template engine and you
should be aware of the benefits of using a template engine.
You should be able to use basic macros for inserting variables in a template and working
with conditionals and loops in Latte templates (either syntax).

### New Concepts and Terms
- Templates
- Latte
- Macros
- Template Variables

### Control question
- Why use templates?
- Are templates slower than plain PHP (using `echo`)?
- Can you define yor own macro of filter?
- What is the interface between template and PHP code?
- How does a template obtain its variables?
- What is the result of template rendering?