---
title: JavaScript
permalink: /en/apv/walkthrough/javascript/
---

* TOC
{:toc}

Sometimes a quick popup alert or confirmation dialog is the best solution how to notify or pose question
to website visitor. Imagine that you would have to write a PHP script and a template to confirm deletion
of a record -- it would be a lot of code. You probably saw a dialog with native look of operating system
on another websites. Such dialog can be displayed using [JavaScript](/en/apv/articles/javascript) code and it
is part of browser's API.

I will not teach you how to build application entirely with JavaScript, I will show you how to use
this language to overcome most common problems with user interface -- quickly confirm some action or
validate a form before it is send to backend.

## Linking JavaScript to your HTML
Similarly to CSS, a JavaScript file is usually referred in `<head>` tag using a `<script>` tag.
The `<script>` tag can contain URL to download some script or it can directly contain some
JavaScript code:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/attach.html %}
{% endhighlight %}

{: .note}
The console is a global object that represents [browser's developer console](/en/apv/course/not-a-student/#web-browser)
(usually activated by F12 key). Method `log()` puts output into it. You should have the console activated everytime
you develop some JavaScript functionality.

Basic JavaScript syntax is described in separate [article](/en/apv/articles/javascript/#javascript-basics).

Source code of linked scripts is executed immediately in order of `<script>` tag appearances, but usually you want
to attach [event handlers](/en/apv/articles/javascript/#javascript-events) to execute another code after a visitor
performs some action. Event handlers can be attached to general events which take place globally (like loading the whole
page or scrolling the window) or events that take place on particular HTML element (clicking on it or focusing it).
But you have to find the element first to attach such handler.

There are multiple function to locate and work with HTML elements -- the easiest one is
`dcoument.getElementById("id_of_element")` which can find and return one element using its `id`
attribute, `document` is a global object which contains tree structure of your HTML elements.

Other useful functions to retrieve HTML elements:

- `document.getElementsByTagName("table")` -- returns collection
- `document.getElementsByClassName("some-class")` -- returns collection
- `document.querySelector(".some-css-selector")` -- returns first matched element
- `document.querySelectorAll("#some-css-selector")` -- returns collection

To access standard HTML attributes of retrieved elements just type `element.attr`
(e.g. `console.log(link.href)` for `<a>` element). An exception is `class` attribute which is accessed
using `element.className`. To change styles use `element.style` object with camel case
style name (e.g. CSS `background-color` can be accessed with `element.style.backgroundColor`).
Another special attribute is `innerHTML` which can be used to change content of an element.
You might remember about [user defined attributes](/en/apv/articles/html/#data-attributes) which
are found under `element.dataset.*` field.

{% highlight html %}
{% include /en/apv/walkthrough/javascript/html-attributes-styles.html %}
{% endhighlight %}

{: .note}
Avoid changing of particular CSS styles in JavaScript. It is tedious and makes your code confusing.
You should rather add or remove a CSS classes (there is a [`classList`](https://developer.mozilla.org/cs/docs/Web/API/Element/classList)
field of HTML element for efficient work with CSS classes).

Each element can have a set of child nodes -- you can remove or add children with `elem1.appendChild(elem2)`
and `elem1.removeChild(elem2)` methods. To create a new element you can use `var newElem = document.createElement("tag")`
method.

Basic [event registration](/en/apv/articles/javascript/#javascript-events) can be performed in similar manner:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/basic-events.html %}
{% endhighlight %}

{: .note}
Cleaner approach is obviously to divide HTML nad JavaScript code and attach events in JavaScript. And also imagine
how ugly it would look if you have written complex code inside the `onclick` attribute.

### Task -- toggle a class of HTML element using a button click
Make a button and any HTML element with an `id` attribute. Attach click event to button using an `onclick` attribute.
Toggle some CSS class on element with `id` using `element.classList.toggle('className')` method. You also need a CSS
class with some visual properties defined.

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/javascript/events-toggle-css.html %}
{% endhighlight %}

{: .note}
If you came up with another solution, do not worry, there are always multiple working solutions when you write any code.

## Using JavaScript to confirm user actions
In chapter about [deletion of records](/en/apv/walkthrough/backend-delete) you were referred to this tutorial for
information about how to confirm such user action. Using JavaScript, we can prevent visitor's browser from sending
HTTP request which would e.g. actually delete a record from a database. Here is an example how to prevent navigation
with a confirm popup for basic `<a>` tags:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/prevent-nav-a.html %}    
{% endhighlight %}

Example above is a bit shorter in HTML code than following one which shows how to prevent `<form>` from submitting. 

{% highlight html %}
{% include /en/apv/walkthrough/javascript/prevent-nav-form.html %}
{% endhighlight %}

Notice that you have to pass that true/false value from called `confirmForm()` function using
return keyword in `onsubmit` attribute. That attribute itself is a body of event handler function
and has to return true or false to approve or cancel from subscription.

### Task -- add confirm dialog to your delete person function
Use ordinary approach with JavaScript code placed inside a template.
Carefully select where to place `<script>` tag -- remember that `{foreach ...}` duplicates
all source inside of it and you do not want multiple `<script>` tags with same function in your
markup. Try to pass person name into confirm message. You can try to use both
approaches (`href="javascript:..."` and `onsubmit="return ..."` -- for the first one you should
adjust delete script to accept data passed by GET method).

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/javascript/confirm-delete.latte %}
{% endhighlight %}

{: .note}
Remember that modifications of database records should be transmitted to server using `POST` method.
Therefore the approach which uses `href="javascript:..."` is not a clean solution.

## Form validation
Nowadays you can use much more types of [input elements](/en/apv/walkthrough/html-forms/#advanced-text-input)
than a few years ago. This means that many validations can be carried out by browser for you.
You can adjust CSS styles using `:valid`, `:ivalid` or `:required` [pseudo-classes](/en/apv/walkthrough/css/#pseudoclasses)
to visually differentiate states of inputs. Use these capabilities as much as possible. Nevertheless
you sometimes need to switch e.g. `required` state or `enable`/`disable` some input in dependence
of another input's value or dynamically calculate some additional value like price.

Here is an example with dynamic form which simulates flight reservation. I used a `<fieldset>` element
which is capable of disabling or enabling multiple inputs within it. These inputs represent optional
baggage section of a flight reservation form. Based on selected options, the price of flight is adjusted
without page reload:

![Form validation](form-validation.png)

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/javascript/form-validation.html %}
{% endhighlight %}

{: .note}
This approach often means duplicated logic in server and client scripts. A better solution is to call
some backend API which can calculate the price according to selected parameters and return it in JSON or
XML format (such approach is called [AJAX](/en/apv/articles/javascript#ajax)).

I used `document.forms` which contain object with keys given by forms `name` attributes, each form is
again an object with keys given by inputs' `name` attribute. Keys of JavaScript object can be accessed
using square brackets (where you can also use a variable) or you can just use dot notation `.key`.
There is no functional difference between `document.forms.formName` and `document["forms"]["formName"]`
or `document.forms["formName"]`. I prefer latter variant because attribute values can contain characters
like `-` which are reserved in JavaScript.

### Task -- add `required` attribute to person&address form inputs dynamically
Do you remember when I was talking about inserting [multiple records at once](/en/apv/walkthrough/backend-insert/advanced/).
You should have already created a form where you can insert a person and a place where he lives.
Try to extend this form with similar JavaScript from flight reservation example and 
add `required` attribute to some inputs that you want to be mandatory (e.g. when a user enters a
`street_name`, he should also enter a `city` -- set `required` attribute to true for both inputs
if `street_name` input has some letters inside).

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/javascript/form-validation-address.html %}
{% endhighlight %}

## Famous jQuery and other libraries
If you are digging enough around web applications, you definitely heard or read about
[jQuery](https://jquery.com). It is a library which main purpose is to help coders to achieve
desired behaviour faster. In past it also helped to overcome differences in browser's APIs.
It offers many function for manipulation with HTML, events handling and communication with backend.
It is worth trying but I think that it is not a very good idea to learn jQuery for beginners
because you will have trouble working with pure JavaScript (sometimes called
[vanilla JavaScript](http://vanilla-js.com/) -- this page tries to explain that a JS library
like jQuery is not always needed). The importance of jQuery and similar
[facade](https://en.wikipedia.org/wiki/Facade_pattern) libraries has declined as various
browsers improved/united their APIs (e.g.: to find elements using CSS selector you can
use `document.querySelector()` method instead of jQuery, event binding can be done by
`element.addEventListener()` in all modern browsers instead of jQuery's `$('.selector').click(fn)`).
Moreover, new libraries and frameworks like [React](https://facebook.github.io/react/) or
[Angular](https://angularjs.org/) emerged since jQuery's best times. 

Here is the same example of flight reservation form with jQuery style code -- notice completely
different style of accessing elements via CSS selector which is common in jQuery. This code
is not much shorter than in clean JavaScript but in some cases jQuery can shorten your code
up to one half of original.

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/javascript/form-validation-jquery.html %}
{% endhighlight %}

There are also many other JS libraries or frameworks. jQuery is used in most cases and sometimes other
libraries (like [Bootstrap](/en/apv/walkthrough/css/bootstrap/)) require you to include it as well.
Be careful about mixing different libraries -- some of them cannot or should not be used together.

Moreover, there are also [polyfill](https://en.wikipedia.org/wiki/Polyfill) libraries which are used to
simulate behaviour of modern browsers in the older ones. These libraries are used for backwards
compatibility of modern web pages with older browsers.

## Summary
This brief chapter about JavaScript programming language should help you to improve your project with instant popup
dialogs and a bit of client-side form validation. You can find more in [articles](/en/apv/articles/javascript)
section of this book.

### New Concepts and Terms
- JavaScript
- Events
- jQuery
