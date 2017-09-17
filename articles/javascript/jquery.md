---
title: jQuery
permalink: /articles/javascript/jquery/
redirect_from: /en/apv/articles/javascript/jquery/
---

* TOC
{:toc}

*Write less, do more* -- this is the motto of [jQuery](https://jquery.com/) library. The reason to create such
library was to unify behaviour of different browsers and to make JavaScript code a bit more effective. In the past
years -- in the beginning of this century -- manufacturers of Internet browsers applied own strong opinions on JavaScript
implementation and DOM/BOM interfaces. Writing complex JavaScript code was almost a nightmare for a developer who wanted
to produce a website compatible with most common browsers that days. It was common practice to have large pieces of code
for different browsers and crazy detection of browser type and version. You also noticed in [previous article](/articles/javascript/),
that DOM lookup and manipulation methods have long names. In the past, there also was no `document.querySelector()`
method to utilize handy [CSS selectors](/articles/css/#selectors) to search for DOM elements. The jQuery
library eliminated those tedious issues and gave developers unified API which was cross-browser consistent -- this
is called a [facade](https://en.wikipedia.org/wiki/Facade_pattern).

Nowadays we have much better situation regarding web standards implementation in web browsers. Nevertheless, jQuery
is still very popular for its condensed API which is very effective for basic coding tasks and amount of plugins and
complete solutions available online. The truth is, that jQuery is not suitable for complex frontend applications.
A better solutions, i.e. full stack framework, can be applied.

## jQuery $ function
All jQuery calls go through `$` function (yes, you can name variables in JavaScript like that). This function takes
different arguments as input, to name a few:

- a string with CSS selector `$("div #id .or .class")`
- a string with HTML syntax `$("<a href='...'>")`
- a DOM element `$(document.body)`

jQuery basically interprets the input and returns DOM element (or elements) wrapped in jQuery container. You can call
various methods on this container e.g.: `$("div").empty()` would clear all children elements from all `<div>` elements.
Let's try to break down method chaining to better understand what is written in previous example:

{% highlight javascript %}
var allDivs = $("div"); //find all <div> elements using CSS selector
console.log(allDivs);   //you should see a jQuery collection in console
allDivs.empty();        //clear childNodes for each div
{% endhighlight %}

And let's consider [vanilla JavaScript](http://vanilla-js.com/) code:

{% highlight javascript %}
var allDivs = document.querySelectorAll("div");
allDivs.forEach(function(d) {
    while(d.firstChild) {
        d.removeChild(d.firstChild);
    }
});
{% endhighlight %}

You have to use two nested loops to achieve same functionality (or `d.innerHTML = ""`). The code in jQuery is
definitely shorter but you have to know functionality of particular methods.

## How to use jQuery in your application?
You have to download jQuery from its [website](http://jquery.com/download/). There are several version available:

- compressed version -- this one is what you want (use context menu do download script to your PC)
- uncompressed version -- you can download this one if you want to study jQuery's code
- 2.x or 3.x -- older versions support older browsers

Than you can simply put jQuery file as first `<script>` tag in your `<head>` element -- it has to be first so you
can use `$` function in your scripts.

{: .note}
You can also use [CDN](https://en.wikipedia.org/wiki/Content_delivery_network) links to link jQuery to your page.
CDN links are available at [https://code.jquery.com/](https://code.jquery.com/).

## DOM manipulation
This part of jQuery's API, along with CSS selectors, is the main reason for its popularity. You will see that
[jQuery's API](http://api.jquery.com/category/manipulation/) is much more effective in comparison with native
JavaScript DOM API.

- `$("...").append("<span>HTML code</span>")` -- insert HTML code as last child into every matched element
- `$("...").append($("..."))` -- move element (if first selector matched more than one element, element(s) matched
  by second are duplicated)
- `$("...").prepend(...)` -- insert as firstChild
- `$("...").remove()` -- remove matched element
- `$("...").remove("span.only-this")` -- remove only elements matching CSS selector
- `$("...").empty()` -- remove all children
- `$("...").before(...)` / `$("...").after(...)` -- insert adjacent element before/after matched

To obtain matched elements (pure JavaScript objects) use `$("...").get()` method:

- `var all = $(".css.selector").get()`
- `var first = $(".css.selector").get(0)`

To work with HTML attributes use [`$("...").attr(attrName)` method](http://api.jquery.com/attr/) which is a getter (called with
only one argument) and a setter (called with two arguments):

{% highlight javascript %}
$("a.css.selector").attr("href");   //read href attribute from first matched element
$("a.css.selector").attr("href", "..."); //set href attribute to all matched elements
{% endhighlight %}

{: .note}
This approach is common in jQuery, its methods have very variable behaviour based on input arguments. This will confuse
you a lot in the beginning.

To get or set content of HTML element use [`$("...").html()`](http://api.jquery.com/html/) or [`$("...").text()`](http://api.jquery.com/text/)
methods. The latter is obviously safe from [XSS vulnerability](https://en.wikipedia.org/wiki/Cross-site_scripting).

Manipulation with CSS properties is usually performed with [`$("...").css()`](http://api.jquery.com/css/) method.

## Registering events
Event registration in jQuery is straight forward, just use `$` function to find elements and use [methods](http://api.jquery.com/category/events/)
like `$("...").click(callback)` to register event handlers. In case that you want to register an event handler for
event that is not supported by jQuery, use general [`$("...").on(eventName, callback)` method](http://api.jquery.com/on/).

In [events part of JavaScript article](/articles/javascript/#javascript-events) I used `document.onload` to
setup rest of JavaScript functionality. In fact, there is one event which suits needs of JavaScripts programmers a bit
better but it is not so easy to attach handlers to it in pure JavaScript. That event is generally referred as
"DOM ready". The difference is that `onload` event waits for loading of all images, CSS and generally everything linked
to your HTML. For most JavaScript related tasks it is enough to wait just for HTML structure (DOM) to load. You will
almost always encounter "DOM ready" event with jQuery code.

{% highlight javascript %}
$(window).load(function() {...});      //like window.onload = function() {...}
$(document).ready(function() {...});   //"DOM ready"
{% endhighlight %}

## AJAX
jQuery has [multiple function](http://api.jquery.com/category/ajax/) to make asynchronous HTTP calls to the backend.
Most general is `$.ajax()` method. There are also `$.get()` and `$.post()` methods to make basic HTTP calls. Here is
the same calculator example as in [JavaScript article](/articles/javascript/#xmlhttprequest). Notice that the
source code is much shorter, but you lost control over the HTTP request.

`index.html` file:

{: .solution}
{% highlight html %}
{% include /articles/javascript/ajax/index-jquery.html %}
{% endhighlight %}

## jQuery plugins
As I said before, functions in JavaScript are also objects with methods and properties. Thanks to this, there is an
`$.fn` property, which can be extended with custom jQuery plugins. The main advantage of plugins is reusability --
you can easily divide your custom CSS selector and general plugin function.

{: .solution}
{% highlight html %}
{% include /articles/javascript/jquery/plugin.html %}
{% endhighlight %}

## Summary
This book is about building a web applications. JavaScript and jQuery have to be definitely mentioned because they
are naturally important to a good web developer. But I want to make final period after JavaScript topic here. I want to
build a good knowledge foundation and I need to build it with things that last long enough. You can always find tutorials
and manuals to learn particular framework or GUI library which is currently popular among web developers.
You should remember that jQuery library has particular scope and that there are cases when jQuery is *not enough* to
build useful application. Keep in mind that jQuery is curated for special (although frequent) use-cases.

### New Concepts and Terms
- jQuery
- jQuery plugins
