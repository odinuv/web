---
title: Template layouts
permalink: /walkthrough-slim/templates-layout/
---

* TOC
{:toc}

{% include /common/templates-layout-1.md %}

## Getting Started
The *layout template*  contains all the shared code in the form of a full
HTML page with placeholder **block**s for the specific page content which is
included from the page specific templates.

I have converted the [previous Flintstones example](/walkthrough-slim/backend-intro/array/#multidimensional-arrays)
to a separate HTML code shared within the application and the HTML code specific to the page:

{% highlight php %}
{% include /walkthrough-slim/templates-layout/template-3.php %}
{% endhighlight %}

And a template file `template.latte` like this:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/template-3.latte %}
{% endhighlight %}

And a template file `layout.latte` like this:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/layout-3.latte %}
{% endhighlight %}

Now the template starts with the line `{extends 'layout.latte'}`, which tells the
template engine to start processing from the layout template `layout.latte`. This
template contains the usual HTML header and `{include body}`. This defines
a **block** named `body`. It's the responsibility of the template `template.latte` to
fill the block with some meaning. In `template.latte`, you can see that the actual HTML
code is wrapped inside `{block body}{/block}` macro. This defines the actual content
of the block `body` (the block is the page specific content).

The `extends` macro tells the template engine, that the page template **inherits** its content
from the layout template. The inheritance relation can span multiple levels. You can create a
page which inherits from a template which inherits from another template.

The layout template can define many different blocks, all of which must be filled inside the
page template:

{% highlight php %}
{% include /walkthrough-slim/templates-layout/template-4.php %}
{% endhighlight %}

And a template file `template.latte` like this:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/template-4.latte %}
{% endhighlight %}

And a template file `layout.latte` like this:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/layout-4.latte %}
{% endhighlight %}

From the above examples, you can see that they do not affect the PHP code at all (except for the page title
variable). Template layouts are only a way of organizing the HTML code in the
template files. Also notice that the variables passed to the templates in the `render` function are
usable in both template files (e.g. see `pageTitle` variable).

{: .note}
The `hr` (Horizontal Ruler) HTML element produces horizontal separator. It has a
[unpaired tag](/articles/html/#html-elements----tags).

## Task -- Create a template layout
Take the two application parts -- the [person form](/walkthrough-slim/templates/#task----person-form)
and the [contact from](/walkthrough-slim/templates/#task----contact-form) you have
created in the previous chapters, and create a template layout for them.

{: .solution}
<div markdown='1'>
Hint: You will need three template files -- a template for the contact form; a template for the person
form; and a layout template
</div>

Person form script:

{% highlight php %}
{% include /walkthrough-slim/templates-layout/person-form-1.php %}
{% endhighlight %}

Person form template:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/person-form-1.latte %}
{% endhighlight %}

Contact form script:

{% highlight php %}
{% include /walkthrough-slim/templates-layout/contact-form-1.php %}
{% endhighlight %}

Contact form template:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/contact-form-1.latte %}
{% endhighlight %}

Layout template:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/layout-c1.latte %}
{% endhighlight %}

## Task -- Modify the layout
Now modify the layout to add an application menu, footer and header to make
the page look similar to this:

![Screenshot -- Page sample](/common/templates-layout/page-sample-1.png)

{% highlight html %}
{% include /walkthrough-slim/templates-layout/layout-c2.latte %}
{% endhighlight %}

Notice that now there is a single point where you have modified the HTML content, and both
application pages (contact form and person form) have been changed. This approach saves you
hours of time during application development.

## Task -- One size does not fit all
What if you need a page that does need a different look and feel? A typical example is
a login form, which usually looks substantially different than the rest of the application.
Create a login form which looks like this:

![Screenshot -- Page sample](/common/templates-layout/page-sample-2.png)

{: .solution}
<div markdown='1'>
Hint: Simply create another layout template.
</div>

Login form script:

{% highlight php %}
{% include /walkthrough-slim/templates-layout/login-form.php %}
{% endhighlight %}

Login form template:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/login-form.latte %}
{% endhighlight %}

Login layout template:

{% highlight html %}
{% include /walkthrough-slim/templates-layout/layout-login.latte %}
{% endhighlight %}

If you are concerned that the footer is not shared between both layouts, you can create
a more complicated structure of a parent layout and child layouts (again by using `extends` and
`include`). Personally I would say that at this moment it is not necessary and does not have
much advantage. On the other hand -- you might ask, what is the point of creating a
`login-layout.latte` if there is only one page using it. That is correct and using a simple template
without layout would be also an acceptable solution. I'm counting on making a logout page
in the future, which will use the `login-layout.latte`.

{% include /common/templates-layout-2.md %}