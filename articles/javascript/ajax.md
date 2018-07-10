---
title: AJAX
permalink: /articles/javascript/ajax/
---

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
{% include /articles/javascript/ajax/calculate.php %}
{% endhighlight %}

And we need a JavaScript to talk with backend and deliver results into HTML page. The JavaScript code simply opens
HTTP connection using GET method to `calculate.php` script with correct query parameters and waits for its response.
If everything goes smooth, PHP returns HTTP code 200 and JSON data that can be parsed by JavaScript's
[JSON](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON) library.

`index.html` file:

{: .solution}
{% highlight html %}
{% include /articles/javascript/ajax/index.html %}
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

### Fetch API
[Fetch API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API) is a modern wrapper for asynchronous HTTP
requests. It has higher-level syntax than previously described XMLHttpRequest and is promise-based. You can read about
*promises* in [JavaScript article](/articles/javascript/#promises).

Check out this article for a simple [Fetch API example](/articles/debugging/ajax-rest-api-and-spa/) and also for AJAX
debugging tips.

## Summary
AJAX is powerful technique which allows you to fetch or send data in the background. By doing this you can achieve much
smoother user experience. On the other hand, you have to learn JavaScript to use AJAX and you are definitely breaking
your application into more heterogenous modules by moving part of the functionality into JavaScript frontend.

Most modern applications resigned on backend templates and moved to full-featured standalone JavaScript frontend
applications -- this is called [SPA](/articles/web-applications/#single-page-applications-ria-spa). 

### New Concepts and Terms
- AJAX
