---
title: Code organization
permalink: /en/apv/walkthrough/organize/
---

* TOC
{:toc}

In the previous chapter, you learned how to process a 
[HTML form for searching](/en/apv/walkthrough/backend-select/). In the next
chapter, I'll take a look at [inserting data](/en/apv/walkthrough/backend-insert/) 
into the database. Before we get there, 
let's do a brief side step to better organization of your code, before it gets to cluttered. 

## Getting Started
By this time, your working folder is probably a mess of experimental half working scripts and you 
are getting lost in it. If so, it is a good time to put some order in your code. 

### Shared Code
Do you remember
[why we started to use layout templates](/en/apv/walkthrough/templates-layout/)? Let's do the 
same with out PHP code, so far
all of the scripts begin with something like:

{% highlight php %}
{% include /en/apv/walkthrough/organize/include/start.php %}
{% endhighlight %}

Let's move this *shared code* to a single file and stop copying & pasting it endlessly. We can create
a file `start.php` (or whatever name you like), with the above content and only reference it 
in the other scripts using `require 'start.php'`.  This will make other scripts shorter and better arranged.
It also has the nice effect that if you need to change your database password, there will be only one 
point of change.

It is important to understand how *global variables* work in PHP. In PHP a global variable is any variable
not defined inside a [function or method](/en/apv/walkthrough/dynamic-page/objects/#functions). 
Therefore most of the variables you used so far were global.
Global variables are also *shared among included files*. This means that if we use variables `$db`, `$latte` and
`$tplVars` in the `start.php` script and then include (using the `require` command) the script in another
PHP script (e.g. `person-list.php`), the variables `$db`, `$latte` and `$tplVars` will be in initialized.  

You can imagine that the `require` statement works as if it would copy the contents of the include script and 
executed them. Hence the `person-list.php` starts where `start.php` script ended. This property of global 
variables should not be abused. It is practical in what we did here. You can be sure that variables
`$db`, `$latte` and `$tplVars` will contain what you expect them to contain, and still you don't have to worry to 
much about that. 

Also notice that if the database connection fails, the `start.php` script will call `exit` which terminates the
entire script execution. This means that once our code in `person-list.php` is being executed, we are absolutely
sure that the script is successfully connected to database (otherwise it would exit prematurely). 

### Organizing files
Currently you have many files in your project:

- PHP scripts generating HTML pages
- Included PHP scripts (such as 'start.php' or 'latte.php')
- Templates
- Layout template(s)
- Other resources such as [CSS styles](todo) and images
- Experimental testing pieces of code 

So let's bring a few rules into this:

- leave all page generating PHP scripts in the root
- put all included files under `include` subdirectory
- put all templates under `templates` subdirectory
- put all other resources under `resources` subdirectory
- put all experimental files somewhere else
- name all page generating scripts according to what they do (e.g. `person-list`, `person-add`, `meeting-list`)
- name all templates same as the corresponding page scripts
- have an `index.php` script in the root of your application

With the current files this leads us the following directory structure:

- /
 - include  
  - latte.php
  - start.php
  - Latte
   - ...
 - resources
 - templates
  - index.latte
  - layout.latte
  - person-list.latte
 - index.php
 - person-list.php

Don't forget to use proper paths when referencing the files. Specifically:
`require 'include/start.php';` and `$latte->render('templates/person-list.latte', $tplVars);`

If you are unsure, there are all the files. `index.php`:

{% highlight php %}
{% include /en/apv/walkthrough/organize/index.php %}
{% endhighlight %}

`templates/index.latte`:

{% highlight html %}
{% include /en/apv/walkthrough/organize/templates/index.latte %}
{% endhighlight %}

`templates/layout.latte`:

{% highlight html %}
{% include /en/apv/walkthrough/organize/templates/layout.latte %}
{% endhighlight %}

`person-list.php`:

{% highlight php %}
{% include /en/apv/walkthrough/organize/person-list.php %}
{% endhighlight %}

`templates/person-list.latte`:

{% highlight html %}
{% include /en/apv/walkthrough/organize/templates/person-list.latte %}
{% endhighlight %}

`include/start.php`:

{% highlight php %}
{% include /en/apv/walkthrough/organize/include/start.php %}
{% endhighlight %}

Of course the naming and organization of files is completely up to you. You don't need to follow
the rules I outlined here, but _do follow **some rules**_. 

## Task -- Index page
Every application starts somewhere. The `index.php` file has special behavior in that
it [replaces the default directory listing](todo). Every application should have its index
with some useful content.

{: .solution}
<div markdown='1'>
Sorry, no solution here :) This is completely up to you. If you have no idea what should be 
on the index page, don't worry. Something will come to you later.
</div>

## Summary
As your application becomes more complicated, you need to organize the source code files
somehow. Better do it before it becomes a complete mess. Find yourself some rules and stick to
them -- even if you later discover they were not that good stick to them rather then changing things
only in part of the application.

In this chapter I have shown an example of how the source code can be organized. This allows you 
to non-trivial web applications without getting completely lost in the files and source code.
Organizing source code is a very important aspect of [software development](todo), though there is 
no *one true solution* to it. 

### New Concepts and Terms
- Shared code
- PHP Global variables
- Directory structure

