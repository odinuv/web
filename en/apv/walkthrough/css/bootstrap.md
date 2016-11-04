---
title: CSS - Bootstrap
permalink: /en/apv/walkthrough/css/bootstrap/
---

* TOC
{:toc}

In previous chapter I explained [CSS](/en/apv/walkthrough/css/) basics and you know that CSS is a language which
is used to set graphical properties of HTML elements. In this part of the book I will show you a way how to save
some work and use freely available predefined CSS styles instead of making your own (which are usually not very
nice looking). I will also briefly introduce responsive design.

**This text is strongly aimed at Bootstrap software library version 3.x. It is certain that in future trends will
change and/or new version of Bootstrap is released.**

## Bootstrap
I recommend to use CSS framework called [Bootstrap](http://getbootstrap.com). It can deliver nice modern look
for your application without having to worry about writing too many CSS code. You just go online and select
appropriate widget from their [online library](http://getbootstrap.com/css/). Than you just tweak that HTML
code to suit your needs.

There is more CSS frameworks available online then Bootstrap (alternatives are [Foundation](http://foundation.zurb.com/),
[HTML5 Boilerplate](https://html5boilerplate.com/), [YIU](http://yuilibrary.com/) and some others), they offer
same or a bit different features as Bootstrap. I will use Bootstrap version 3.x here because it is best known.

Linking Bootstrap to your app is simple: go to their download page and copy those few lines from "Bootstrap
CDN" section. You can also download whole Bootstrap in zip archive if you want. You just need to link
bootstrap.min.css, bootstrap-theme.min.css and bootstrap.min.js in your `<head>`. Do not break Bootstrap
folder structure. If you want to use Bootstrap's [JavaScript](todo) features, you should also link
[jQuery](https://jquery.com) (also available via CDN) before bootstrap.min.js.

### Tables, forms, inputs, pagination, navigation...
Large part of Bootstrap framework is a library of CSS definitions for basic HTML elements. You can find most
samples in Bootstrap's [CSS documentation section](http://getbootstrap.com/css/). Bootstrap has many classes
and applying them on your HTML elements will make those elements look "the Bootstrap way".

For example a button can be styled with `btn` and `btn-primary` class.

{% highlight html %}
    <button class="btn btn-primary">
        This is a blue button.
    </button>
    <button class="btn btn-success">
        This is a green button.
    </button>
{% endhighlight %}

Another example is a table which has each other row a bit darker. This can be achieved with following CSS classes:

{% highlight html %}
    <table class="table table-striped table-hover">
        <tr>
            <th>Header row</th>
        </tr>
        <tr>
            <td>1</td>
        </tr>
        <tr>
            <td>2</td>
        </tr>
        <tr>
            <td>3</td>
        </tr>
    </table>
{% endhighlight %}

That `table` or `btn` class is a set of CSS definitions common for all tables or buttons. Other classes cause the
element to behave in more specific way. Green button with `btn-success` or blue button with `btn-primary`,
`table-striped` is for alternating white and grey rows and class `table-hover` makes useful highlight for
row which is under mouse cursor. This approach resembles principle of inheritance/specialization of classes
from object oriented programming.

CSS classes for HTML forms are probably the most complicated because Bootstrap offer many layouts for your forms
(horizontal, inline) and forms are usually composed from many elements. 

In [components section](http://getbootstrap.com/components/) can be found more complicated elements like navbars,
wells, pagination and universal icons. Those icons are usually used on buttons and links like this:

{% highlight html %}
    <!-- button with floppy disk icon -->
    <button class="btn btn-primary" type="button">
        <span class="glyphicon glyphicon-disk"></span> Save
    </button>
{% endhighlight %}

Take a look at navbar, it has quiet complicated HTML and uses many CSS classes, but if you work carefully and
remove unwanted elements you can have nice navigation in your app (you can use `navbar-iverse` class to
have black one). 

## Task -- Use Bootstrap
Try to apply Bootstrap CSS classes on your application's HTML code and make it look modern. Hint: use
`<div class="container">` or `<div class="container-fluid">` element to enclose all your HTML content. 

<div class="solution">
    <p markdown="1">
        The solution is different for each of you. Although Bootstrap elements look same, the placement and
        selection of alternatives will make your app unique. You have probably a few forms and some tables in
        your application. You should use CSS classes from Bootstrap to apply styles. Try to place some 
        elements into wells or use panels and alerts.
    </p>
</div>

### Combining your custom CSS with Bootstrap
You can also override basic CSS from Bootstrap. Link another CSS file in your `<head>` section. Remember to put your
custom CSS as last `<link>` tag to override Bootstrap's CSS definitions.

### Responsive design and media querries
With growth of mobile device's market share, creators of web pages were challenged how to make a web page
usable on a PC with large screen and also on a small handheld device? And preferably with as much shared code
as possible. The key is to apply different CSS properties based on resolution of screen and/or other parameters
of device based on *media query*.

You can use *media query* to apply certain CSS properties only when some conditions is met. A basic example
can be to determine whether screen of visitor's device is larger than some value:

{% highlight css %}
    /* this CSS is used for all devices */
    body {
        background-color: #888888;
        font-size: 12pt;
    }
    @media screen and (min-width: 800px) {
        /* CSS for larger screens */
        body {
          padding: 4rem;
        }
    }
    @media screen and (max-width: 799px) {
        /* CSS for smaller screens */
        body {
          padding: 1rem;
        }
    }
    @media print {
        /* CSS for printers */
        nav {
            display: none;
        }
    }
{% endhighlight %}

By defining such breakpoints we can set different CSS for different situations and the HTML code can remain
almost unchanged.
 
{: .note}
CSS pixel -- some devices with very small screen pixels (high density displays) can be configured to count four,
nine or even sixteen screen pixels as one CSS pixel. This makes CSS unit *px* usable to measure screen size and set
dimensions of elements.

{: .note}
A media query is also used for setting print styles. For print output you usually want to hide navigation and forms
and also background images.

{: .note}
Responsive design is powerful tool, thanks to this feature you can even create mobile application which can be
installed on your phone with pure [HTML, CSS and (a lot of) JavaScript](https://cordova.apache.org).
This type of app is called *hybrid application* and its advantage is shared codebase for web and all mobile platforms.

#### Using Bootstrap to make your page responsive

Again, to define all possible scenarios and write media queries by yourself can be quiet a challenge.
Bootstrap comes with predefined responsive behaviour: it has 12 columns and ve can define for 4 screen size
intervals how much columns would an element occupy (e.g.: in small resolution we can make a `<p>` element
6 columns wide and for larger resolutions we can save some space and make it only 2 columns wide).
The key is to use Bootstrap responsive module correctly:

{% highlight html %}
    <!-- always use .container or .container-fluid -->
    <div class="container">
        <!-- to use responsive classes define a row -->
        <div class="row">
            <!--
                sum of columns occupied by elements for each
                resolution should be <= 12
            -->
            <p class="col-xs-6 col-sm-2">
                This paragraph is 6 columns wide for screens under 768px width.
            </p>
            <p class="hidden-xs">
                This one is even hidden for small screens.
            </p>
        <div>
    </div>
{% endhighlight %}

Screen size intervals for Bootstrap responsive classes:

- xs -- under 768px (excl.) -- `col-xs-*`
- sm -- from 768px to 992px (excl.) -- `col-sm-*`
- md -- from 992px to 1200px (excl.) -- `col-md-*`
- lg -- over 1200px -- `col-lg-*`

## CSS Preprocessors
If you feel that CSS with its flat structure and lack of variables can get out of hands after some time,
you are not alone! For this purpose CSS preprocessors were invented -- most popular preprocessors today are
[LESS](http://lesscss.org) and [Sass](http://sass-lang.com). This is too advanced to start with, just
try to remember this information until you start to write your first big project. And also Bootstrap is
written with Sass (it was written in LESS before).

## Summary
In this chapter you used Bootstrap CSS framework to make your application look modern. You may feel sad that
your app does not have unique design, that is right but remember that useful application is not made by nice
colours and pretty pictures. Sometimes even cool effects get tiring when the user is being slowed down by them.

Try to design usable layouts and controls and think about how people will react to your ideas. Do not hesitate
to inspire yourself from work of others. Each website is done by different team of designers and visitors have
to adapt and sometimes a new idea may confuse them. Try to follow well known patterns and practices.

I introduced you to media query and you should know what is it used for. You should be able to specify at least
some CSS for printers.

### New Concepts and Terms
- Bootstrap CSS framework
- Responsive design
- Media query
