---
title: JavaScript
permalink: /en/apv/walkthrough/javascript/
---

* TOC
{:toc}

In this article I want to introduce a *client-side* programming language called JavaScript.
*Client-side* means, that scripts written in this language are executed in a web browser (client).
This is a new concept for you which opens a lot of possibilities: you know that a browser is capable of
rendering HTML with CSS, displaying images, maybe you know that you can also play video and audio
in newer browsers using appropriate HTML tags (all this is very nice, but still the browser is a bit
stupid). Executing scripts in the browser during the time when a visitor is viewing your website can
improve his experience a lot. Just by hiding or showing some HTML elements or changing some CSS
styles dynamically, can substantially improve (or reduce) readability of your page and increase speed
of browsing (visitors do not have to wait for the server to process their requests).

A lot of pages use JavaScript very heavily nowadays. Sites like YouTube, Google drive/docs, Facebook
are mostly built using this technology. When you transfer significant part of program logic into JavaScript,
you can deliver desktop-app experience to your users. This architecture is called
[Single Page Application](https://en.wikipedia.org/wiki/Single-page_application) (SPA).

I will not teach you how to build application entirely with JavaScript, I will show you how to use
this language to overcome most common problems with user interface -- quickly confirm some action or
validate a form before it is send to backend.

JavaScript itself is more than a language -- it is a package of browser interface functions, HTML manipulation
functions and the language itself is called [ECMAScript](https://www.ecma-international.org/memento/TC39.htm).
It has versions such as HTML or CSS and it evolves. Current version is 6 (published in 2015).

A good source of information about JavaScript is [Mozilla Developer Network](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
(MDN) page.

## JavaScript basics
JavaScript is often misunderstood language, it has syntax similar to Java, PHP or C++; its name refers
to Java but it is much different. JavaScript is object oriented like Java, but definition of a class
is not familiar at all. It has first-class functions (a function which can be stored in a variable) and
it is dynamically typed (variable type is defined by content like in PHP). Complex source code written
in JavaScript is much different to anything you probably know. I will start with some basic examples
which I believe would not confuse you at all; `console.log()` sends its output to browser's developer
tools console (usually activated by F12 key).

Here is a brief JavaScript demo:

{% highlight javascript %}
{% include /en/apv/walkthrough/javascript/basics1.js %}
{% endhighlight %}

{: .note}
To try JavaScript code you do not have to write a custom HTML page, just paste this code into online
tool such as [JSFiddle](https://jsfiddle.net) (use JavaScript editor) or [Plunker](https://plnkr.co/edit/) 
and click run. Remember to open that [developer tools](/en/apv/course/not-a-student/#web-browser) console
when you work with JavaScript.

In following example you can see control structures:

{% highlight javascript %}
{% include /en/apv/walkthrough/javascript/basics2.js %}
{% endhighlight %}

## Linking JavaScript to your HTML
Similarly to CSS, a JavaScript file is usually referred in `<head>` tag using a `<script>` tag.
The `<script>` tag can contain URL to download some script or it can directly contain some
JavaScript code:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/attach.html %}
{% endhighlight %}

You can use multiple function to locate and work with HTML elements -- the easiest one is
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

{: .note}
Avoid changing of particular CSS styles in JavaScript. It is tedious and makes your code confusing.
You should rather add or remove a CSS classes (there is a [`classList`](https://developer.mozilla.org/cs/docs/Web/API/Element/classList)
field of HTML element for efficient work with CSS classes).

{% highlight html %}
{% include /en/apv/walkthrough/javascript/html-attributes-styles.html %}
{% endhighlight %}

Each element can have a set of child nodes -- you can remove or ad children with `elem1.appendChild(elem2)`
and `elem1.removeChild(elem2)` methods. To create a new element you can use `var newElem = document.createElement("tag")`
method.

### Order and time of execution
When you add `<script>` tags to you HTML, you might wonder when is JavaScript code executed.
Basically the order is given by occurrence of `<script>` tags. Big difference is between
scripts in `<head>` and inside `<body>` as those scripts in `<head>` do not have access
to HTML elements because those were not rendered by browser yet. On the other hand `<script>`
tags in `<body>` have access to HTML elements in markup above itself.

Therefore there is a big difference in placement of `<script>` tags within your HTML code:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/order-of-execution.html %}
{% endhighlight %}

Web developers often want their JavaScript to execute when all HTML tags are loaded into browser.
To achieve this an event called `onload` is used and most JavaScript code is executed in it.
When you use `onload` event it does not matter whether you put you `<script>` tag into `<head>` or
just before `</body>`.

## JavaScript events
Events are type of signals which are broadcasted to JavaScript event listeners (functions)
when some action takes place. For example a user can click a button, move a mouse or a timer ticks:

{% highlight html %}
<button onclick="clickButtonHandler(event)">Click me - console.log()!</button>
<button onclick="alert('Hello!')">Click me - alert()!</button>
{% endhighlight %}

{% highlight html %}
<script type="text/javascript">
    function clickButtonHandler(event) {
        console.log('Button clicked', event);
    }
</script>
{% endhighlight %}

Open developer console (F12) and try to click this button or the other:

<button onclick="clickButtonHandler(event)">Click me - console.log()!</button>
<button onclick="alert('Hello!')">Click me - alert()!</button>
<script type="text/javascript">
    function clickButtonHandler(event) {
        console.log('Button clicked', event);
    }
</script>

You should see something like this in developer console:

![console.log() output](console-log.png)

That weird stuff which is logged along with 'Button clicked' text is an *event object* describing
what happened. Event object also has methods: most used ones are `event.preventDefault()` to prevent
browser from executing default actions (form submission, navigation, typing...) and `event.stopPropagation()`
to stop processing event (in case that more handler functions are registered to same event). Special event
is `onload` of `<body>` element which signals that whole page is loaded (but it can be also attached to
particular `<img>` elements).

You can attach events as HTML attributes like in example above or you can use programmatic approach
which is much cleaner because it won't complicate your HTML code:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/events.html %}
{% endhighlight %}

{: .note}
The reason why we used Latte templates was to divide program logic and view logic. It is the same with JavaScript:
you should not mix HTML and JavaScript code. Ideally put all JavaScript into separate file(s) and use it to attach all
event handlers.

### Task -- toggle a class of HTML element using a button click
Make a button and any HTML element with an `id` attribute. Attach click event to button using an `onclick` attribute.
Toggle some CSS class on element with `id` using `element.classList.toggle('className')` method. Obviously you
also need a CSS class with some visual properties.

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/javascript/events-toggle-css.html %}
{% endhighlight %}

## Using JavaScript to confirm user actions
In chapter about [delete](/en/apv/walkthrough/backend-delete) you were referred to this tutorial for information about
how to confirm user action. Using JavaScript we can prevent visitor's browser from sending HTTP request which would e.g.
actually delete a record from a database. Here is an example how to prevent navigation with a confirm popup for basic
`<a>` tags:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/prevent-nav-a.html %}    
{% endhighlight %}

Example above is a bit shorter in HTML code than following one which shows how to prevent `<form>` from submitting. 

{% highlight html %}
{% include /en/apv/walkthrough/javascript/prevent-nav-form.html %}
{% endhighlight %}

Notice that you have to pass that true/false value from called `confirmForm()` function using
return keyword in `onsubmit` attribute. That attribute itself is a body of event handler function
and has to return true or false to approve or cancel from subscription. If you want to use
`formElement.addEventListener()` method in this case, stop the event by calling `eventObject.preventDefault()`
inside handler instead of returning `false`.

### Task -- add confirm dialog to your delete person function
Carefully select where to place `<script>` tag -- remember that `{foreach ...}` duplicates
all source inside of it and you do not want multiple `<script>` tags with same function in your
markup. Try to pass person name into confirm message. You can try to use both
approaches (`href="javascript:..."` and `onsubmit="return ..."` -- for the first one you should
adjust delete script to accept data from GET method).

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
XML format.

I used `document.forms` which contain object with keys given by forms `name` attributes, each form is
again an object with keys given by inputs `name` attributes. Keys of JavaScript object can be accessed
using square brackets (where you can also use a variable) or you can just use dot notation `.key`.
There is no functional difference between `document.forms.formName` and `document["forms"]["formName"]`
or `document.forms["formName"]`. I prefer latter variant because attribute values can contain characters
like `-` which are reserved.

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

There are also many [polyfill](https://en.wikipedia.org/wiki/Polyfill) libraries which are used to
simulate behaviour of modern browsers in the older ones. These libraries are used for backwards
compatibility of modern web pages with older browsers.

## Summary
Remember that JavaScript is executed inside a browser. Therefore it cannot store any data on a server --
you always need some kind of backend which can communicate securely with your database.
It is possible to write JavaScript backend scripts with [Node.js](https://nodejs.org/) but it
really does not matter. Ratio of JavaScript executed inside visitor's browser and backend code
can vary from 99% to 0%. But without **some** backend code, you cannot create any useful web application.
The main effect of this effort is to deliver to your users more dynamic page with better usability.

Now you know that most visual effect or desktop-application-like behaviour of a website is caused
by JavaScript. Another thing to remember is that JavaScript has vast ecosystem of libraries and frameworks
and I am not going to get much deeper into this topic in this book.

### New Concepts and Terms
- JavaScript
- Events
- jQuery
