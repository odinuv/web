---
title: JavaScript
permalink: /en/apv/walkthrough/javascript/
---

* TOC
{:toc}

In this article I want to introduce a *client-side* programming language called JavaScript.
*Client-side* means, that scripts written in this language are executed in a web browser (client).
This is a new thing which opens a lot of possibilities: you know that browser is capable of
rendering pure HTML, displaying images, maybe you know that you can also play video and audio
in newer browsers using appropriate HTML tags (all this is very nice, but still the browser is a bit
stupid). Executing scripts in browser during the time when a visitor is viewing your website can
improve his experience a lot. Just by hiding or showing some HTML elements you can substantially
improve (or reduce) readability of our page and increase speed of browsing (visitors do not have to wait
for server process their requests).

A lot of pages use JavaScript very heavily nowadays. Sites like YouTube, Google drive/docs, Facebook
are built using this technology. When you transfer significant part of program logic into JavaScript,
you can deliver desktop-app experience for your users.

I will not teach you how to build application entirely with JavaScript, I will show you how to use
this language to overcome most common problems with user interface -- quickly confirm some action or
validate a form before it is send to backend.

JavaScript itself is more than a language -- it is a package of browser interface, HTML manipulation
functions and a language itself is called ECMAScript. It has versions such as HTML or CSS and it evolves.
Current version is 6 (published in 2015).

## JavaScript basics
JavaScript is often misunderstood language, it has syntax similar to Java, PHP or C++; its name refers
to Java but it is much different. JavaScript is object oriented like Java, but definition of a class
is not familiar at all. It has first-class functions (a function which can be stored in a variable) and
it is dynamically typed (variable type is defined by content like in PHP). Source code written in JavaScript
is much different to anything you probably know. I will start with some basic examples which I believe
would not confuse yout at all; `console.log()` sends its output to developer tools (F12).

Here is a brief JavaScript demo:

{% highlight javascript %}
    /* basic variables */
    var stringVariable = "Hello world";
    var numberVariable = 1.2345;
    var boolVariable = false;
    console.log(stringVariable, numberVariable, boolVariable);
    
    /* arrays */
    var arrayVariable = [1,2,3,4,'This is an array', false, true, [10,20,30]];
    console.log(arrayVariable);
    
    /* reference to a function */
    var functionVariable = function(param) {
        alert(param);
    }; 
    functionVariable("Call a function");
    
    /* object */
    var objectVariable = {
        key: "value",
        number: 123,
        nestedObject: {
            boolean: false
        },
        method: functionVariable
    };
    console.log(objectVariable);
    
    objectVariable.method("Calling a method of object.");
{% endhighlight %}

{: .note}
To try JavaScript code you do not have to write a custom HTML page, just paste this code into online
tool such as [JSFiddle](https://jsfiddle.net) (use JavaScript editor) and click run.

TODO: vlozit do JSFiddle?

In following example you can see control structures:

{% highlight javascript %}
    var x = 5;
    if(x < 15) {
        console.log("x is smaller than 15");
    } else {
        //...
    }
    
    var arr = ["a", "b", "c", "d", "e", "f"];
    for(var i = 0; i < arr.length; i++) {
        console.log(arr[i]);
    }
{% endhighlight %}

## Linking JavaScript to your HTML
Similarly to CSS, a JavaScript file is usually referred in `<head>` tag using a `<script>` tag.
The `<script>` tag can contain URL to download some script or it can directly contain some
JavaScript code:

{% highlight html %}
<!DOCTYPE html>
<html>
    <head>
        <title>JS example</title>
        <script type="text/javascript" src="link/to/external/file.js"></script>
        <script type="text/javascript">
            console.log("Some JS code right here...");
        </script>
    </head>
    <body>
        <script type="text/javascript">
            console.log("...or even in document's body.");
        </script>
    </body>
</html>
{% endhighlight %}

### Order of execution

- script tags in head or before </body>
- onload event
- events attached to HTML elements

## JavaScript events

{% highlight html %}
    <button onclick="clickButtonHandler(event)"></button>
{% endhighlight %}

{% highlight javascript %}
    function clickButtonHandler(event) {
        console.log('Button clicked', event);
    }
{% endhighlight %}

## Using JavaScript to confirm user actions
prevent navigation or form submission

{% highlight html %}
    <a href="javascript:confirmNav('http://www.server.org/')">Server</a>
    <script type="text/javascript">
        function confirmNav(url) {
            if(confirm('Really navigate to ' + url + '?')) {
                location.href = url;
            }
        }
    </script>
{% endhighlight %}

{% highlight html %}
    <form onsubmit="return confirmForm()">
    <script type="text/javascript">
        function confirmForm(url) {
            return confirm('Really submit form?');
        }
    </script>
{% endhighlight %}

## Form validation

## jQuery and others
If you are digging enough around web applications, you definitely heard or read about
[jQuery](https://jquery.com). It is a library which main purpose is to help coders to achieve
desired behaviour faster. In past it also helped to overcome differences in browsers API.
It offers many function for manipulation with HTML, events handling and communication with backend.
It is worth trying but I think that it is not a very good idea to learn jQuery for beginners
because you will have trouble working with pure ([vanilla](http://vanilla-js.com/) -- this page
tries to explain that a JS library is not always needed) JavaScript.
Plus the importance of jQuery has declined as various browsers improved/united their API
(e.g.: to find elements using CSS selector you can use `document.querySelector()` method
instead of jQuery).

There are also many other JS libraries or frameworks. jQuery is most used and sometimes other
libraries (like [Bootstrap](/en/apv/walkthrough/css/bootstrap/) require you to use it).
Be careful about mixing different libraries -- some of them cannot or should not be used together.

## Summary
Remember that JavaScript is executed inside browser. Therefore it cannot store any data on server --
you always need some kind of backend which can communicate securely with your database.
It possible to write JavaScript backend scripts with [Node.js](https://nodejs.org/) but it
really does not matter. Ratio of JavaScript executed inside visitor's browser and backend code
can vary from 99% to 0%. But without **some** backend, you cannot create a useful web application.
The main effect of this effort is to deliver to your users more dynamic page with better usability.

### New Concepts and Terms
- JavaScript
- jQuery
