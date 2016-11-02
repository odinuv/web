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
improve his experience a lot. Just by hiding or showing some HTML elements or chaning some CSS
styles you can substantially improve (or reduce) readability of our page and increase speed
of browsing (visitors do not have to wait for server to process their requests).

A lot of pages use JavaScript very heavily nowadays. Sites like YouTube, Google drive/docs, Facebook
are built using this technology. When you transfer significant part of program logic into JavaScript,
you can deliver desktop-app experience for your users.

I will not teach you how to build application entirely with JavaScript, I will show you how to use
this language to overcome most common problems with user interface -- quickly confirm some action or
validate a form before it is send to backend.

JavaScript itself is more than a language -- it is a package of browser interface functions, HTML manipulation
functions and a language itself is called ECMAScript. It has versions such as HTML or CSS and it evolves.
Current version is 6 (published in 2015).

## JavaScript basics
JavaScript is often misunderstood language, it has syntax similar to Java, PHP or C++; its name refers
to Java but it is much different. JavaScript is object oriented like Java, but definition of a class
is not familiar at all. It has first-class functions (a function which can be stored in a variable) and
it is dynamically typed (variable type is defined by content like in PHP). Source code written in JavaScript
is much different to anything you probably know. I will start with some basic examples which I believe
would not confuse you at all; `console.log()` sends its output to browser's developer tools (F12).

Here is a brief JavaScript demo:

{% highlight javascript %}
{% include /en/apv/walkthrough/javascript/basics1.js %}
{% endhighlight %}

{: .note}
To try JavaScript code you do not have to write a custom HTML page, just paste this code into online
tool such as [JSFiddle](https://jsfiddle.net) (use JavaScript editor) and click run. Remember to open
that developer tools console.

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

### Order and time of execution
As you add `<script>` tags to you HTML, you might wonder when is JS code executed.
Basically the order is given by occurence of `<script>` tags. Big difference is between
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
Events are type of signals which are broadcasted to JavaScript event listeners (usually functions)
when some action takes place. For example a user can click a button or a timer ticks:

{% highlight html %}
    <button onclick="clickButtonHandler(event)">Click me!</button>
{% endhighlight %}

{% highlight html %}
    <script type="text/javascript">
        function clickButtonHandler(event) {
            console.log('Button clicked', event);
        }
    </script>
{% endhighlight %}

Open developer console (F12) and try to click this button:

<button onclick="clickButtonHandler(event)">Click me!</button>
<script type="text/javascript">
    function clickButtonHandler(event) {
        console.log('Button clicked', event);
    }
</script>

That weird stuff which is logged along with 'Button clicked' text is an event object describing
what happened. Special event is `onload` which signals that whole page is loaded.

You can attach events as HTML attributes like in example above or you can use programmatic approach
whis is much cleaner because it won't complicate your HTML code:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/events.html %}
{% endhighlight %}

## Using JavaScript to confirm user actions
In chapter about [delete](/en/apv/walkthrough/backend-delete) you were referred to this tutorial
for information about how to confirm user action. Here is an example how to prevent navigation
with a confirm popup for basic `<a>` tags and for `<form>` tags:

{% highlight html %}
{% include /en/apv/walkthrough/javascript/prevent-nav-a.html %}    
{% endhighlight %}

{% highlight html %}
{% include /en/apv/walkthrough/javascript/prevent-nav-form.html %}
{% endhighlight %}

### Task -- add confirm dialog to your delete form

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/javascript/confirm-delete.latte %}
{% endhighlight %}

## Form validation
TODO

## Famous jQuery and other libraries
If you are digging enough around web applications, you definitely heard or read about
[jQuery](https://jquery.com). It is a library which main purpose is to help coders to achieve
desired behaviour faster. In past it also helped to overcome differences in browser's APIs.
It offers many function for manipulation with HTML, events handling and communication with backend.
It is worth trying but I think that it is not a very good idea to learn jQuery for beginners
because you will have trouble working with pure ([vanilla](http://vanilla-js.com/) -- this page
tries to explain that a JS library like jQuery is not always needed) JavaScript.
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

Now you know that most visual effect or desktop-application-like behaviour of a website is cause
by JavaScript.

### New Concepts and Terms
- JavaScript
- jQuery
