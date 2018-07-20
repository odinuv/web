---
title: REST API
permalink: /articles/web-applications/rest-api/
---

* TOC
{:toc}

There is a special type of web applications that do not have user oriented interface. Their purpose is to provide some
functionality and to serve needs of another application. Such application can be called a *service*. Because another
applications communicate with your service, you have to establish a well documented and easy to use communication
protocol and choose data format. In another terms: client application controls/uses the service to **store, retrieve
or modify data** or to perform some other actions. To be able to do this, the service has to expose an
[*application programming interface (API)*](https://en.wikipedia.org/wiki/Application_programming_interface).

[HTTP](/articles/http/) is a communication protocol between web browser and web server. Most common usage is transfer
of HTML (and other) files from server to the web browser (data format is HTML, CSS, binary data etc.). The browser then
renders a website based on HTML code and CSS. When you need to send some data to the server, you usually use `<form>`
element and POST method to [send form data](/articles/http/#value-passing-in-http-requests) -- another data format.
HTML, CSS or *form-url-encoding* is not a good format to transfer raw data, because it is bulky and the HTML parser
is very difficult to implement and it is not simple, because format of the data is different for each usage.

Let's see an example of an API: suppose that you are building an e-commerce application -- you want to sell tickets for
shows in your local movie theater. You have scheduled movie screenings and you have reservations of seats in your
application, but you are missing a credit card billing functionality (to get real money from people online) -- for now,
your customers have to pay at the office before the movie starts. For real processing of credit cards, you need to
use a third party service (you can subscribe to use credit card processing system in your bank or from specialized
company). Your application has to communicate somehow with the credit card processing system (it has to tell the system
how much money you want from given customer and the system has to tell you whether the credit card transaction was
successful or not). You have been given a documentation of credit card processing system communication interface (API)
and you used it to implement the billing functionality in your application.

{: .image-popup}
![Billing API](/articles/web-applications/using-api.png)

In this example, you were not in the role of creator of the API. You were just a *consumer* and you **needed documentation**
to work with provided API. You can find yourself in many roles as a developer in relation with an API:

- you can be the *consumer* of someone else's API (you need to use some service in your application)
- you can be the provider of tha API for your clients (you have a service and others want to use it)
- you can be the provider and *consumer* at once because you are building a distributed application (separate backend
  and multiple frontends -- web, mobile etc.)

[HTTP](/articles/http/) is quiet simple protocol, it has request/response **headers**, request/response **body** and
response **status codes** and it is **supported in the browser**. The problem is with data format and that there is no
set of rules to map [CRUD](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete) operations on HTTP paths.
Therefore the [*Representational state transfer (REST)*](https://en.wikipedia.org/wiki/Representational_state_transfer)
was designed. REST is not a standard, it is a set of recommendations and constraints of how to use HTTP protocol to
build an API.

Once you have server API built over HTTP protocol, you can call it from frontend [SPA](/articles/web-applications/#single-page-applications-ria-spa)
(or just with ordinary JavaScript [AJAX](/articles/javascript/ajax/) call), native mobile application, from another
server application through its backend or even from standard desktop application. Issuing HTTP call is easy and there
are libraries for most programming languages to handle HTTP (or HTTPS) communication.

Modern [single page applications (SPA)](/articles/web-applications/#single-page-applications-ria-spa) are built as
separate [JavaScript](/articles/javascript/) applications and they definitely need to communicate with server backend
to **store, retrieve or modify data**. Because they are built with JavaScript, they can use [*JSON*](http://json.org/)
format to transfer data over HTTP protocol very easily. Another format for REST API is [*XML*](https://en.wikipedia.org/wiki/XML).

Idea of REST API is to offer semi-standardised way of CRUD operations mapping on HTTP protocol. If you already read
[AJAX](/articles/javascript/ajax/) article, you know, that the possibilities of communication with HTTP backend are
much richer than sending JSON or XML back and forth, but that is the point of REST. You can also find libraries for
JSON or XML parsing for most programming languages.

{: .note}
JSON is JavaScript's native syntax of object/array representation (with some constraints -- basically, objects can only
contain attributes, not methods). You can simply serialize (convert object to string) and deserialize (convert string
to object) JSON data with [`JSON.stringify()`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON/stringify)
and [`JSON.parse()`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON/parse)
methods. In PHP use [`json_encode()`](http://php.net/manual/en/function.json-encode.php) and
[`json_decode()`](http://php.net/manual/en/function.json-decode.php) to convert JSON data to associative array.

It is very convenient to have same API for SPA, mobile application and for any other *consumer* of your API:
it is cheaper and you have only one place where server functionality is defined. On the other hand, you are
making the frontend application equivalent to mobile application by promoting it to standalone application
and that makes it more difficult to develop and maintain and is more expensive.

## REST API
The REST API exploits the HTTP protocol to map CRUD operations on HTTP methods. HTTP path is used as resource identifier
(it maps SQL operations on a table/record on HTTP protocol, e.g.: path `/user` is stored in the table *users*).

| CRUD   | HTTP   | Meaning                                                  | Note                                                                                            |
|--------|--------|----------------------------------------------------------|-------------------------------------------------------------------------------------------------|
| CREATE | POST   | Create new record.                                       | Pass data in body. Should return location of newly created resource (e.g. in `Location` header) |
| READ   | GET    | Get listing of items or concrete item.                   | Request should not have body.                                                                   |
| UPDATE | PUT    | Update whole record.                                     | Pass data in body.                                                                              |
| DELETE | DELETE | Delete whole record.                                     | Request should not have body.                                                                   |
| --     | PATCH  | Partially update record or trigger state chaning action. | Pass data in body.                                                                              |

Example of *endpoints* -- the HTTP paths:

- *POST* `/user` + data -- create new record in a table
- *GET* `/user` -- retrieve list of all users
- *GET* `/user?first_name=John` -- retrieve list of all users by given filtration criteria
- *GET* `/user/123` -- retrieve information about concrete user
- *PUT* `/user/123` + data -- update all user information
- *DELETE* `/user/123` -- delete user account
- *PATCH* `/user/123` + data -- update only some user information (e.g. update only email without changing anything else)

The response [HTTP status code](/articles/http/#response-status-codes) is used to determine the success/failure of the
result. Using REST API from another domain than your own is constrained by [CORS policy](/articles/javascript/ajax/#cross-origin-requests-and-options-http-request). 

### Statelessness
The nature of HTTP protocol is stateless -- everything that the server needs to process the requests must be passed
in the request. REST API should also be stateless, therefore the response of the server should not be determined by
internal state of the application and same request should generate same response when send repeatedly. This might be
a problem sometimes because application's logic is often stateful.

Try to think about the REST API as of distributed service, where each *endpoint* could be handled by entirely different
machine. It is OK to store the state in some central database, but you should not depend on server session because
session state is not shared between machines.

{: .note}
Statelessness is required for scaling of your service horizontally (by adding more machines). This applies only for
applications with high load and many clients, if you are not planning to have high-traffic application, you may
drop this constraint.

## Designing REST API
The process of design depends on the application and its functionality. The easiest way is to start mapping
database entities to individual endpoints. **Be consistent in naming conventions.** Use either singular or plural
form of nouns for naming of the endpoints, but choose one form for whole API.

I propose to start with a table where you describe behaviour for different HTTP methods for each endpoint. You should
be able to map all actions (use-cases) of the application to HTTP calls (it is a good idea to start with wireframe of
the application first):

|              | GET             | POST            | PUT             | DELETE      |
|--------------|-----------------|-----------------|-----------------|-------------|
| `/user`      | List of users   | Create new user | N/A             | N/A         |
| `/user/{id}` | Details of user | N/A             | Update the user | Delete user |
| ...          | ...             | ...             | ...             | ...         |

There are problems that are difficult to solve -- usually linked with the semantics of the request. Like deleting
records that does not have explicit ID or how to map actions that are not CRUD on endpoints. This is due the nature
of REST API which is designed to map CRUD operations. Some problems can be bypassed by "thinking bit differently", e.g.
when you want to initiate payment for goods, you are actually creating new payment entity (so you should use *POST*
method). Sometimes you just need to bend the REST recommendations to suit your needs.

A typical problem is search with difficult filtering criteria. It is more convenient to pass complicated search
parameters as JSON structure in request's body, but *GET* method discourages sending of body data (although it is not
impossible). On the other hand, search does not create any entity and therefore it should not use *POST* method.
You can justify usage of *POST* method by thinking of search action as of creation of new "result set".

Another way is to treat actions as sub-resources (e.g. *PUT* `/user/123/deactivate` to deactivate user account -- use
put because you are updating the state) or use *PATCH* method with base resource URL (e.g. *PATCH* `/user/123` +
`{"active": false}`).

### Passing parameters
REST API can use URL placeholders to pass parameters (see the `{id}` placeholder in previous table). Query parameters
are usually used for filtering or pagination.

### Dealing with 1:N or M:N relationships
You can easily nest related entities. If your users can reserve seats in your movie theater, you can create endpoint
`/user/123/reservation` to list all existing reservations for particular user. To get details of actual reservation,
use endpoint `/user/123/reservation/456` etc.

The dilemma is where to stop the nesting, is it better to nest or to use query parameters for filtering?

- `/user/123/reservation`
- `/reservation?user_id=123`

### Same object representation for all instances
It is a good practice to return same attributes in JSON structures for listings (`/user`) and details requests
(`/user/123`). It is easier to work with same entities regardless of their origin in frontend application.

### Use envelope
Another good idea is to use "envelope" in JSON structures to pass *meta-data*. Put the actual data into an attribute
called e.g. `payload` and you can always extend the response with additional useful information.

~~~ json
{
    "payload": [
        {
            "id": 123,
            "name": "John"
        },
        {
            "id": 124,
            "name": "Jane"
        }
    ],
    "statistics": {
        "averageHeight": 175.15
    },
    "pagination": {
        "start": 0,
        "pages": 15,
        "pageSize": 20,
        "items": 283
    }
}
~~~

{: .note}
JSON envelope is especially useful for listings. Envelope data can also contain [links for related resources](https://en.wikipedia.org/wiki/HATEOAS).

### Authentication of users
Use HTTP header `Authorization` to pass a unique token (just a random, but unique set of letters -- the principle is
similar to [session ID](/articles/cookies-sessions/#sessions)). You can generate your own tokens or use some
implementation of [JWT](https://jwt.io/). The advantage of JWT tokens is that you can actually pass data in them
and you do not have to look up the tokens in your server's storage. Remember to use signed JWT tokens, otherwise
anybody can change the data and tokens cannot be trusted.

{: .note}
You can even use standard PHP's session, but it is against the stateless nature of REST API.

Login is a good example of CRUD mapping problem: login performs some action, it does not modify the database. So how
should the REST endpoint be named and which method should be used? Tokens can help us here -- logging in means that
you create a new token. Instead of using `/user/login` endpoint, which is not a resource (word *login* is verb here),
you can define e.g. `/jwt` endpoint and use *POST* method to create new JWT token. To retrieve new JWT token use
*PUT* method on the same endpoint (JWT tokens are generated for given amount of time and then they expire).

### Versioning of API
Serious APIs have usually version prefix in each endpoint: `/v1/user`. This is useful in situations, when you know
that you will have multiple versions of client applications running concurrently (this can happen with mobile
applications that are updated irregularly). It is easier and clearer for developers to create new version of endpoint
than determining the version of the client during the request.

## Documenting REST API
An API needs a communication protocol so both applications understand each other. The documentation of this protocol
is crucial. There are tools which can be used to document REST API. Documentation of API is a document written is some
structured syntax. [Blueprint](https://apiblueprint.org/) based on [Markdown](https://en.wikipedia.org/wiki/Markdown)
and [Swagger](https://swagger.io/) based on [YAML](https://en.wikipedia.org/wiki/YAML) are the most used ones nowadays.
You can try Blueprint documentation on [Apiary](https://apiary.io/) and Swagger in [their online editor](https://editor.swagger.io/).
The main point is to tell the API developer what should he expect as input and what to return as output and to tell
API users (developers of client applications) what to send to which endpoint and what response to expect.

The documentation contains definition of an endpoint (the path) description of behaviour for applicable HTTP methods and
an example of request and response with described JSON attributes. Open [swagger editor](https://editor.swagger.io/)
and check out the right side with rendered documentation.

The generated documentation is in HTML format (so it can be opened in web browser) and it can usually be used to call
HTTP endpoints of your actual API to test it (instead of using addons like [Rester](https://addons.mozilla.org/en-US/firefox/addon/rester/)).

### REST API mock
Documentation written in Blueprint or Swagger format can be used to generate a *mock*. It is a live version of
documentation (a HTTP server) with active endpoints that react to described HTTP methods and return defined example
data. Mock is useful when you develop the frontend (JavaScript functionality) before or in parallel with real backend.

{: .note}
Apiary service provides API mock out-of-the-box on their servers. For Swagger mock, you have to download a tool. You
can also use API documentation to generate skeleton of your application.

## Summary
The *REST API* is basically a web application without user interface that is used by other applications (like purely
JavaScript clients or other backend applications) to store, retrieve or modify data or to perform some other actions.
It is based on set of constraints and recommendations of how to use HTTP protocol and usually transfers data in JSON
format.

Modern web applications are divided into "frontend" made of SPA (plus mobile application) and "backend" which provides
REST API. You can specialize in either or both, that is up to you, but you should understand the reasons for such
division. If you are going to design or just use REST API, you still need to understand its idea.

REST API has many limitations and you saw that it is difficult to map many actions (other then CRUD) to endpoints.
You have to make exceptions and break REST recommendations from time to time. Just make sure, that you are consistent
through the whole API and that the API is well documented.

### New Concepts and Terms
- REST API