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
improve his experience a lot. Just hiding or showing some HTML elements or changing some CSS
styles dynamically can substantially improve (or reduce) readability of your page and increase speed
of browsing (visitors do not have to wait for the server to process their requests).

A lot of pages use JavaScript very heavily nowadays. Sites like YouTube, Google drive/docs, Facebook
are mostly built using this technology. When you transfer significant part of program logic into JavaScript,
you can deliver desktop-app experience to your users. This architecture is called
[Single Page Application](https://en.wikipedia.org/wiki/Single-page_application) (SPA).

JavaScript itself is more than a language -- it is a package of browser interface functions, HTML manipulation
functions and the language itself is called [ECMAScript](https://www.ecma-international.org/memento/TC39.htm).
It has versions such as HTML or CSS and it evolves. Current version is 6 (published in 2015) often
labeled as ES 2015 (ECMAScript 2015 -- 6th Edition). Be careful when using ES 2015 features as they might
not be supported in all browsers (even in recent versions like IE 10/11).

A good source of information about JavaScript is [Mozilla Developer Network](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
(MDN) page.

## JavaScript basics
JavaScript is often misunderstood language, it has syntax similar to Java, PHP or C++; its name refers
to Java but it is much different. JavaScript is object oriented like Java, but definition of a class
is not familiar at all. It has first-class functions (a function which can be stored in a variable) and
it is dynamically typed (variable type is defined by content like in PHP). Complex source code written
in JavaScript is much different to anything you probably know thanks to heavy use of anonymous functions.
I will start with some basic examples which I believe would not confuse you at all; `console.log()` sends
its output to browser's developer tools console (usually activated by F12 key).

Here is a brief JavaScript demo and an overview of basic syntax and types:

{% highlight javascript %}
{% include /en/apv/articles/javascript/basics1.js %}
{% endhighlight %}

{: .note}
To try JavaScript code you do not have to write a custom HTML page, just paste this code into online
tool such as [JSFiddle](https://jsfiddle.net) (use JavaScript editor) or [Plunker](https://plnkr.co/edit/)
and click run. Remember to open that [developer tools](/en/apv/course/not-a-student/#web-browser) console
when you work with JavaScript.

### Data types
JavaScript is dynamically typed like PHP. We have basic types: *strings*, *numbers*, *booleans* and also *arrays*
(only ordinal) and general *objects*. Unlike in PHP, even basic types are objects, for example you can call
methods or access object's attributes on strings like this:

{% highlight javascript %}
var chars = "a,b,c,d,e,f".split(',');   //divide string to array
console.log(chars, chars.length);       //print array and its length
var len = "some string".length;         //get length of string...
console.log(len);                       //...and display it
{% endhighlight %}

There is also not much difference between creating a string via String class constructor or string literal:

{% highlight javascript %}
var s1 = "some string";
var s2 = new String("continues here");
console.log(s1 + s2);
{% endhighlight %}

JavaScript is more strict with type conversions than PHP (or just different), sometimes you have to use
`parseInt()` or `parseFloat()` functions to convert string variable into number:

{% highlight javascript %}
var a = "5";
var b = 8;
console.log(a + b);             //string 58
console.log(parseInt(a) + b);   //number 13
{% endhighlight %}

{: .note}
There is no special operator to concatenate string like in PHP (the `.` operator). Maybe it is not a very good idea
to compare JavaScript with PHP because they languages with different history and background. But they are both used
to develop web pages.

### Declaring functions
Basic declaration of a function is straightforward.

{% highlight javascript %}
function something() {
}
something();    //call that function
{% endhighlight %}

But then you can notice, that such declaration can interfere with a variable declaration if you use same name
(variables' and functions' identifiers are stored together although variables have higher priority):

{% highlight javascript %}
var fun = "a string";
function fun() {
}
fun();                  //error, fun is already a string!
console.log(fun);       //outputs 'a string'
{% endhighlight %}

In JavaScript, you can store functions into variables and also work with them in such way. Function is also an
object with methods in JavaScript. This is called *first-class functions*. Next example shows even an anonymous
function passed into another function as argument's value.

{% highlight javascript %}
//store function into a variable
var fun1 = function(fun2) {
    fun2();
};  //note the ; this line is just and assignment of a value to a variable
//call that function with another as parameter
fun1(function() {
    console.log('this gets also called');
});
{% endhighlight %}

### Control structures
In following example you can see basic control structures `if` and `for`. There is also a `while` loop and a `switch`
statement.

{% highlight javascript %}
{% include /en/apv/articles/javascript/basics2.js %}
{% endhighlight %}

There was no PHP's `foreach` equivalent in JavaScript for a long time -- you would have to use plain `for` cycle
and obtain array's length. There is a new [`for...of` loop](https://developer.mozilla.org/en/docs/Web/JavaScript/Reference/Statements/for...of)
in ES 2015 and array [method `forEach()`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/forEach)
to iterate over all array items (this one was standardized earlier). You can use [`for...in` loop](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...in)
to iterate over all object's properties.

{% highlight javascript %}
{% include /en/apv/articles/javascript/basics3.js %}
{% endhighlight %}

{: .note}
It is possible to iterate array items with `for...in` cycle, but it is wrong and should be avoided (it treats
numeric array keys as strings for instance and does not guarantee order of items).

{: .note.note-cont}
The [arrow function expression `(a, b) => {...}`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions)
is just a shortcut to declare an anonymous function. There is one important difference against a declaration using
`function() {}` that I will explain later.

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
In fact, JavaScript scans the function body and moves all variable declarations to the beginning.

New JavaScript version ES 2015 introduced also `const` and `let` keywords. The `let` keyword is interesting because
it can create variable which scope is only inside curly brackets, observe difference between these two pieces of code:

{% highlight javascript %}
//using var
for(var i = 1; i < 5; i++) {
    console.log(i); //1,2,3,4
}
console.log(i); //5
{% endhighlight %}

{% highlight javascript %}
//using let
for(let j = 1; j < 5; j++) {
    console.log(j); //1,2,3,4
}
console.log(j); //error
{% endhighlight %}

## Linking JavaScript to your HTML
Similarly to CSS, a JavaScript file is usually referred in `<head>` tag using a `<script>` tag. But you can generally
place the `<script>` tag anywhere inside the `<body>` element. The `<script>` tag can contain a `src` attribute with
an URL to download some JavaScript source code or the tag can contain some JavaScript code directly:

{% highlight html %}
{% include /en/apv/articles/javascript/attach.html %}
{% endhighlight %}

### Order and time of execution
When you add `<script>` tags to your HTML, you might wonder when is JavaScript code executed.
Basically the order is given by occurrence of `<script>` tags. Big difference is between
scripts in the `<head>` and inside the `<body>` as those scripts in the `<head>` do not have access
to HTML elements because those were not rendered by browser yet. On the other hand `<script>`
tags inside the `<body>` element have access to HTML elements in markup above itself.

Therefore there is a big difference in placement of `<script>` tags within your HTML code:

{% highlight html %}
{% include /en/apv/articles/javascript/order-of-execution.html %}
{% endhighlight %}

Web developers often want their JavaScript to execute when all HTML tags are loaded into browser.
To achieve this an *event* called `onload` is used and most JavaScript code is executed in it.
When you use `onload` event it does not matter whether you put your `<script>` tag into `<head>` or
just before `</body>`. I will tell you more about events later.

### Interacting with HTML elements
You obviously have to interact with existing (static) HTML structure somehow to achieve dynamic
behaviour. Your browser has capability to project changes in HTML structure, HTML attributes
and CSS thanks to [dynamic HTML](https://en.wikipedia.org/wiki/Dynamic_HTML) technologies.
This means that you can append/remove/modify HTML elements using JavaScript and your browser
will draw these changes immediately on the screen. You do not have call any function to request
repaint elements' new state.

To obtain an HTML element from document's structure use one of the following functions:

- `document.getElementById("id_value")` -- returns one element found by its `id` attribute
- `document.getElementsByTagName("table")` -- returns collection of elements by given tag name
- `document.getElementsByClassName("some-class")` -- returns collection of elements by given class attribute
- `document.querySelector(".some-css-selector")` -- returns first element matched by given [CSS selector](/en/apv/articles/css/#selectors)
- `document.querySelectorAll(".some-css-selector")` -- returns collection of elements matched by given [CSS selector](/en/apv/articles/css/#selectors)

To access standard HTML attributes of retrieved elements just type `element.attr` (e.g. `console.log(link.href)` for
`<a>` element). An exception is `class` attribute which is accessed using `element.className`. To change CSS styles use
`element.style` object followed by *camelCase* style name (e.g. CSS property `background-color` can be accessed with
`element.style.backgroundColor`). Another special attribute is `innerHTML` which can be used to change content of an
element. You might remember about [user defined attributes](/en/apv/articles/html/#data-attributes) which are found
under `element.dataset.*` field.

### Document object (DOM -- Document Object Model)
Those `document.*` methods mentioned before are part of [DOM](https://developer.mozilla.org/en-US/docs/Web/API/Document).
It is an object that contains structure of HTML elements presented by the browser and also methods/attributes to
manipulate them. It contains a key called `body` which is a reference to HTML `<body>` element (there is also `head`
attribute, but that is not used often). The `document` contains nested HTML elements in `childNodes` attribute
collection. Every other child has `childNodes` attribute too -- they form a tree. DOM is standardized by [W3C](https://www.w3.org/standards/techs/dom).

{% highlight javascript %}
console.log(document.head);
console.log(document.body);
console.log(document.childNodes);       //only <html> node
console.log(document.body.childNodes);  //body's child nodes
{% endhighlight %}

Try to type some of those lines mention above into console (in the very bottom of the console you can write actual
JavaScript commands).

![Interactive console](interactive-console.png)

Each node in DOM has [methods and attributes](https://developer.mozilla.org/en-US/docs/Web/API/Node), most important
ones are:

- [node.appendChild()](https://developer.mozilla.org/en-US/docs/Web/API/Node/appendChild) -- insert an element as a
  child of `node` (new element will be last child)
- [node.removeChild()](https://developer.mozilla.org/en-US/docs/Web/API/Node/removeChild) -- remove given element from
  child collection of `node`
- [node.insertBefore()](https://developer.mozilla.org/en-US/docs/Web/API/Node/insertBefore) -- insert an element before
  another child of `node` (similar to `appendChild`)
- [node.childNodes](https://developer.mozilla.org/en-US/docs/Web/API/Node/childNodes)
- [node.firstChild](https://developer.mozilla.org/en-US/docs/Web/API/Node/firstChild) -- first child of `node`, can be
  used to insert new element as first child using `node.insertBefore(newNode, node.firstChild)`
- [node.lastChild](https://developer.mozilla.org/en-US/docs/Web/API/Node/lastChild) -- last child of `node`
- [node.parentElement](https://developer.mozilla.org/en-US/docs/Web/API/Node/parentElement) -- parent element of `node`

There is a difference between [DOM Node](https://developer.mozilla.org/en-US/docs/Web/API/Node) and
[DOM Element](https://developer.mozilla.org/en-US/docs/Web/API/Element), elements are only HTML tags, nodes
are also texts between elements and [other stuff](https://developer.mozilla.org/en-US/docs/Web/API/Node/nodeType).
You will encounter elements most of the times, DOM Element inherits methods and properties from the DOM Node.

To create an element use `var newElem = document.createElement('tag_name')` method.

{: .note}
You can find special collections like [`document.forms`](https://developer.mozilla.org/en-US/docs/Web/API/Document/forms),
[`document.scripts`](https://developer.mozilla.org/en-US/docs/Web/API/Document/scripts) or [`document.links`](https://developer.mozilla.org/en-US/docs/Web/API/Document/links)
on `document` object.

### Window object (BOM -- Browser Object Model)
The [`window` variable](https://developer.mozilla.org/en-US/docs/Web/API/Window) represents current browser's window
or tab. It is the main variable in JavaScript, when a JavaScript interpret encounters unknown variable, it looks
for it in set of `window` object's properties.

{% highlight javascript %}
console.log(window);
console.log('This is same...', document);
console.log('...as this', window.document);
{% endhighlight %}

{% highlight javascript %}
window.anything = "can be used as global variable";
console.log(anything);
{% endhighlight %}

Be careful with names of global variables -- you can easily overwrite some predefined global variables like `console`,
`screen` (information about screen size), `document` (the DOM), `history` (window history), `location` (current URL in
address bar)... Some more information about current browser can be found in `widnow.navigator` property.

Following example nicely demonstrates that JavaScript scans for `var` declarations and moves them to top. You would
expect to output `document` object on first line but JavaScript outputs `undefined` because the variable has not
been assigned a value yet.

{% highlight javascript %}
console.log('No content', document);    //strange!
var document = "not a document anymore";
console.log('Still works', window.document);
console.log('New content', document);
{% endhighlight %}

### JavaScript events
Events are type of signals which are broadcasted to JavaScript event listeners (functions)
when some action takes place. For example a user can click a button, press a key, resize or scroll the window, navigate
to another site or move a mouse. There are also events that are not associated directly with user actions, it can be
timer ticks or when the browser finishes loading of the page or particular image:

{% highlight html %}
<script type="text/javascript">
    function clickButtonHandler(event) {
        console.log('Button clicked', event);
    }
</script>
<button onclick="clickButtonHandler(event)">Click me - console.log()!</button>
<button onclick="alert('Hello!')">Click me - alert()!</button>
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

You can attach events as an HTML attributes like in example above or you can use programmatic approach
which is much cleaner because it won't complicate your HTML code:

{% highlight html %}
{% include /en/apv/articles/javascript/events.html %}
{% endhighlight %}

{: .note}
The reason why we used Latte templates was to divide program logic and view logic. It is the same with JavaScript:
you should not mix HTML and JavaScript code. Ideally put all JavaScript into separate file(s) and use it to attach all
event handlers.

A good example which shows how to completely divide HTML and JavaScript code follows.

{% highlight html %}
{% include /en/apv/articles/javascript/prevent-nav-form-divided.html %}
{% endhighlight %}

{% highlight javascript %}
{% include /en/apv/articles/javascript/prevent-nav-form-divided.js %}
{% endhighlight %}

{: .note}
When you use `formElement.addEventListener('submit', ...)` to register an event, you have to prevent the browser from
submitting the form by calling `eventObject.preventDefault()` inside handler instead of returning `false` like mentioned
in [walkthrough example](/en/apv/walkthrough/javascript/#using-javascript-to-confirm-user-actions).

It is possible to work with special variable called `this` inside event handlers. That variable holds reference to an
HTML element which fired event.

{: .solution}
{% highlight html %}
{% include /en/apv/articles/javascript/using-this-events.html %}
{% endhighlight %}

The `this` variable has different meanings in different situations:

- in event handlers it contains reference to an HTML element
- in global function it same as the `window` variable
- in methods of objects it contains reference to current instance

{: .note}
It is possible to change `this` variable content by using function's methods [`call()`](https://developer.mozilla.org/en/docs/Web/JavaScript/Reference/Global_Objects/Function/Call)
or [`apply()`](https://developer.mozilla.org/en/docs/Web/JavaScript/Reference/Global_Objects/Function/Call).

#### Removing events
Sometimes you need to detach an event in JavaScript code. You can simply do that by calling
[`element.removeEventListener(eventHandler)`](https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/removeEventListener)
method in your code. You cannot use anonymous function in this case because you need a reference to `eventHandler`.

{% highlight javascript %}
var element = document.getElementById("...");
var eventHandler = function() {
    console.log("click");
    //remove the click handler
    this.removeEventListener("click", eventHandler);
};
element.addEventListener("click", eventHandler);
{% endhighlight %}

## Variable scope
It is not unusual to see a function declared inside another function in JavaScript code. It can happen when you need to
pass callbacks or event handlers. In such case, function declared inside another has access to variables from outer scope.

{% highlight javascript %}
window.addEventHandler("load", function() {
    //variable is declared here (it is local for onload handler)
    var a = "variable a";
    var btn = document.getElementById("...");
    btn.addEventListener("click", function() {
        //click handler has also access to that variable
        console.log(a); //outputs 'variable a'
    });
});
{% endhighlight %}

This is useful, but be careful when you want to attach same event to multiple HTML elements with a variable
which changes its content in outer scope -- weird stuff starts to happen.

{% highlight javascript %}
window.addEventListener("load", function() {
    //find multiple buttons...
    var allButtons = document.getElementsByTagName("button");
    for(var i = 0; i < allButtons.length; i++) {
        //...attach an event to each of them
        allButtons[i].addEventListener("click", function() {
            //logs last value of i, not individual values
            console.log(i);
        });
    }
});
{% endhighlight %}

It does not matter on whichever `<button>` element you click, you always get last value of variable `i` in console
because the handler is executed after the `for` loop and variable `i` already changed its value to `allLinks.length`.
In another words, there is only one variable `i` with one value in computer's memory and all event handlers
refer to it. You either have to use the `let` keyword or construct a *closure*.

{% highlight javascript %}
window.addEventListener("load", function() {
    function makeEventHandler(val) {
        /*
            return function which will serve as event handler, variable
            val is locked to value given when executing makeEventHandler
        */
        return function() {
            console.log(val);
        }
    };
    var allLinks = document.getElementsByTagName("button");
    for(var i = 0; i < allLinks.length; i++) {
        //call a function which generates the event handler
        allLinks[i].addEventListener("click", makeEventHandler(i));
    }
});
{% endhighlight %}

Thanks to `let` keyword we can use almost same code as originally intended:

{% highlight javascript %}
window.addEventListener("load", function() {
    var allButtons = document.getElementsByTagName("button");
    for(let i = 0; i < allButtons.length; i++) {
        //variable i is different for each iteration
        allButtons[i].addEventListener("click", function() {
            console.log(i);
        });
    }
});
{% endhighlight %}

Lets return a bit and talk about `this` variable again. Put yourself into a situation when you need to register event
handlers based on user action (inside another event handler). Perhaps you need a `<button>` which generates new HTML
content and this content is responsible for hiding original `<button>` element after user performs some consequent
action. It means, that you need to pass reference for the first `<button>` into event handler attached to second,
newly created one. You know that you can use `this` in first click event handler

{: .solution}
{% highlight html %}
{% include /en/apv/articles/javascript/passing-this-events.html %}
{% endhighlight %}

This can also be achieved with *arrow expression* `() => {}` mentioned before. This kind of function declaration
does not introduce its own `this` variable and you can use `this` from parent scope.

{: .solution}
{% highlight html %}
{% include /en/apv/articles/javascript/passing-this-events-arrow.html %}
{% endhighlight %}

## Timers
There are two types of timers in JavaScript -- an interval and a timeout. The difference is that interval timer ticks
permanently. The functions which are used to setup interval are similar: `setInterval(callback, delay)` and
`setTimeout(callback, delay)`. They both return a reference to cancel timer by `clearTimeout(ref)` or
`clearInterval(ref)` functions. The delay is specified in milliseconds.

{% highlight javascript %}
var ref;
function startTimer() {
    var c = 0;
    ref = setInterval(function() {
        console.log(c++);
    }, 1000);
}
function stopTimer() {
    clearInterval(ref);
}
{% endhighlight %}

Open developers console and try to click following buttons you should be able to see a number to increment every second:

<script type="text/javascript">
var ref;
function startTimer() {
    var c = 0;
    ref = setInterval(function() {
        console.log(c++);
    }, 1000);
}
function stopTimer() {
    clearInterval(ref);
}
</script>

<button onclick="startTimer()">Start timer</button>
<button onclick="stopTimer()">Stop timer</button>

## Classes and inheritance
You can create an instance of an object in JavaScript just by assigning object literal to a variable -- `var x = {...}`.
This approach is not very universal. It is useful to define a *class* and derive instances of objects from it using
`new` keyword -- this is similar to Java or [PHP OOP approach](/en/apv/walkthrough/dynamic-page/objects/).
Traditional JavaScript (i.e. that one which is executable in all browsers) has unfamiliar class definition based
on prototypes:

{% highlight javascript %}
//a function which will be used as a constructor
var SomeClass = function(value) {
    this.value = value;
};
//this is a method
SomeClass.prototype.getValue = function() {
    return this.value;
};
//create an instance
var instanceOfSomeClass = new SomeClass(5);
//and call some method
console.log(instanceOfSomeClass.getValue());
{% endhighlight %}

{: .note}
Use [CamelCase](https://en.wikipedia.org/wiki/Camel_case) variable names to emphasize that a variable is intended to
contain a class definition.

The `prototype` property of a function object is a container for methods that are mapped to an instance being created
using `new` keyword. In method's context, the `this` variable refers to individual instance. An interesting point is
that you can change prototype of a class and all instances will notice that change even if they were created
before that change. You should not return anything from constructor -- JavaScript would use that value as a result
of `new` operator which is not intuitive. Do not call constructors as regular functions also, that would cause to
create unwanted global variables because `this` variable points to `window` object in global function's context.

Inheritance is achieved by chaining of prototypes, here is a simple example:

{% highlight javascript %}
//general class
var Rectangle = function(w, h) {
    this.w = w;
    this.h = h;
};
Rectangle.prototype.getArea = function() {
    return this.w * this.h;
};
//specialized class
var Square = function(s) {
    Rectangle.call(this, s, s);
};
//inheritance - must be after constructor and before methods
Square.prototype = new Rectangle();
Square.prototype.constructor = Square;
//now you can define methods which belong only to Square class
Square.prototype.enlarge = function(step) {
    this.w = this.w + step;
    this.h = this.w;
};
var sq = new Square(8);
var rt = new Rectangle(10, 5);
console.log('Square area', sq.getArea());
console.log('Rectangle area:', rt.getArea());
sq.enlarge(2);
console.log('Larger square area:', sq.getArea());
rt.enlarge(2);  //error
{% endhighlight %}

The line with `Square.prototype = new Rectangle();` is crucial. It simply creates an instance of a Rectangle and assigns
it as prototype of a Square class. This basically makes all Rectangle methods accessible in Square's prototype. Next
line reverts constructor to Square function, it is not very important and the code works without it but some
[constructions depend on it](http://stackoverflow.com/questions/8453887/why-is-it-necessary-to-set-the-prototype-constructor).
Note that `new Rectangle()` is called without arguments -- you should make your constructors in a way that this fact does
not raise fatal errors (or pass the needed values).

{: .note}
You can use [ordinary `class` and `extends` keywords](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes)
to define classes in new versions of JavaScript.

## AJAX
AJAX stands for *asynchronous JavaScript and XML* although [JSON](http://json.org) format is currently much more
common. The basic principle is that a browser calls some backend functionality using JavaScript HTTP client (the visitor
does not have to be aware of this at all) and retrieves some data (originally XML but it can also be JSON, piece of
HTML or just plain text). This data can be inserted into HTML page without its reload thanks to dynamic HTML
technologies. Asynchronous means that the visitor is not blocked from other interaction with site during that HTTP
request. There can even be multiple HTTP requests processed at once.

### XMLHttpRequest
This object is responsible for HTTP communication controlled by JavaScript. Its [API](https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest)
allows you to open a HTTP connection and check its progress when it [changes](https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/readyState)
using an [event handler](https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/onreadystatechange).

Let's create a very small and simple example -- a calculator that just adds two integers. We need a PHP backend to
provide results. This file can read parameters from query and returns JSON object instead of standard HTML.

`calculate.php` file:

{% highlight php %}
{% include /en/apv/articles/javascript/ajax/calculate.php %}
{% endhighlight %}

And we need a JavaScript to talk with backend and deliver results into HTML page. The JavaScript code simply opens
HTTP connection using GET method to `calculate.php` script with correct query parameters and waits for its response.
If everything goes smooth, PHP returns HTTP code 200 and JSON data that can be parsed by JavaScript's
[JSON](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON) library.

`index.html` file:

{: .solution}
{% highlight html %}
{% include /en/apv/articles/javascript/ajax/index.html %}
{% endhighlight %}

Put both files into same directory and open `index.html` in your browser, fill the form and press button. You can try
to open `calculate.php` too and pass query parameters to observe JSON output.

Take a look into network console (also under F12 but switch to *Network* tab) and observe what your browser sends
and receives when you press Calculate button. To view request parameters and response body click the HTTP request
to `calculate.php` file (you can use XHR filter) and than select Parameters tab and Response tab. I used Firefox
browser but Chrome developers tools are very similar.

{: .image-popup}
![console.log() output](ajax-network-1.png)

{: .image-popup}
![console.log() output](ajax-network-2.png)

{: .note}
Timer functions are often used to poll backend when you need to deliver "continuous" updates. A better solution is to
use [WebSocket](https://developer.mozilla.org/en-US/docs/Web/API/WebSocket) but this is a bit more complicated and
requires support of backend (PHP script cannot run longer than certain amount of time -- usually 30 seconds).

## Promises
Asynchronous nature of JavaScript is often hard to grasp for people who started with backend development in PHP
where code execution usually flows from top to bottom. In JavaScript you have to think about the code differently:
events are fired in random order according to user's actions. It means that reading the code from top to bottom
does not necessarily end with its understanding.

You can encounter another popular pattern for asynchronous processing called [*Promise*](https://developer.mozilla.org/cs/docs/Web/JavaScript/Reference/Global_Objects/Promise).
Implementation of this interface is used to handle asynchronous processes and readability of such code is better.
Here is an example.

`index.html` file of AJAX calculator using a *Promise*:

{: .solution}
{% highlight html %}
{% include /en/apv/articles/javascript/ajax/index-promises.html %}
{% endhighlight %}

Promises can be chained or they can be stored in an array and treated as one job by usage of method
[`.all()`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise/all).

{: .note}
Promises can be used to separate different levels of application's logic -- in my example, you can see that low level
HTTP communication is separated from result display. Moreover, you can reuse low level function anywhere and build
whatever logic over it. The code is more readable and the Promise interface is unified and well-known.

{: .note.note-cont}
Internet Explorer does not support promises and you have to use some kind of [polyfill](https://en.wikipedia.org/wiki/Polyfill).

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
Remember that JavaScript is executed inside a browser. Therefore it cannot store any data on a server --
you always need some kind of backend which can communicate securely with your database.
It is possible to write JavaScript backend scripts with [Node.js](https://nodejs.org/) but it
really does not matter. Ratio of JavaScript executed inside visitor's browser and backend code
can vary from 99% to 0%. But without **some** backend code, you cannot create any useful web application.
The main effect of this effort is to deliver to your users more dynamic page with better usability.

As you probably noticed, browser's APIs are quiet bulky and not very convenient. Therefore there are
JavaScript libraries like [jQuery](/en/apv/articles/javascript/jquery/) with more effective expression.

Now you know that most visual effect or desktop-application-like behaviour of a website is caused
by JavaScript. Another thing to remember is that JavaScript has vast ecosystem of libraries and frameworks
and I am not going to get much deeper into this topic in this book.

### New Concepts and Terms
- JavaScript
- Document Object Model
- Browser Object Model
- Events
- Objects
- AJAX
- Promise