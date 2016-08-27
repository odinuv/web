---
title: Templates
permalink: /en/apv/walkthrough/templates/
---

* TOC
{:toc}

If you look at the last [version of the contact form], you probably noticed that
it is becoming quite a convoluted mess of PHP and HTML (and yet it is still a very
simple form). The solution to this problem is to use [**(HTML) templates**](todo).

The advantage of templates is that it simplifies both the PHP and HTML code and
that it protects your code against [Cross Site Scripting vulnerabilities](todo).
The disadvantage of templates is that you need to learn another language. HTML
templates are called templates, because they are HTML pages with placeholders. The
actual value of the placeholders is supplied when the template is *rendered*
(which usually means -- sent to web browser). Only then the template becomes as
valid HTML page.

## Templating Engines
A template engine is a library which processes a HTML page with **macros**
(snippets of template language) and produces a valid HTML page.z\
There are many templating engines available for PHP, some of the popular engines
are: *Smarty*, *Latte*, *Twig*. All of them (and many others) can be used as
parts of their respective [frameworks](todo) or standalone. In the following
examples I will stick to using standalone *Latte* templating engine. The
choice is rather arbitrary, as all templating engines work in very similar way, have
almost the same features and they even have somewhat similar syntax.

### Getting Started with Latte
First you need to obtain Latte, either by using [composer](todo) or simply by
**downloading the library** from [Github](todo):

![Screenshot -- Download Latte](/en/apv/walkthrough/templates/download-latte.png)

You should get [latter-master](/en/apv/walkthrough/templates/latte-master.zip) and
copy the contents of the `src` folder to your script. Now create a PHP script like this:

{% highlight php %}
{% include /en/apv/walkthrough/templates/template-1.php %}
{% endhighlight %}

And a template file `template-1.latte` like this:

{% highlight html %}
{% include /en/apv/walkthrough/templates/template-1.latte %}
{% endhighlight %}

Now, lets see what happened. The template looks like a standard HTML document (with file extension
`latte`), there are
some additional features however. In the template above I used `{$pageTitle}` which
prints the contents of a template variable `$pageTitle`.

Now for the PHP script -- first statement `require 'latte.php';` instructs PHP to include file
`latte.php` in the same directory as your script. The `latte.php` is part of Latte Templating
engine and makes sure that the library is available in your script. Next we [create
an instance](todo) of the `Engine` class: `$latte = new Latte\Engine();`. Note that the
class `Engine` is in [namespace](todo) `Latte\`.
Next we create an [associative array](todo) `$templateVariables` with value `'Template engine sample'`
assigned to the `pageTitle` key.
On the last line, we call the `render` [function](todo) of Latte engine and pass it filename of the
template (`template-1.latte`) and the array of $templateVariables.

As you can see, **the variables used and available in the template must be passed via an associative
array to the `render` method**.

### Macros
Template engine offers plenty of [macros](https://latte.nette.org/en/macros) which simplify
generation of the HTML code. In the above example, I used the `{$variable}` macro. Let's see
some more examples:

{% highlight php %}
{% include /en/apv/walkthrough/templates/template-2.php %}
{% endhighlight %}

Template file `template-2.latte`:

{% highlight html %}
{% include /en/apv/walkthrough/templates/template-2.latte %}
{% endhighlight %}

There are two options how the macros can be written in latte. In the template above, the
flintstones array is printed using the longer syntax `{foreach}{/foreach}` and `{if}{/if}`
which is more similar to PHP syntax. The rubbles array is printed using the shorter
syntax `n:foreach` and `n:if`, which less disturbs the flow of the HTML code.

The statement `{$role|capitalize}` applies the built-in Latte `capitalize`
[filter](https://latte.nette.org/en/filters).

In the PHP code, I need to define all the variables: `$flintstones`, `$rubbles`, `$pageTitle` and
`$showBold` in an associative array. I took the liberty to shorten the name of the
variable `$templateVariables` to just `$tplVars`.

## Task -- Contact form
Let's convert the [contact form](todo) we did in previous chapter.

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/templates/form-5.php %}
{% endhighlight %}

Template file `form-5.latte`:

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/templates/form-5.latte %}
{% endhighlight %}

{: .note}
I simplified the condition
`if ($templateVariables['currentUser']['firstName'] != '')` to
`if ($templateVariables['currentUser']['firstName'])` because, the
automatic [boolean conversion](todo) allows us to do it.

{: .note}
You need to convert the entities &lt; and &gt; in the message back to to characters `<` and `>`. Now
Latte does this conversion automatically for you.

## Task -- Person Form
Using templates, create a form like the one below. Assume that you have a variable `$person`
which contains the default values for form inputs. The `person` variable should be an associative
array with keys `id`, `first_name`, `last_name`, `nickname`, `birth_day`, `height`.

{: .solution}
{% highlight php %}
// This is not a solution, only a hint, how the PHP script should start
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
{% endhighlight %}

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/templates/person-form.php %}
{% endhighlight %}

Template file `person-form.latte`:

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/templates/person-form.latte %}
{% endhighlight %}


## Summary
While using a template engine requires you to learn its' macro language, it
does lead to a cleaner [and safer](todo) HTML and PHP code. You don't need to struggle so much
with using [proper quotes](todo). However when using templates, don't forget that
the variables defined inside a template are only those passed in array to the
`render` method! Variables from the PHP script are not available in the
template automatically. Also keep in mind that while HTML Template is very similar to
a HTML page, it cannot be interpreted by the web browser, only the corresponding template
engine is capable of processing it and producing a valid HTML page.

You should now be familiar with the principle of a PHP template engine and you
should be aware of the benefits of using a template engine.
You should be able to use basic macros for inserting variables in a template and working
with conditionals and loops in Latte templates (either syntax).

### New Concepts and Terms
- Templates
- Latte
- Macros
- Template Variables
