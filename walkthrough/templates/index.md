---
title: Templates
permalink: /walkthrough/templates/
redirect_from: /en/apv/walkthrough/templates/
---

* TOC
{:toc}

If you look at the last
[version of the contact form](/walkthrough/backend-intro/array/#task----improve-contact-form),
you have probably noticed that
it is becoming quite a convoluted mess of PHP and HTML (and yet it is still a very
simple form). The solution to this problem is to use **(HTML) templates**.

The advantage of using templates is that they simplify both the PHP and HTML code and
that they protect your code against [Cross Site Scripting vulnerabilities](/articles/security/xss/).
The templates disadvantage is that you need to learn another language. HTML
templates are called templates, because they are HTML pages with placeholders. The
actual value of the placeholders is supplied when the template is *rendered*
(which usually means -- sent to a web browser). Only then the template becomes a
valid HTML page.

## Templating Engines
Template engine is a library which processes a HTML page with **macros**
(snippets of a template language) and produces a valid HTML page.
There are many templating engines available for PHP, some of the popular engines
are: *Smarty*, *Latte*, *Twig*. All of them (and many others) can be used as
parts of their respective [frameworks](https://en.wikipedia.org/wiki/Comparison_of_web_frameworks#PHP) or standalone. In the following
examples I will stick to using the standalone *Latte* templating engine. The
choice is rather arbitrary, as all templating engines work in a very similar way, have
almost the same features and they even have a somewhat similar syntax.

### Getting Started with Latte
First you need to obtain Latte, either by using the [Composer](https://getcomposer.org/) tool or simply by
**downloading the library** from [Github](https://github.com/nette/latte):

![Screenshot -- Download Latte](/walkthrough/templates/download-latte.png)

You should get [latte-master](/walkthrough/templates/latte-master.zip) and
copy the contents of the `src` folder to your script. Now create a PHP script like this:

{% highlight php %}
{% include /walkthrough/templates/template-1.php %}
{% endhighlight %}

And a template file `template-1.latte` like this:

{% highlight html %}
{% include /walkthrough/templates/template-1.latte %}
{% endhighlight %}

{: .note}
Latte templating engine evolves like any other software. Newer version can have trouble to run
in older PHP environment. Check if your Latte versions supports your PHP version. In case that
you need older release of Latte, simply click [releases tab](https://github.com/nette/latte/releases)
on GitHub and and download older one. Latte 3.x requires PHP 7.x to run, if you do not have one,
download older version, e.g. 2.4.x which runs with PHP 5.4.

Now, let's see what has happened. The template looks like a standard HTML document (with the file extension
`latte`), there are
some additional features however. In the template above I used `{$pageTitle}` which
prints the contents of a template variable `$pageTitle`.

Now for the PHP script -- the first statement `require 'latte.php';` instructs PHP to include the file
`latte.php` in the same directory as your script. The `latte.php` is part of the Latte Templating
engine and makes sure that the library is available in your script. Next we [create
an instance](/walkthrough/backend-intro/objects/#classes) of the `Engine`
class: `$latte = new Latte\Engine();`. Note that the
class `Engine` is in a [namespace](/walkthrough/backend-intro/objects/#namespaces) `Latte\`.
Next we create an [associative array](/walkthrough/backend-intro/array/) `$templateVariables`
with value `'Template engine sample'` assigned to the `pageTitle` key.
On the last line, we call the `render` [function](/walkthrough/backend-intro/objects/#functions)
of the Latte engine and pass to it the filename of the
template (`template-1.latte`) and the array of $templateVariables.

As you can see, **the variables used and available in the template must be passed via an associative
array to the `render` method**.

### Macros
Template engine offers plenty of [macros](https://latte.nette.org/en/macros) which simplify
generation of the HTML code. In the above example, I used the `{$variable}` macro. Let's see
some more examples:

{% highlight php %}
{% include /walkthrough/templates/template-2.php %}
{% endhighlight %}

Template file `template-2.latte`:

{% highlight html %}
{% include /walkthrough/templates/template-2.latte %}
{% endhighlight %}

There are two options how the macros can be written in latte. In the template above, the
flintstones array is printed using the longer syntax `{foreach}{/foreach}` and `{if}{/if}`
which is more similar to the PHP syntax. The rubbles array is printed using the shorter
syntax `n:foreach` and `n:if`, which disturbs the flow of the HTML code much less.

The statement `{$role|capitalize}` applies the built-in Latte `capitalize`
[filter](https://latte.nette.org/en/filters).

In the PHP code, I need to define all the variables: `$flintstones`, `$rubbles`, `$pageTitle` and
`$showBold` in an associative array. I have taken the liberty to shorten the name of the
variable `$templateVariables` to just `$tplVars`.

You can put comments in the templates as well:

{% highlight html %}
{* this is a comment *}
{% endhighlight %}

Contrary to comments in HTML, comments in templates will not be contained in the resulting page.
If you find passing variables between a PHP script and a template confusing, have a look at
the following schema.

{: .image-popup}
![Schematic of template variables](/walkthrough/templates/code-schematic.png)

## Task -- Contact form
Let's convert the [contact form](/walkthrough/backend-intro/array/#task----improve-contact-form)
we did in the previous chapter.

{: .solution}
{% highlight php %}
{% include /walkthrough/templates/form-5.php %}
{% endhighlight %}

Template file `form-5.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough/templates/form-5.latte %}
{% endhighlight %}

{: .note}
I have simplified the condition
`if ($templateVariables['currentUser']['firstName'] != '')` to
`if ($templateVariables['currentUser']['firstName'])` because the
automatic [boolean conversion](/walkthrough/backend-intro/#boolean-conversions) allows us to do it.

{: .note}
You need to convert the entities &amp;&lt; and &amp;gt; in the message back to the characters `<` and `>`. Now
Latte does this conversion automatically for you.

## Task -- Person Form
Using templates, create a form like the one below. Assume that you have a variable `$person`
which contains the default values for the form inputs. The `person` variable should be an associative
array with the keys `id`, `first_name`, `last_name`, `nickname`, `birth_day`, `height`.

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
{% include /walkthrough/templates/person-form.php %}
{% endhighlight %}

Template file `person-form.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough/templates/person-form.latte %}
{% endhighlight %}


## Summary
Using a template engine requires you to learn its macro language. However it
does lead to a cleaner [and safer](/articles/security/xss/) HTML and PHP code. You don't need to struggle so much
with using [proper quotes](/walkthrough/backend-intro/#working-with-strings).
When using templates, don't forget that
the variables defined inside a template are only those passed in an array to the
`render` method! Variables from the PHP script are not available in the
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