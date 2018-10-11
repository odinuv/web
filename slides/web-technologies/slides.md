---
layout: slides
title: Web Technologies
description: Technologies for building a web application
transition: slide
permalink: /slides/web-technologies/
---

<section markdown='1'>
## Web application
- Web **Application** consists of a series of web **Pages**
- Web **Page** consists of a series of **Resources**

- Resource has:
	- URL x URI (URN) (location vs. identifier)
	- Content (anything including nothing)
	- Content Type (MIME type)
		- text/html, image/png, video/mp4, ~900 more ...
</section>

<section markdown='1'>
## HTTP Protocol
- Stateless text protocol
- It can retrieve a **Resource**
	- Client sends an HTTP **Request**
	- Server responds with an HTTP **Response**
- Single page is composed of multiple resources
	- It is a good idea to minimize the number of resources
</section>

<section markdown='1'>
## HTTP Request + Response
- Example of simple HTTP request and response


        GET / HTTP/1.0
        Host: mendelu.cz
        
`/` represents path from URL and `mendelu.cz` is hostname
</section>

<section markdown='1'>
## HTTP Transaction - Single Transfer
- Request:
	- **URL**, **Method**, Headers, (Body)
- Response:
	- **Status code**, Headers, Body	
- Method
	- **GET**, **POST**, PUT, DELETE, PATCH, ...
</section>

<section markdown='1'>
## Single-page Application
- Application executed on client
- Application code downloaded on first request (single page)
- Data are exchanged using HTTP:
	- API (REST)
	- Resources + Methods
	- JSON (XML) Response and Request format
</section>

<section markdown='1'>
## Web app Implementation
- Goal: Receive Request, Produce Response
- Any programming language can do it.
- But there are some more useful to handle that:
	- Php, Python, Ruby, Javascript, C#, Java ...
- Interpreted languages run *inside* a web server
</section>

<section markdown='1'>
## PHP - Simplistic Approach

	GET /welcome.php?name=John
    Host: domain.tld

welcome.php:	
{% highlight php %}
<?php 
echo "<!DOCTYPE HTML><html>";
echo "<body><h1>Hello" . $_GET['name'] . "</h1></body>";
echo "</html>";
{% endhighlight %}
</section>

<section markdown='1'>
## PHP - Processing the request

	POST /login.php?l=en
    Host: domain.tld

	username=John&password=NotTooSecret&action=login

welcome.php:	
{% highlight php %}
<?php 
echo "<!DOCTYPE HTML><html><body>";
if (($_POST['username'] == 'John') && 
	($_POST['password'] == 'NotTooSecret')) {
  if ($_GET['l'] == 'en') {
    echo "<h1>Hello " . $_POST['username'] . "</h1>";
  } else {
    echo "<h1>Ciao " . $_POST['username'] . "</h1>";
  }
}
echo "</body></html>";
{% endhighlight %}
</section>

<section markdown='1'>
## Simplistic Approach
- advantages:
	- simple
	- quick for really simple stuff
	- fast learning
- disadvantages
	- security
	- chaos
	- bad extensibility
	- no organization (remember engineering)
</section>

<section markdown='1'>
## Example
</section>

<section markdown='1'>
## Templates
- Protect from XSS (Cross-site scripting)
- Separation of concerns
	- Separate HTML generation logic
	- Multiple jobs
- Allow easy sharing of HTML fragments
- Clear definition of application **outputs**
</section>

<section markdown='1'>
## Example
{% highlight php %}
<?php
$tpl = new Latte\Engine();
if (($_POST['username'] == 'John') && 
	($_POST['password'] == 'NotTooSecret')) {
  $tpl->render("welcome.latte", ['username' => $_POST['username'], 'language' => $_GET['l']]);
} else {
  $tpl->render("login.latte", 'language' => $_GET['l']);
}
{% endhighlight %}
</section>

<section markdown='1'>
## Example
{% highlight php %}
<?php
$tpl = new Latte\Engine();
if (($_POST['username'] == 'John') && 
	($_POST['password'] == 'NotTooSecret')) {
  $tplVars = [
    'username' => $_POST['username'], 
    'language' => $_GET['l']
  ];
  $tpl->render("welcome.latte", $tplVars);
} else {
  $tplVars = ['language' => $_GET['l']];
  $tpl->render("login.latte", $tplVars);
}
{% endhighlight %}
</section>

<section markdown='1'>
## Example
`welcome.latte`

{% highlight html %}
<!DOCTYPE html>
<html>
  <head></head>
  <body>
  {if $language == 'en'}
    <h1>Hi {$username}</h1>
  {else}
    <h1>Ciao {$username}</h1>
  {/if}
  </body>
</html>
{% endhighlight %}
</section>

<section markdown='1'>
## Sharing HTML Code
`welcome.latte`

{% highlight html %}
{extends 'layout.latte'}
{block content}
  {if $language == 'en'}
    <h1>Hi {$username}</h1>
  {else}
    <h1>Ciao {$username}</h1>
  {/if}
{/block}	
{% endhighlight %}
</section>

<section markdown='1'>
## Sharing HTML Code
`layout.latte`

{% highlight html %}
<!DOCTYPE html>
<html>
  <head></head>
  <body>
    {include content}
  </body>
</html>
{% endhighlight %}

Real layout is slightly bigger!
</section>

<section markdown='1'>
## Framework
- Enforces separation of concerns (responsibilities)
- Provides a unified wrapper around HTTP
- Promotes unified approach to applications
- Enforces code organization
- Prevents silly security errors
- Easier access to templates
- Unified approach to **routing**
</section>

<section markdown='1'>
## Routing
- Mapping between HTTP requests and application code
- Route takes **URI + Method** and executes as **Handler**

HTTP request:

        GET /welcome?name=John
        Host: domain.tld

Requeste handler:
~~~ php?start_inline=1
$app->get('/welcome', function (Request $request, Response $response) {
  $tplVars = ['username' => $request->getQueryParam('name')];
  return $this->view->render($response, 'welcome.latte', $tplVars);
);
~~~
</section>

<section markdown='1'>
## Processing Request
- Mapping between HTTP requests and application code
- Route takes **URI + Method** and executes as **Handler**

~~~ php?start_inline=1
$app->get('/welcome', function (Request $request, Response $response) {
  $data = $request->getParsedBody();
  if (($data['username'] == 'JohnDoe') && 
      ($data['password'] == 'NotSoSecret')) {
    $tplVars = [
      'username' => $data['username'], 
      'language' => $request->getQueryParam('l'),
    ];
    return $this->view->render($response, 'welcome.latte', $tplVars);
  } else {
    $tplVars = [
      'language' = $request->getQueryParam('l')
    ];
    return $this->view->render($response, 'login.latte', $tplVars);		
  }
);
~~~
</section>

<section markdown='1'>
## Which?
- Which framework?
	- Slim 
		- very simple and slim
		- also usable for SPA
	- Laravel, Symfony, Nette, Yii
- Which Template system?
	- Latte, Smarty, Blade
- Boilerplate code
    - The code that you need to write (or copy) before actually coding your own application.
    - Pays off in long term.	
</section>

<section markdown='1'>
## HTTP Requests
- Parameters:
	- Request URL or Request body?
    	- Body = Data
	    - URL = Options
- Method usage:
	- GET = Read
	- POST = Action (changes something)
</section>

<section markdown='1'>
## Implementation
- PHP and Slim is specific
- Template language is specific
- Concepts are general
	- HTTP (methods, headers + body)
	- Routes (method + URI)
	- Templates (not just in PHP)
</section>

<section markdown='1'>
## Checkpoint
- URL VS URI VS URN?
- Is response body same as "data"?
- Can request made with POST method have body? Is the body mandatory? Can we also pass URL parameters with POST request?
- Does every HTTP response have a body?
- How much boilerplate code are you willing to accept?
- Are all templating engines "the same"?
- Does every framework come with templating engine?
</section>