---
title: jQuery
permalink: /en/apv/articles/javascript/jquery/
---

* TOC
{:toc}

*Write less, do more* -- this is the motto of [jQuery](https://jquery.com/) library. The reason to create such
library was to unify behaviour of different browsers and to make JavaScript code a bit more effective. In the past
years -- in the beginning of this century, manufacturers of Internet browsers applied own strong opinions on JavaScript
implementation and DOM/BOM interfaces. Writing complex JavaScript code was almost a nightmare for a developer who wanted
to produce a website compatible with most common browsers that days. It was common practice to have large pieces of code
for different browsers and crazy detection of browser type and version. You also noticed in [previous article](/en/apv/articles/javascript/),
that DOM lookup and manipulation methods have long names. In the past, there also was no `document.querySelector()`
method to utilize handy [CSS selectors](/en/apv/articles/html/css/#selectors) to search for DOM elements.

Nowadays we have much better situation regarding web standards implementation in web browsers. Nevertheless, jQuery
is still very popular for its condensed API which is very effective for basic coding tasks and amount of plugins and
complete solutions available online. The truth is, that jQuery is not suitable for complex frontend applications Better
solutions, i.e. full stack framework, can be applied.

## jQuery $ function
All jQuery calls go through `$` function (yes, you can name variables in JavaScript like that). This function takes
different arguments as input, to name a few:

- a string with CSS selector `$("div #id .or .class")`
- a string with HTML syntax `$("<a href='...'>")`
- a DOM element `$(document.body)`

jQuery basically interprets the input and returns DOM element or elements wrapped in jQuery container. You can call
various methods on this container e.g.: `$("div").empty()` would clear all children elements from all `<div>` elements.
Let's try to break down method chaining to better understand what is written in previous example:

{% highlight javascript %}
var allDivs = $("div"); //find all <div> elements
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

You have to use two nested loops to achieve same functionality (or `d.innerHTML = ""`).

## DOM manipulation
TODO

## Registering events
TODO

## AJAX
TODO

## jQuery plugins
As I said before, function in JavaScript are also objects with methods and properties. Thanks to this, there is an
`$.fn` property, which can be extended with custom jQuery plugins.

TODO

## Summary
This book is about building a web applications. JavaScript and jQuery have to be definitely mentioned because they
are natural basics for a good web developer. But I want to make final period for JavaScript topic here. I want to build
a good knowledge foundation and I need to build it with things that last long enough. You can always find tutorials
and manuals to learn particular framework or GUI library which is currently popular among web developers.
You should remember that jQuery library has particular scope and that there are cases when jQuery is *not enough*.

### New Concepts and Terms
- jQuery
- jQuery plugins
