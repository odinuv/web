---
title: Dynamic page
permalink: /en/apv/walkthrough/dynamic-page/
---

* TOC
{:toc}

When you know the basics of [HTML](/en/apv/articles/html/) and know how to 
create a [static HTML page](/en/apv/walkthrough/html/) you
can switch to creating dynamic pages. A dynamic web page has content which is generated dynamically
(on the fly) depending on some external input (usually user input and content stored 
in [database](/en/apv/walkthrough/database/)).
For example, when you check your email on web, the page you see contains your current emails (stored somewhere)
and only those you want to see (e.g. in inbox or another folder you selected).

To create a dynamic page, you need another technology beyond HTML, this can be either:

- anything on [web server](todo) -- backend,
- [Javascript on](todo) web client -- frontend.

In this part I will concentrate on the web *server* approach. I choose to use [PHP language](http://php.net/) for
the server backend, this choice is rather arbitrary as it is not anyhow better or worse
than using e.g. [Python](https://www.python.org/).

## PHP Language
PHP is an interpreted programming language, which means that there is no 
[compilation](/en/apv/articles/programming/#source-code) involved
(or rather it's done automatically behind the scenes). Practically this means that you just write
source code and it gets executed, which simplifies things a lot. PHP has a 
[C-like syntax](https://en.wikipedia.org/wiki/C_(programming_language)) but
otherwise it's not anyhow similar to C. PHP is a fully fledged language which allows both procedural
and object oriented programing. It has a large library of [built in functions](http://php.net/manual/en/funcref.php) 
and [extensions](https://pecl.php.net/). A single file with PHP code (and `.php` extensions) is called a *PHP script*.
An application is composed of many scripts usually.

## Getting Started
Before you start, you need to have a [web server ready](todo). Test that your setup is working by
creating this PHP script file:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/intro.php %}
{% endhighlight %}

When you display the script in the web browser and everything works correctly, you should see
something like this:

![Screenshot -- Introduction page](/en/apv/walkthrough/dynamic-page/intro-page.png)

### The Basics
The above example is a simple PHP script, which does only one thing, it prints out (using the
command `echo`) a string of characters `<h1>Fant&#244;mas was here!</h1>`. As you can see
the script starts with mark `<?php` which is required (there is also and end mark,
[which should not be used](todo)). Each PHP statement is terminated by semicolon `;`.
Comments in code are marked by `//` or `#`, and multi-line comments start with `/*` and end with `*/`.

The main objective of a PHP application is to generate HTML page, which gets send to web browser,
which interprets it and shows the end-user a web page. In PHP the HTML language has no special
meaning, for PHP interpreter, the HTML language is just a string of characters as anything else.

You can see that in the first PHP script above -- PHP does not really care what's inside the string,
it just *prints it*. In case PHP is being used as backend of web application, this means that the
text will get sent to web browser (which expects it to be HTML).

### Working with strings
As working with character strings is really important, let's dive into it first. You can print a
string using `echo` or `print` command (there is practical difference between them). A string
can be quoted in either single quotes `'` or double quotes `"` (there are some practical differences
between them -- see below).

When as string is quoted, it means it's surrounded by quotes (either kind). The
*chosen quote character* cannot be contained in the string itself or it must be **escaped**. Escaping
means *removing special meaning of a character* (in this case the special meaning is
*terminate the string*). Escaping is done by backslash `\` character. Some examples:

{% highlight php %}
echo "Hello John!"; // valid - string quoted by double quote
echo "Hello John O'Reilly"; // still valid - double quote is not inside the string
echo 'Hello John!'; // valid - string quoted by single quote
echo 'Hello John O'Reilly'; // INVALID - single quote is contained inside the string
echo 'Hello John O\'Reilly'; // VALID again - single quote is contained inside the string, but it is escaped
{% endhighlight %}

{: .note}
In `echo "Hello John!";`, the `"Hello John!"` is a [string literal](/en/apv/articles/programming/#literal).

### Variables
Variables contain values which can be changed (as opposed to 
[constants](/en/apv/articles/programming/#constant)). Variables begin with
by the dollar character `$`, should be [safe names](todo) and case sensitive (not always, but sometimes yes -- so,
to simplify things let's pretend that they always are).

With variables you can do standard operations with 
[C-like operators](/en/apv/articles/programming/#operators) - `+`, `-`, `*`, `/`, `=`, `==`,
additionally in PHP, there is a dot `.` operator which is used for concatenating strings. Operator `=`
assigns a value to variable, operator `==` compares two values. 
Operator [modulo](https://en.wikipedia.org/wiki/Modulo_operation) is `%`. Examples:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/variables-1.php %}
{% endhighlight %}

The above example will print `Hi John4`. As you see, there are no *declarations* of variables. In PHP a variable is
declared by simply assigning it a value. Because PHP is **dynamically typed language**, The 
[type of the variable](/en/apv/articles/programming/#type-system)
is defined by the variable content.
So `$count = 0` is an integer variable and `$count = 'many'` is a string variable. The type of variable
can change, which is very practical, but can lead to some confusing behavior.
All of the lines:

- `$count = $count + 1;`
- `$count += 1;`
- `$count++;`

increment the `$count` variable by one.

### Boolean conversions
It is very useful to know some rules for converting values to boolean data type (true/false):

- empty string and string `'0'` is *false*
- array/list/object with no elements is *false*
- 0 is *false*
- 0.0 is *false*
- `null` is *false*
- *everything else is **true***

Let's have a look at some type conversion example:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/variables-2.php %}
{% endhighlight %}

In the above example, we took advantage of the dynamic type system on the line
`echo "Greeting count: " . $count;` where the variable `$count` is automatically converted to
a string and concatenated with the string `Greeting count: ` using a dot `.` operator.
This is an example of how the dynamic types are useful as something like this is
more complicated in C++ or Java.

### Double-Quoted vs. Single-Quoted strings
Strings in double quotes allow two more features over single-quoted strings:

- use variables directly without concatenation.
- use special whitespace characters (`\n`, `\t`),

With direct variable use, You can then simply rewrite the above example into:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/variables-3.php %}
{% endhighlight %}

[Special characters](todo) e.g. `\n` for new line and `\t` for tab character, can be used to
put whitespace into the string. So `echo "Hi,\nJohn"` would actually print:

    Hi,
    John

None of this is possible in the single quoted string, so `echo 'Hi,\nJohn $lastName';` would actually
print `Hi,\nJohn $lastName`.

### Mixing with HTML
So far we haven't done much, because the script outputs only plain text string. Outputting HTML is
no different however, it just gets more tangled.

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/variables-4.php %}
{% endhighlight %}

{: .note}
In the above example, I intentionally mixed different types quotes and concatenation methods. Normally you
would write things in a more consistent matter.

### Task 1 -- Contact form
Try to create a contact form like this using PHP echo command (review the 
[HTML form elements](/en/apv/walkthrough/html-forms/#form-controls) if necessary):

![Screenshot -- Introduction page](/en/apv/walkthrough/dynamic-page/form-1.png)

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/form-1.php %}
{% endhighlight %}

### Task 2 -- Using variables
Now define the number of columns and rows of the textarea as PHP variables and output them for the browser.

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/form-2.php %}
{% endhighlight %}

Alternative solution:

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/form-2a.php %}
{% endhighlight %}

### Task 2 -- Using variables
Now define the page title and default textarea content as variable too and set the default message to:

    Hello,
    I'd like to know more about your product <ProductName>

    Best Regards,
    <YourName>

Also add a `h1` header to the page with the same content as the page title.
Hint: You'll also need to use some [HTML entities](/en/apv/articles/html/#entities).

![Screenshot -- Introduction page](/en/apv/walkthrough/dynamic-page/form-3.png)

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/form-3.php %}
{% endhighlight %}

There are many different solutions to the above, so your solution does not have to look the same
as my solution. Make sure to verify your solution using 
[HTML validator](/en/apv/articles/html/#validation), and check that
the message in the text area has the correct whitespace.

## Divide and conquer
You can find yourself in a situation when you have two similar pages which share e.g. common header
and/or footer part. And now you are thinking about updating both of them - you have to open both PHP
files and make same changes in the same part of code. To avoid duplication of code you can use the
``require`` command which finds file by specified paths and "includes" it as if the source code of that
included file was written instead of that command:

File ``commonHeader.php``:
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/require-1.php %}
{% endhighlight %}

File ``page1.php``:
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/require-2.php %}
{% endhighlight %}

File ``page2.php``:
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/require-3.php %}
{% endhighlight %}

This is not the best example because included file requires you to define variable ``$pageTitle`` beforehand.
But I wanted to demonstrate the behaviour of included source code. Usually the role is opposite - you include
the file to use something from it. Important thing is that such concept allows you to divide the logic and **reuse**
your code. In next chapters you will learn about functions and classes where it is more natural to use ``require``
command to load libraries of reusable functions.

Remakrs:


- There is also an ``include`` command, which does not cause critical error when referenced file is not found.
- Moreover, there are ``include_once`` and ``require_once`` commands which ingore multiple inclusion of same file.
- More advanced PHP systems support automatic loading based on namespaces and class names.

## Summary
You should now be able to create simple PHP scripts which output a HTML page. You should be
familiar with PHP variables and know about the dynamic type system. You should be able to divide
script into multiple files using ``require`` and avoid code duplications. Be sure to exercise
different approaches to writing and concatenating strings, because all of them are widely used.
Before continuing further, make sure you are not confused by the quotes all around the place.

### New Concepts and Terms
- Backend
- PHP
- Strings
- String Concatenation (dot)
- Escaping
- Variables
- Dynamic Types
- ``require`` command
