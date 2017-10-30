In the previous chapter I have explained the [CSS](../) basics. You should know that CSS is a language which
is used to set graphical properties of HTML elements. You should also be able to read CSS files and understand them.
In this part of the book I will show you how to save
some work and use freely available predefined CSS styles. I strongly suggest that you start with some predefined
styles, because making your own (good looking) styles requires a lot of work. I will also briefly introduce
*responsive design*.

**This text is strongly aimed at the Bootstrap software library at version 3.x. It is certain that in future trends will
change as a new version of Bootstrap is released.**

## Bootstrap
I recommend to use the CSS framework called [Bootstrap](http://getbootstrap.com). It can deliver a nice modern look
for your application without having to worry about writing too much CSS code. Obtaining it is easy -- you just go online and select
an appropriate widget from their [online library](http://getbootstrap.com/css/). Then you tweak that HTML
code to suit your needs.

There are more CSS frameworks available online -- e.g.:

- [Foundation](http://foundation.zurb.com/),
- [HTML5 Boilerplate](https://html5boilerplate.com/),
- [YUI](http://yuilibrary.com/).

I will use the Bootstrap version 3.x here because it is best known and I like it.
The above frameworks offer similar features to Bootstrap, so the choice is rather arbitrary.
And if you are curious what the word Bootstrap means, you can [read an article about it](bootstrap/).

Linking Bootstrap to your application is simple. Go to [the download page](http://getbootstrap.com/getting-started/#download) and copy those
few lines from the **Bootstrap [CDN](https://en.wikipedia.org/wiki/Content_delivery_network)** section. You can also download the whole Bootstrap
in a zip archive if you want. You just need to link
`bootstrap.min.css`, `bootstrap-theme.min.css` and `bootstrap.min.js` in your `<head>`. If you want to use Bootstrap locally,
make sure not to break the Bootstrap
directory structure. If you want to use Bootstrap's [JavaScript](../javascript/) features, you should also link
the [jQuery](https://jquery.com) library (also available via [CDN](https://jquery.com/download/#using-jquery-with-a-cdn))
before `bootstrap.min.js` (always use the latest compressed production version). With all this, the beginning of your HTML document should look like this:

{% highlight html %}
{% include /common/css/head-skeleton.html %}
{% endhighlight %}

### Tables, forms, inputs, pagination, navigation...
A large part of the Bootstrap framework is a library of CSS definitions for basic HTML elements. You can find
samples in the Bootstrap [CSS documentation section](http://getbootstrap.com/css/). Bootstrap has many classes
and applying them on your HTML elements will make those elements look "the Bootstrap way".

For example a button can be styled with the `btn` and `btn-primary` [class](http://getbootstrap.com/css/#buttons-options).

{% highlight html %}
<button class="btn btn-primary">
    This is a blue button.
</button>
<button class="btn btn-success">
    This is a green button.
</button>
{% endhighlight %}

{: .note}
The code `class="btn btn-primary"` simply assigns two classes (`btn` and `btn-primary`) to the
HTML element. Do not confuse this with a space in a [CSS selector](/articles/css/#combining-selectors).

Another example is a table which has every second row a bit darker. This can be achieved with the following CSS classes:

{% highlight html %}
{% include /common/css/bootstrap-table.html %}
{% endhighlight %}

As you see, the Bootstrap CSS classes are split into general and specific.
For example, the `table` or `btn` class is a set of CSS definitions common for all tables or buttons. Other classes cause the
elements to behave in a more specific way -- e.g. a green button with `btn-success` or a blue button with `btn-primary`.
The class `table-striped` is for alternating white and grey rows in a table and the class `table-hover` makes useful highlight for
a row which is under the mouse cursor. This approach resembles the principle of inheritance/specialization of classes
from [object oriented programming](https://en.wikipedia.org/wiki/Object-oriented_programming).

The CSS classes for HTML forms are probably the most complicated because Bootstrap offers many layouts for your forms
(horizontal, inline) and most forms are usually composed of many elements.
In the [components section](http://getbootstrap.com/components/) you can find more complicated elements -- for example
[navbars (navigation bar)](http://getbootstrap.com/components/#navbar),
[wells](http://getbootstrap.com/components/#wells),
[pagination](http://getbootstrap.com/components/#pagination) and
[universal icons](http://getbootstrap.com/components/#glyphicons). The universal icons are usually used on buttons and links like this:

{% highlight html %}
<!-- button with floppy disk icon -->
<button class="btn btn-primary" type="button">
    <span class="glyphicon glyphicon-disk"></span> Save
</button>
{% endhighlight %}

Make sure to have a look at [navbar component](http://getbootstrap.com/components/#navbar). It has quite a complicated HTML code and uses
many CSS classes, but if you work carefully and
remove unwanted elements you can get a nice navigation in your application (you can use the `navbar-inverse` class to
have a black one).

### Task -- Use Bootstrap
Try to apply Bootstrap CSS classes to your application HTML code and make it look modern. Hint: use the
`<div class="container">` or `<div class="container-fluid">` element to enclose all your HTML content.

{: .solution}
<div markdown="1">
The solution is different for each of you. Although the Bootstrap elements look the same, the placement and
selection of alternatives will make your application unique. You probably have a few forms and some tables in
your application. You should use only the CSS classes from Bootstrap to apply styles. Try to place some
elements into *wells* or use *panels* and *alerts*.
</div>

## Combining custom CSS with Bootstrap
Although it is very complicated, Bootstrap is nothing more than CSS. So [all of the CSS rules](/articles/css/#inheritance--cascading)
still apply. This means that you can easily override anything defined in Bootstrap. However, because Bootstrap is a
[library](/articles/programming/#standard-library) (and other people develop it), you should avoid changing anything in the
bootstrap files directly. If you want to override something in Bootstrap, link another CSS file in your `<head>` section.
Remember to put your custom CSS as the **last** `<link>` tag to override Bootstrap's CSS definitions.

### Task -- Override Bootstrap
Try to change the default blue color of the primary button to violet (`#935ebc`) and the danger button color to sharp
red (`#db0808`).

![Screenshot - Overridden button colors](/common/css/button-override.png)

{: .solution}
<div markdown='1'>
Your HTML should look like this (custom CSS styles have to come last to overwrite Bootstrap styles):

{: .solution}
{% highlight html %}
{% include /common/css/bootstrap-override.html %}
{% endhighlight %}

In the linked CSS file (`my-styles.css`), you simply define what you want to change:

{: .solution}
{% highlight css %}
{% include /common/css/my-styles.css %}
{% endhighlight %}

If you are not sure, where a particular CSS property (`background` and `background-image` in this case) is defined, you can always
find the right place using [the Developer tools](/course/not-a-student/#web-browser).
</div>

## Responsive design
With the growth of mobile devices market share, creators of web pages were challenged to make web pages
usable both on PCs with large screens and also on small handheld devices. Also this must be done preferably with as much shared code
as possible. The key is to apply different CSS properties depending on the screen resolution or other parameters
of the device using a [**media query**](/articles/css/#at-rules).

You can use a *media query* to apply certain CSS properties only when some conditions are met.

{% highlight css %}
{% include /common/css/media-queries.css %}
{% endhighlight %}

In the above example, the padding of the page is changed with the browser window size. Try it for yourself
on the following piece of HTML code:

{% highlight html %}
{% include /common/css/media-queries.html %}
{% endhighlight %}

You should see that as you resize the browser window the padding will change. I have also added a change of background color
to make the trigger more apparent. The above example also shows that media queries are often used to control what
gets printed on web pages. For print output, you usually want to hide navigation and forms
and also background images (in this above style I set background to plain white and the `nav` element not to print).

{: .note}
CSS pixel -- some devices with very small screen pixels (high density displays) can be configured to count four,
nine or even sixteen screen pixels as one CSS pixel. This makes CSS the unit *px* usable to measure screen size and set
dimensions of elements.

Using media queries you can set different CSS rules for different situations and the HTML code can remain
almost unchanged. This makes it possible to create pages with *responsive design*. Altogether this is a powerful tool,
thanks to it you can even create a mobile application which can be
installed on your phone with pure [HTML, CSS and (a lot of) JavaScript](https://cordova.apache.org).
This type of application is called *hybrid application* and its advantage is a shared codebase for web and all mobile platforms.

### Using Bootstrap to make your page responsive
Again, to define all possible scenarios and write media queries by yourself can be quiet a challenge.
Bootstrap comes with predefined responsive behavior: it divides the page to 12 vertical columns and you
can define how many columns would an element occupy in 4 different screen size intervals (e.g. in a small
screen resolution you can make a `<p>` element 6 columns wide and for larger resolutions you can save some
space and make it only 2 columns wide). The key is to use the Bootstrap responsive module correctly:

{% highlight html %}
{% include /common/css/bootstrap-responsive.html %}
{% endhighlight %}

Screen size intervals for Bootstrap responsive classes:

- **xs** -- extra small -- under 768px (excl.) -- `col-xs-*`
- **sm** -- small -- from 768px to 992px (excl.) -- `col-sm-*`
- **md** -- medium -- from 992px to 1200px (excl.) -- `col-md-*`
- **lg** -- large -- over 1200px -- `col-lg-*`

## CSS Pre-processors
If you feel that CSS with its flat structure and lack of variables can get out of hands after some time,
you are not alone! For this purpose CSS pre-processors were invented -- most popular pre-processors today are
[LESS](http://lesscss.org) and [Sass](http://sass-lang.com). This is too advanced to start with, just
try to remember this information for your first big project. Also the Bootstrap library is
written with Sass (it used to be written in LESS).

## Summary
In this chapter you have used Bootstrap CSS framework to make your application look modern. I have also introduced
you to media query and you should know what is it used for. You should be able to specify at least a simple
CSS for printers.

You may feel sad that your app does not have a unique design. That is true, but remember that useful application is
not made only of nice colours and pretty pictures. Sometimes even the coolest effects can get tiring when they slow
down the user.

Try to design usable layouts and controls first and then try to think how people will react to your ideas. Do not hesitate
to inspire yourself from the work of others. Each website is done by different team of designers and visitors have
to adapt and sometimes a new idea may confuse them. Try to follow well known patterns and practices.


### New Concepts and Terms
- Bootstrap CSS framework
- Responsive design
- Media query
