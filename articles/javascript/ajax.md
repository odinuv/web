---
title: AJAX
permalink: /articles/javascript/ajax/
---

* TOC
{:toc}

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
to `calculate.php` file (you can use XHR filter) and then select Parameters tab and Response tab. I used Firefox
browser but Chrome developers tools are very similar.

{: .image-popup}
![console.log() output](/articles/javascript/ajax-network-1.png)

{: .image-popup}
![console.log() output](/articles/javascript/ajax-network-2.png)

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

## Cross origin requests and OPTIONS HTTP request
You are probably very excited about reading any possible HTTP resource in your JavaScript page and displaying useful
information on you site (such sites are called [mashups](https://en.wikipedia.org/wiki/Mashup_(web_application_hybrid))).
It is not that simple. The HTTP request that is issued from website downloaded from http://mysite.com to
http://notmysite.org is called *cross origin request* and web browsers have special policy to handle them.
To protect web servers with popular information from stealing it or [DoS/DDoS](https://en.wikipedia.org/wiki/Denial-of-service_attack)
attacks, the browser first asks the server with [HTTP](/articles/http/) *OPTIONS* request (like GET but different
method) before issuing real AJAX request. If the *OPTIONS* request is turned down by the http://notmyhost.org,
the AJAX request fails.

{: .image-popup}
![AJAX and CORS](/articles/javascript/ajax-cors.png)

{: .note}
This applies mostly for AJAX requests made by JavaScript (when you use `XMLHttpRequest` or *fetch API*). You can freely
download images `<img src="http://notmysite.org/..." alt="whatever">`, CSS `<link rel="stylesheet" href="http://notmysite.org/...">`
(including fonts), JavaScripts `<script type="text/javascript" src="http://notmysite.org/...">` etc. defined in source
code of your HTML.

To overcome this, you have to build backend *proxy* -- a simple script that performs the HTTP request on behalf of your
frontend application (your JavaScript frontend then communicates with the proxy script). The consequence is that you use
single IP address of the server, where the proxy script is uploaded, and the owner of target machine can block you
easily (if he does not like you to download information from his site). 

{: .image-popup}
![AJAX and CORS](/articles/javascript/ajax-proxy.png)

You do not have to worry about cross origin requests if you downloaded the web site from the same server where
you send AJAX requests.

{: .note}
You sometimes encounter *CORS* abbreviation in this context. It means [Cross origin resource sharing](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing).

### Configuring server to allow cross origin requests
Cross origin requests are not allowed by default, to allow them, send these HTTP headers with the response to the
*OPTIONS* request (or all HTTP requests). The `Access-Control-Allow-Origin` should contain hostname of the server,
where the browser obtained the HTML a JS code which will communicate with your backend or `*` to allow everything.

~~~
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: PUT, GET, POST, DELETE, PATCH, OPTIONS
~~~

There are more headers that start with `Access-Control-Allow-...`, they define allowed additional headers for example.
In Slim framework, use [this code](https://www.slimframework.com/docs/v3/cookbook/enable-cors.html) as middleware
of your application (usually defined in `src/middleware.php`):

~~~ php?start_inline=1
$app->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
    ->withHeader('Access-Control-Allow-Origin',
                 'http://mysite.com')    //or * to allow everything
    ->withHeader('Access-Control-Allow-Headers',
                 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods',
                 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
~~~

Some installations of Apache web server also need to be configured to allow alternative HTTP methods. This configuration
is for Apache 2.2.x and should be present in your .htaccess file:

~~~
<Limit GET POST PUT DELETE PATCH OPTIONS>
  Allow from all
</Limit>
~~~

{: .note}
You obviously have to be the owner of the server to allow cross origin request. Sometimes you just have to use the
proxy script to obtain data and hope to not get banned (use server cache to minimise amount of requests).

## Summary
AJAX is powerful technique which allows you to fetch or send data in the background. By doing this you can achieve much
smoother user experience. On the other hand, you have to learn JavaScript to use AJAX and you are definitely breaking
your application into more heterogenous modules by moving part of the functionality into JavaScript frontend.

Most modern applications resigned on backend templates and moved to full-featured standalone JavaScript frontend
applications -- this is called [SPA](/articles/web-applications/#single-page-applications-ria-spa). 

### New Concepts and Terms
- Cross origin requests
- AJAX
