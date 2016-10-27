---
title: CSS - Cascading Style Sheet
permalink: /en/apv/walkthrough/css/
---

* TOC
{:toc}

You already know how to write a HTML page and also how to use Latte templating system.
Still you do not know, how to make your page to **not** look like it came from 1995.
The answer is CSS -- a special syntax (yes, another language) which can define how
HTML elements are rendered in your browser.

In this article I will not teach you every detail of CSS, but I want to show you some basics.
Usually a beautiful design does not come from a programmer or HTML coder but from professional
graphician. To make a great design you need a talent and much experience with graphical design.
That is something that most programmers do not have (and that is OK, because we have talent to write
good code). Nevertheless you need to know how to apply some CSS styles to make your application look modern.
 
## CSS Basics
CSS is a syntax for definition of graphical properties for individual HTML elements -- things like color
of text, size of text, background color, position, size and even effects like shadows, transparency,
rounded corners or mouse cursor and many more.

Basically a CSS file looks like this:

{% highlight css %}
    body {
        font-family: Arial, Verdana, Helvetica, sans-serif;
        font-size: 12pt;
    }
    h1 {
        text-decoration: underline;
    }
{% endhighlight %}

We have something called CSS selector (`body` or `h1`) and a set of CSS properties with
values in curly braces divided by semicolons. Most CSS properties and their values are self-explaining
and as you can see, these properties are also very specific. For example, you can set different
color and style for each side of an element:

{% highlight css %}
    input {
        border-left-width: 3px;
        border-left-style: dotted;
        border-left-color: #FF0000;
        
        /* more compact syntax */
        border-bottom: 3px dashed #00FF00;
    }
{% endhighlight %}

This will produce something like this:

![Screenshot -- Applied CSS](/en/apv/walkthrough/css/example-01.png)

You will notice, that a CSS file grows fast for complicated designs. Pleasant advantage is, that we can define
CSS styles for many HTML elements globally using those CSS selectors (read on).

### Link your CSS to HTML file
We need to pass our CSS definitions into the browser, there are three ways how to do it:

1,  You can place CSS definitions into separate file(s), this is
    the best solution, because you can easily swap CSS files if you want to apply new design.
    Notice in developer console (F12) that after we link HTML and CSS file together, a new
    HTTP request is send by the browser to retrieve that CSS file.

{% highlight html %}
    <head>
        <link rel="stylesheet" href="link/to/your/css/file.css" />
    </head>
{% endhighlight %}

2,  You can also place them directly into the `<head>` with `<style>` tag (this solution saves HTTP requests
    for static pages; it is however not suitable for dynamic pages because separate static CSS file can be cached):
    
{% highlight html %}
    <head>
        <style>
            body {
                font-family: Arial, Verdana, Helvetica, sans-serif;
                font-size: 12pt;
            }
        </style>
    </head>
{% endhighlight %}
    
3,  A quick (and dirty) solution for CSS testing is inline CSS with `style` attribute, but this
    should not be used frequently:
    
{% highlight html %}
    <body style="font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 12pt;">
        ...
    </body>
{% endhighlight %}

### CSS Selectors
Selector is a powerful expression which can locate HTML elements in your page. Remind yourself that HTML is a
tree like structure:

{: .image-popup}
![HTML tree](/en/apv/walkthrough/css/html.svg)

In such structure we can describe location of an element by saying that it has certain sequence of parents, e.g.:
we can select that `a` element in `footer` part of page by typing CSS selector `footer p a`. That spaces
between element names represent nesting deeper in our tree structure. We can also write just `footer a`, because
there is no other `a` element in `footer` tag so there is no need to be that specific.

In some cases we want to emphasize that parent-child relationship with `>` operator. That means that element behind
this operator is direct descendant of element before `>` operator. With `>` operator we need to write `footer>p>a`
because `footer>a` would not work (tag `a` is not direct descendant of `footer`).

#### Class selector
CSS selectors in above paragraphs are still very general. Sometimes we have multiple HTML elements, say those `<li>`
elements, and we want two of them to look different than the others. We can achieve this by using classes. A class
is just an identifier which a HTML coder fabricates and puts in the `class` attribute of desired element:

{% highlight css %}
    li {
        list-style-type: disc;
    }
    li.different-than-others {
        list-style-type: square;
    }
{% endhighlight %}

{% highlight html %}
    <ul>
        <li><a href="...">...</a></li>
        <li><a href="...">...</a></li>
        <li class="different-than-others"><a href="...">...</a></li>
    </ul>
{% endhighlight %}

Notice that there is a difference between `li.different-than-others` and `li .different-than-others`. The first
one selects a `li` element with class `different-than-others` and the latter selects **any** element
with class `different-than-others` within `li` element.

#### ID selector
Sometimes we wish to be even more specific and select one particular HTML element. That element is
provided with `id` attribute, which has to have unique value among all other `id` attributes on page.
In CSS selector we simply use `#` with `id` attribute value similarly to a class `.` selector:

{% highlight css %}
    #special {
        text-transform: uppercase;
    }
{% endhighlight css %}

{% highlight html %}
    <h1 id="special"></h1>
{% endhighlight html %}

#### Attribute selectors
You can also select elements just by knowing certain HTML attribute values or their presence
on HTML elements, this is useful to know because otherwise you have to pollute your HTML code
with much more `class` attributes:

{% highlight css %}
    input[type=checkbox] {
        /* some CSS just for checkboxes */
    }
    input[required] {
        /* some CSS just for mandatory inputs */
    }
{% endhighlight css %}

#### Pseudoclasses
A pseudoclass is even more specific selector. Most popular one is `:hover` which is used to style
HTML elements while a mouse cursor is present over them (interesting point is, that some modern devices
do not have mouse). You can also use pseudoclasses on parent elements:

{% highlight css %}
    /* applied for all a's in lists */
    ul li a {
        text-decoration: none;
    }
    /* applied on a when mouse is over whole ul */
    ul:hover li a {
        color: #FF0000;
    }
    /* applied when mouse over particular a */
    ul li a:hover {
        text-decoration: underline;
    }
{% endhighlight css %}

Another useful pseudoclasses:

- `:link` -- unvisited link
- `:visited` -- visited link
- `:active` -- active link
- `:focus` -- focused input
- `:checked` -- checked input, same as `input[checked]`
- `:disabled` -- disabled input, sames as `input[disabled]`
- `:first-child` -- first matched element, e.g.: `li:first-child` selects first `<li>`
- `:nth-child(2)` -- second matched element
- `:nth-child(even)` and `:nth-child(odd)` -- even and odd elements
- `:nth-child(3n+2)`-- every third beginning from the second element

#### Combining CSS selectors
More CSS selectors can be combined with commas:

{% highlight css %}
    /* applied for all headers */
    h1, h2, h3 {
    }
    /* applied for some form inputs */
    textarea, input[type=text], input[type=number], select {
    }
{% endhighlight css %}

### CSS properties
There is too many CSS properties to list here, you can find them using Google just by typing what you want to achieve.
As the HTML language evolves, CSS also expands list of available properties. Currently there is
CSS version 3. There can be a bit of confusion about support of newest CSS properties in different
web browsers: new CSS properties are implemented in browsers but sometimes the authors of that
browser want to mark some implementation as experimental -- they usually prefix such property with their's browser name:

Some example from the Internet:
{% highlight css %}
    .shadow {
      -webkit-box-shadow: 5px 5px 5px 5px #888; /* Safari and Chrome */
      -moz-box-shadow: 5px 5px 5px 5px #888; /* Firefox */
      box-shadow: 5px 5px 5px 5px #888; /* generally all browsers that support this feature */
    }
{% endhighlight css %}

You can check support of different web technologies among internet browser on [http://caniuse.com/](http://caniuse.com/).

#### Task
Try to find and use CSS for rounded corners

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/css/round-corners.html %}
{% endhighlight %}

### Colors
Colors are defined with their RGB components. Usually a HEX coding is used, but plain RGB is also
available:

{% highlight css %}
    h1 {
        color: #FF0000;
        /* or */
        color: rgb(255,0,0);        
    }
{% endhighlight css %}

HEX coding makes it simple to mix colors because it gives us 16 levels of each basic color --
e.g. if you want to mix somewhat yellowish color you can take 12 levels (C - 12) of red and
10 levels (A - 10) of green which is encoded like this <span style="color: #CCAA00">#CCAA00</span>.

You can even shorten that HEX color entry by leaving out repeating letters/numbers `#CCAA00` -> `#CA0`.

### Unit system
There are many CSS units, most used ones are `px`, `em`, `rem`, `pt` and `%`. Basic division of
CSS units is between absolute (`mm`, `cm`, `in`, `pt`) and relative units (`%`, `em`, `rem`, `vw`, `vh`, `vmin`, `vmax`).
Absolute unit renders same the size on any device.

### Task
Try to set some relative and absolute sizes for some box elements (`<div>`).

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/css/relative-absolute.html %}
{% endhighlight %}

## Summary
In this chapter you learned about CSS and why and how to use it. This article covers the basics,
there is much more to know if you want to be a professional HTML coder (a person who converts
graphical design into HTML and CSS code). Important thing is, that you can understand the CSS
and know how to connect it with HTML.

In following article we will try to use some freely available CSS styles to save some work and
liberate ourselves from the pain that our design skills are not brilliant.

### New Concepts and Terms
- CSS
- CSS selector
- CSS properties
- CSS units
- CSS class