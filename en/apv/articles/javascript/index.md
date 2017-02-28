---
title: JavaScript
permalink: /en/apv/articles/javascript/
---

* TOC
{:toc}

In this article I want to introduce to you a *client-side* programming language called JavaScript.
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

JavaScript itself is more than a language -- it is a package of browser interface functions, HTML manipulation
functions and the language itself is called [ECMAScript](https://www.ecma-international.org/memento/TC39.htm).
It has versions such as HTML or CSS and it evolves. Current version is 6 (published in 2015) often
labeled as ES 2015 (ECMAScript 2015 -- 6th Edition). Be careful when using ES 2015 features as they might
not be supported in all browsers (even in recent versions like IE 10).

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
{% include /en/apv/articles/javascript/basics1.js %}
{% endhighlight %}

{: .note}
To try JavaScript code you do not have to write a custom HTML page, just paste this code into online
tool such as [JSFiddle](https://jsfiddle.net) (use JavaScript editor) or [Plunker](https://plnkr.co/edit/) 
and click run. Remember to open that [developer tools](/en/apv/course/not-a-student/#web-browser) console
when you work with JavaScript.

### Data types
JavaScript is dynamically typed like PHP. We have basic types: strings, numbers, booleans and also arrays
(only ordinal )and general objects. Unlike in PHP, even basic types are objects, for example you can call
methods on strings like this:

{% highlight javascript %}
var chars = "a,b,c,d,e,f".split(',');  //divide string to array
var len = "some string".length;
console.log(chars, len);
{% endhighlight %}

There is also not much difference between creating a string via String class constructor or string literal:

{% highlight javascript %}
var s1 = "some string";
var s2 = new String("continues here");
console.log(s1 + s2);
{% endhighlight %}
    
JavaScript is more strict with type conversions, sometimes you have to use `parseInt()` or `parseFloat()`
functions to convert string variable into number:
    
{% highlight javascript %}
var a = "5";
var b = 8;
console.log(a + b);             //string 58
console.log(parseInt(a) + b);   //number 13
{% endhighlight %}

### Declaring functions
Basic declaration of a function is straightforward.

{% highlight javascript %}
function something() {
}
something();    //call that function
{% endhighlight %}
    
But then you can notice, that such declaration can interfere with a variable declaration when you use same name:

{% highlight javascript %}
var fun = "a string";
function fun() {
}
fun();  //error, fun is already a string!
console.log(fun);
{% endhighlight %}
    
In JavaScript, you can store functions into variables and also work with them in such way. Function is also an
object with methods in JavaScript. This is called first-class functions. Next example shows even an anonymous
function passed into another function as argument's value.

{% highlight javascript %}
var fun1 = function(fun2) {
    fun2();
};
fun1(function() {
    console.log('this gets also called');
});
{% endhighlight %}

### Control structures
In following example you can see basic control structures `if` and `for`. There is also `while` loop and `switch`.

{% highlight javascript %}
{% include /en/apv/articles/javascript/basics2.js %}
{% endhighlight %}

There was no PHP's `foreach` equivalent in JavaScript for a long time -- you would have to use plain `for` cycle
and calculate array's length. There is a new `for...of` loop and array method `forEach()` to iterate over all array
items in ES 2015.
 
{% highlight javascript %}
{% include /en/apv/articles/javascript/basics3.js %}
{% endhighlight %}
 
{: .note}
It is possible to iterate array items with `for...in` cycle, but it is wrong and should be avoided (it treats
numeric array keys as strings for instance).

### Variable and constant declarations
In older JavaScript versions you could have used only `var` keyword to denote a new variable. A variable declared
using `var` is local in functions and global outside of them.

{% highlight javascript %}
var global = "this is a global variable";
function something() {
    var local = "this is a local variable";
    console.log(global, local); //OK
}
something();
console.log(global);    //OK
console.log(local);     //error
{% endhighlight %}

{: .note}
In fact JavaScript scans the function body and moves all variable declarations to the beginning.

New JavaScript version ES 2015 introduced also `const` and `let` keywords. The `let` keyword is interesting because
it can create variable which scope is only inside curly brackets, observe difference between these two scripts:

{% highlight javascript %}
//using var
for(var i = 1; i < 5; i++) {
    console.log(i); //1,2,3,4
}
console.log(i); //5
//using let
for(let j = 1; j < 5; j++) {
    console.log(j); //1,2,3,4
}
console.log(j); //error
{% endhighlight %}

## Linking JavaScript to your HTML
Similarly to CSS, a JavaScript file is usually referred in `<head>` tag using a `<script>` tag.
The `<script>` tag can contain URL to download some script or it can directly contain some
JavaScript code:

{% highlight html %}
{% include /en/apv/articles/javascript/attach.html %}
{% endhighlight %}

### Order and time of execution
When you add `<script>` tags to you HTML, you might wonder when is JavaScript code executed.
Basically the order is given by occurrence of `<script>` tags. Big difference is between
scripts in `<head>` and inside `<body>` as those scripts in `<head>` do not have access
to HTML elements because those were not rendered by browser yet. On the other hand `<script>`
tags in `<body>` have access to HTML elements in markup above itself.

Therefore there is a big difference in placement of `<script>` tags within your HTML code:

{% highlight html %}
{% include /en/apv/articles/javascript/order-of-execution.html %}
{% endhighlight %}

Web developers often want their JavaScript to execute when all HTML tags are loaded into browser.
To achieve this an event called `onload` is used and most JavaScript code is executed in it.
When you use `onload` event it does not matter whether you put you `<script>` tag into `<head>` or
just before `</body>`.

### Interacting with HTML elements
You obviously have to interact with existing (static) HTML structure somehow to achieve dynamic
behaviour. Your browser has capability to project changes in HTML structure, HTML attributes
and CSS thanks to [dynamic HTML](https://en.wikipedia.org/wiki/Dynamic_HTML) technologies.
This means that you can append/remove/modify HTML elements using JavaScript and your browser
will draw these changes immediately on the screen.

To obtain an HTML element from document's structure use one of the following functions:

- `document.getElementById("id_value")` -- returns one element found by its `id` attribute
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

### JavaScript events
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
{% include /en/apv/articles/javascript/events.html %}
{% endhighlight %}

{: .note}
The reason why we used Latte templates was to divide program logic and view logic. It is the same with JavaScript:
you should not mix HTML and JavaScript code. Ideally put all JavaScript into separate file(s) and use it to attach all
event handlers.

## Variable scope
It is not unusual to see a function declared inside another function. It can happen you when pass callbacks or
event handlers. In such case, function declared inside another has access to variables from outer scope.

{% highlight javascript %}
window.addEventHandler("load", function() {
    var a = "variable a";
    var btn = document.getElementById("...");
    btn.addEventListener("click", function() {
        console.log(a); //outputs 'variable a'
    });
});
{% endhighlight %}

This is useful, but be careful when you want to attach same event to multiple HTML elements with a variable
which changes its content in outer scope.

{% highlight javascript %}
window.addEventHandler("load", function() {
    var allLinks = document.getElementsByTagName("button");
    for(var i = 0; i < allLinks.length; i++) {
        allLinks[i].addEventListener("click", function() {
            console.log(i);
        });
    }
});
{% endhighlight %}

It does not matter on whichever `<a>` element you click, you always get last value of variable `i` in console
because the handler is executed after the `for` loop and variable `i` already changed its value to `allLinks.length`.
In another words, there is only one variable `i` with one value in computer's memory and all event handlers 
refer to it. You have either have to use the `let` keyword or construct a *closure*.

{% highlight javascript %}
window.addEventHandler("load", function() {
    function produceEventHandler(val) {
        //return function which will serve as event handler, variable val is locked to value given when executing this
        return function() {
            console.log(val);
        }
    };
    var allLinks = document.getElementsByTagName("button");
    for(var i = 0; i < allLinks.length; i++) {
        //call a function which generates the event handler
        allLinks[i].addEventListener("click", produceEventHandler(i));
    }
});
{% endhighlight %}

## AJAX
AJAX stands form *asynchronous JavaScript and XML* although [JSON](http://json.org) format is currently
much more common. The basic principle is that a browser calls some backend function using JavaScript
HTTP client (the visitor does not have to be aware of this at all) and retrieves some data (originally
XML but it can also be JSON, piece of HTML or just plain text). This data can be inserted into HTML page
without its reload. Asynchronous means that the visitor is not blocked from other interaction with site
during that HTTP request -- there can even be multiple HTTP requests processed at once.

### XMLHttpRequest

### Example

## Summary
Remember that JavaScript is executed inside a browser. Therefore it cannot store any data on a server --
you always need some kind of backend which can communicate securely with your database.
It is possible to write JavaScript backend scripts with [Node.js](https://nodejs.org/) but it
really does not matter. Ratio of JavaScript executed inside visitor's browser and backend code
can vary from 99% to 0%. But without **some** backend code, you cannot create any useful web application.
The main effect of this effort is to deliver to your users more dynamic page with better usability.

As you probably noticed, browser's APIs are quiet bulky and not very convenient. Therefore there are
JavaScript libraries like [jQuery](/en/apv/javascript/jquery) with more effective expression.

Now you know that most visual effect or desktop-application-like behaviour of a website is caused
by JavaScript. Another thing to remember is that JavaScript has vast ecosystem of libraries and frameworks
and I am not going to get much deeper into this topic in this book.

TODO:
- browser API (document - DOM, window - BOM)
- *this* variable:
    - inside a global function (this == window)
    - inside an event handler (is element that event took place on)
    - how to pass this into event handler (var self = this; or arrow function expression: () => {} or let)
- *var* vs *let* keyword
- ~~"foreach"~~
    - ~~iteration over object's attributes for(var i in obj) {}~~
    - ~~iteration over array for(var i of arr) {}~~
- AJAX
    - XMLHttpRequest
    - return piece of HTML or JSON