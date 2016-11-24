---
title: Template layouts
permalink: /en/apv/walkthrough/templates-layout/
---

* TOC
{:toc}

[Templates](/en/apv/walkthrough/templates/) allow you to create HTML pages with a simplified code and
also protect your page against [Cross Site Scripting attacks](todo).
Apart from that, the template engine allows you to take advantage of
**Template Page Layouts** (or **Template Layouts** or **Page Layouts**).
Template Layouts are not to be confused with [**HTML Page Layouts**](todo),
which define the visual layout of content in a HTML page.
Template Layouts are used to define the HTML code layout across different files,
share common parts of the code and reduce repetition. Template Layouts have no
effect on the final look of the HTML page. They are merely a programmatic tool used
for better HTML code organization.

Each HTML page in a web application **shares** a lot of HTML code with other pages in
that application. So far you have only created simple isolated pages, so this might
not seem obvious at the moment. But if you look at any existing web application you
should see that all the pages usually share the same header, footer, navigation,
design, etc. Only some part of the page is **specific** to the page itself.
In real world applications, to have high amount of a shared code is a good thing,
because it reduces code repetition and leads to consistent feel & look of the application.

## Getting Started
The *layout template*  contains all the shared code in the form of a full
HTML page with placeholder **block**s for the specific page content which is
included from the page specific templates.

I have converted the [previous Flintstones example](/en/apv/walkthrough/dynamic-page/array/#multidimensional-arrays) 
to a separate HTML code shared within the application and the HTML code specific to the page:

{% highlight php %}
{% include /en/apv/walkthrough/templates-layout/template-3.php %}
{% endhighlight %}

And a template file `template-3.latte` like this:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/template-3.latte %}
{% endhighlight %}

And a template file `layout-1.latte` like this:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/layout-3.latte %}
{% endhighlight %}

Now the template starts with the line `{extends 'layout-1.latte'}`, which tells the
template engine to start processing from the layout template `layout-1.latte`. This
template contains the usual HTML header and `{include content}`. This defines
a **block** named `content`. It's the responsibility of the template `template-3.latte` to
fill the block with some meaning. In `template.latte`, you can see that the actual HTML
code is wrapped inside `{block content}{/block}` macro. This defines the actual content
of the block `content` (the naming sounds silly, but the block is the specific content of the page).

The `extends` macro tells the template engine, that the page template **inherits** its content
from the layout template. The inheritance relation can span multiple levels. You can create a
page which inherits from a template which inherits from another template.

The layout template can define many different blocks, all of which must be filled inside the
page template:

{% highlight php %}
{% include /en/apv/walkthrough/templates-layout/template-4.php %}
{% endhighlight %}

And a template file `template-4.latte` like this:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/template-4.latte %}
{% endhighlight %}

And a template file `layout-2.latte` like this:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/layout-4.latte %}
{% endhighlight %}

From the above examples, you can see that they do not affect the PHP code at all (except for the changed
template file name in the examples). Template layouts are only a way of organizing the HTML code in the
template files. Also notice that the variables passed to the templates in the `render` function are
usable in both template files (e.g. see `pageTitle` variable).

{: .note}
The `hr` (Horizontal Ruler) HTML element produces horizontal separator. It has a 
[unpaired tag](/en/apv/articles/html/#html-elements----tags).

## Task -- Create a template layout
Take the two application parts -- the [person form](/en/apv/walkthrough/templates/#task----person-form) 
and the [contact from](/en/apv/walkthrough/templates/#task----contact-form) you have
created in the previous chapters, and create a template layout for them.

{: .solution}
<div markdown='1'>
Hint: You will need five files -- a PHP script for the contact form; a template for the contact form;
a PHP script for the person form; a template for the person form; and a layout template
</div>

Person form script:

{% highlight php %}
{% include /en/apv/walkthrough/templates-layout/person-form-1.php %}
{% endhighlight %}

Person form template:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/person-form-1.latte %}
{% endhighlight %}

Contact form script:

{% highlight php %}
{% include /en/apv/walkthrough/templates-layout/contact-form-1.php %}
{% endhighlight %}

Contact form template:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/contact-form-1.latte %}
{% endhighlight %}

Layout template:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/layout-c1.latte %}
{% endhighlight %}

## Task -- Modify the layout
Now modify the layout to add an application menu, some footer and some header to make
the page look similar to this:

![Screenshot -- Page sample](/en/apv/walkthrough/templates-layout/page-sample-1.png)

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/layout-c2.latte %}
{% endhighlight %}

Notice that now there is a single point where you modified the HTML content, and both
application pages (contact form and person form) were changed. This approach saves you
hours of time during application development.

## Task -- One size does not fit all
What if you need a page that does need a different look and feel? A typical example is
a login form, which usually looks substantially different than the rest of the application.
Create a login form which looks like this:

![Screenshot -- Page sample](/en/apv/walkthrough/templates-layout/page-sample-2.png)

{: .solution}
Hint: Simply create another layout template.

Login form script:

{% highlight php %}
{% include /en/apv/walkthrough/templates-layout/login-form.php %}
{% endhighlight %}

Login form template:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/login-form.latte %}
{% endhighlight %}

Login layout template:

{% highlight html %}
{% include /en/apv/walkthrough/templates-layout/layout-login.latte %}
{% endhighlight %}

If you are concerned, that the footer is not shared between both layouts, you can create
a more complicated structure of a parent layout and child layouts (again by using `extends` and
`include`). Personally I would say that at this moment, it is not necessary and does not have
much advantage. On the other hand -- you might ask, what is the point of creating a
`login-layout.latte` if there is only one page using it. That is correct and using a simple template
without layout would be also an acceptable solution. I'm counting on making a logout page
in the future, which will use the `login-layout.latte`.


## Summary
In this chapter, you have learned how to use *layout templates*. Layout templates provide a way to
a better organized shared HTML code between various pages of your web application. By reducing
repetition, they save you time, reduce number of errors and lead to a consistent page look & feel.

On the other hand, you probably noticed, that now your application contains much more files
(and it may be difficult to be oriented in them) and that the pages are not any more self-contained
-- i.e. they become only snippets of the HTML code. This requires a bit of training and getting used to,
because now the application code is slightly more abstract than it was at the beginning.

For small application the overhead of repeated code might be smaller than the overhead of well
structured code. As your application grows the overhead of repeated code would increase but
the overhead of structured code remains constant.

Now you should be familiar with the reasons for using layout templates. You should be able to
create and use a simple page layout with multiple blocks. You should be familiar with the
concept of inheritance.

### New Concepts and Terms
- Layout Template
- Block
- Inheritance
