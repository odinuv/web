---
title: Debugging AJAX, REST API and Single page applications
permalink: /articles/debugging/ajax-rest-api-and-spa/
---

* TOC
{:toc}

This article describes the debugging of [AJAX](/articles/javascript/#ajax) applications. These techniques also apply
for debugging of SPAs with REST API. Before you start writing and debugging AJAX applications, be sure to have
a good understanding of [HTTP protocol](/articles/http/).

The problem with AJAX request is that you cannot see it. You have a JavaScript functionality which triggers it and
you have some backend code which generates the response. But there is no change in the current URL displayed in
address bar and there is also no reload of the page. Therefore you cannot see the response with reported error.

Another problem is, that AJAX request often transmits information in specific data format like [XML](https://cs.wikipedia.org/wiki/Extensible_Markup_Language)
or [JSON](https://www.json.org/) that has to be parsed by client-side JavaScript (e.g. [JSON.parse](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON/parse)).
When the backend generates some error reporting and prints this reporting into the response, the response parser gets
confused and the error spreads into the JavaScript frontend.

Your JavaScript frontend and backend is communicating via HTTP protocol. If you encounter a problem with AJAX request,
your first steps should lead to the network tab of the developer tools console (usually F12 key) to inspect whether
the message was successfully dispatched and whether the response is OK.

There are several crucial things to check:

- Was the request dispatched?
  - If no, the problem is in the JavaScript responsible for the request creation.
- Was all parameters of the request passed correctly (*GET* and *POST* data)?
  - If no, the problem is again with the JavaScript.
- Was the response delivered correctly (is status code 2xx and the response contains expected body)?
  - If yes, the problem is in the JavaScript that handles the response.
  - If no, the problem is in the backend.

## Check the request and the response
Suppose that you have an AJAX route in your application which is used to find people with matching name or surname.
This route returns JSON data used to generate user interface text completion tool with JavaScript. Every time when
a user changes the content of the text input, the backend is asked to generate list of possible matches. These are
delivered by JavaScript in the background and used to generate `<option>` tags for `<datalist>` element.

Following image shows that several HTTP requests were fired by JavaScript as I typed the text `oshiro` into the
text field. I also set the filter to *XHR* only (red oval) -- *XHR* is abbreviation of [*XMLHttpRequest*](/articles/javascript/ajax/).

{: .image-popup}
![AJAX requests](/articles/debugging/ajax-requests.png)

Here are the routes for such application:

~~~ php?start_inline=1
//handle AJAX request and respond with JSON
$app->get('/api/person', function(Request $request, Response $response, $args) {
    try {
        $name = $request->getQueryParam('name');
        $stmt = $this->db->prepare('SELECT *
                                    FROM person
                                    WHERE first_name ILIKE :n OR last_name ILIKE :n
                                    ORDER BY last_name');
        $stmt->bindValue(':n', $name . '%');
        $stmt->execute();
        $persons = $stmt->fetchAll();
        return $response->withJson($persons);
    } catch(Exception $e) {
        $this->logger->error($e->getMessage());
        return $response->withStatus(500);
    }
})->setName('api:person');

//render the template
$app->get('/ajax/demo', function(Request $request, Response $response, $args) {
    return $this->view->render($response, 'ajax-demo.latte');
});
~~~

Template `ajax-demo.latte`:

~~~ html
{extends layout.latte}

{block title}AJAX demo{/block}

{block body}
<!-- input with datalist used to generate possible values -->
<input id="search" list="people">
<datalist id="people"></datalist>

<script type="text/javascript">
//wait for browser to load everything
window.onload = function() {
  var inp = document.getElementById('search');
  var list = document.getElementById('people');
  //wait for key event
  inp.onkeyup = function() {
    var s = inp.value;
    //if we have some text in the input's value
    if(s.length > 2) {
      //clear the datalist
      list.innerHTML = '';
      //initiate request to fetch people from backend
      var req = new Request("{link api:person}?name=" + encodeURIComponent(s));
      fetch(req).then(function(response) {
        //convert response body to JSON
        response.json().then(function(data) {
          //iterate over returned persons and add datalist options
          for(var p of data) {
            var opt = document.createElement('option');
            opt.value = p.first_name + ' ' + p.last_name + ' (' + p.nickname + ')';
            list.appendChild(opt);
          }
        }, function() {
          alert('Response is not JSON.');
        });
      }, function() {
        alert('Error occurred.');
      });
    }
  };
};
</script>
{/block}
~~~

In such application, the problem can be in the JavaScript code that gets executed on the frontend once the user
types some letters -- everything in the function defined as handler for `inp.onkeyup` util the `fetch()` function
is called. After the request is send to the backend, the PHP code gets executed and creates the response containing
JSON structure with records from database. Finally, when the backend sends the response to the frontend, the JavaScript
code continues to execute one of the [*Promise*](/articles/javascript/#promises) handlers of the `fetch()` function.
That is the last place where an error can occur. The order of execution is represented in following image.

{: .image-popup}
![AJAX comm](/articles/debugging/ajax-comm.png)

{: .note}
HTTP status code determines whether to execute [Promise's](/articles/javascript/#promises) fulfilled/positive
(for 2xx codes) or rejection/negative (4xx or 5xx codes) callback.

Use same technique to check request parameters with developer tools as described in the [backend debugging article](/articles/debugging/backend/#http-protocol-debugging).
Additionally, use the *Preview* and *Response* tabs to check the contents of HTTP response. The *Preview* tab displays
the JSON data as foldable tree structure (this is caused by correct `Content-Type` header). The *Response* tab
displays just plain text representation of the response.

{: .image-popup}
![AJAX request details](/articles/debugging/ajax-request-details.png)

Following image displays the error generated by the PHP on the backend caused by wrong variable name in the code.
In non-AJAX scenario, this error would normally be displayed in the browser. Because the request was dispatched by
JavaScript, the error remains hidden in the developer tools.

{: .image-popup}
![AJAX request error](/articles/debugging/ajax-request-error.png)

{: .note}
In this case, you can simply copy the URL generated by JavaScript and paste it into the address bar to check backend
functionality separately. But this only applies to *GET* requests.

Once you found the error, use [backend](/articles/debugging/backend/) or [frontend](/articles/debugging/frontend/)
debugging techniques.

## Simulate the request
Sometimes it is tedious to replicate the AJAX call from the frontend application. It might be even impossible, because
the frontend application does not have to be ready or complete at all. There are tools that can be used to build
the request comfortably. I recommend using [Rester addon](https://addons.mozilla.org/en-US/firefox/addon/rester/) for
Firefox browser. You can specify the HTTP method, URL, custom headers and also *POST* or *PUT* payload and repeat
the request as many times as you need to tune the backend functionality. There are many similar addons for various
web browsers.

{: .image-popup}
![Rester](/articles/debugging/rester.png)

## Summary
This article is an overview of AJAX debugging techniques. Remember that sending the HTTP request with JavaScript,
processing it on the backend, receiving the response and doing something with it is too complex to debugged at once.
You have to find the source of error first (frontend request dispatch, backend request processing or frontend response
processing). To do this, developer tools or a tools like Rester addon are needed.

### New Concepts and Terms
- debugging AJAX