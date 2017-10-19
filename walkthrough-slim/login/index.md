---
title: User authentication - login
permalink: /walkthrough-slim/login/
---

* TOC
{:toc}

{% include /common/login.md %}

### Task -- create a form for user registration
It should have an input for login or email and two inputs for password verification (all inputs are required).
You can use [Bootstrap](/walkthrough/css/bootstrap) CSS styles. Prepare a place to display error message and
remember to prepare `form` data array to display values in case of failure.

File `templates/register.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/login/register.latte %}
{% endhighlight %}

Add a GET route to display this template.

File `src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/register-1.php %}
{% endhighlight %}

### Task -- process registration with PHP script
Make a new POST route to process registration of new users. Use [password_hash()](http://php.net/manual/en/function.password-hash.php)
function. Read the documentation because this function requires actually two input parameters. Second one is the
algorithm which is used for password hash calculation.

File `src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/register-2.php %}
{% endhighlight %}

After successful registration, a record representing user account in the database should look like this:

![User account in database](../../common/login/account-in-db.png)

## User verification and login
User verification is also not a big problem -- a person who wishes to log-in into your application has to visit
login page with a simple two-input form. After he fills and submits the form, he is verified against the database.
If an existing account is found and passwords match, your application can trust this user.

{: .note}
Actually there were cases when a user logged into another user's account by a mistake -- two different accounts had
same passwords (not even salt can solve this situation). There are also online identity thefts when user's password
is compromised and used by someone else to harm original person. You can add another tier of user authentication,
e.g. send an SMS to his cell phone to retype a verification code or distribute user [certificates](TODO).

### Task -- create a form for user login and Slim routes to handle it
Create a login form and a Slim routes to process login information. You can make error message a bit confusing to
obfuscate existence of user accounts (sometimes you do not wish to easily reveal users of your app -- especially when
you use email address as login). For now, do not bother yourself by the fact that the confirmation is displayed only
when the user sends his credentials. We will handle persistence of authentication flag later.

File `templates/login.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/login/login-1.latte %}
{% endhighlight %}

File `src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/login-1.php %}
{% endhighlight %}

Now we need to verify user information against the database and display errors when there are some. We will use
the [password_hash()](http://php.net/manual/en/function.password-hash.php) counterpart function [password_verify()](http://php.net/manual/en/function.password-verify.php)
similarly as in registration route:

File `src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/login-2.php %}
{% endhighlight %}

Add a message slot to display errors in the template.

File `templates/login.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/login/login-2.latte %}
{% endhighlight %}

## Persisting data between HTTP requests - $_SESSION
You probably noticed that there is no way to tell if a user has authenticated in subsequent HTTP requests due to stateless
nature of [HTTP protocol](/articles/web/#http-protocol). To safely store login information you would probably
want to logically connect subsequent HTTP request from one client (internet browser) and associate these requests with
some kind of server storage. That is exactly what [*sessions*](/articles/cookies-sessions#sessions) are used for. A session
is a server-side storage which is individual for each client. Client holds only unique key to this storage on its side
(stored in [cookies](/articles/cookies-sessions#cookies)). Client is responsible for sending this key with every HTTP
request. If the client "forgets" the key, data stored in session is lost. The key is actually called *session ID*.

To initiate work with session storage you have to call PHP function [`session_start()`](http://php.net/manual/en/function.session-start.php)
in the beginning of each of your script (before you send any output, because `session_start()` sends a cookie via
HTTP headers).

In PHP, there is as superglobal `$_SESSION` array which is used to hold various data between HTTP request. These
data are stored on a server and cannot be modified by will of a visitor -- it has to be done by your application's
code. The `$_SESSION` variable is initialized and eventually filled by `session_start()` function.

### Task -- store information about authenticated user
Use `$_SESSION` variable to store authenticated user's data after login. Note that there is already a line with
`session_start();` function in the `public/index.php` script.

File `src/routes.php` (final version):

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/login-3.php %}
{% endhighlight %}

## Preventing unauthenticated users from performing actions
You can prevent anonymous users to access all your application's functions or just selected ones. If a visitor
tries to access prohibited function without authentication, he should be redirected to the login page.

### Task -- protect your application
Write a [middleware](https://www.slimframework.com/docs/concepts/middleware.html) function which will verify
presence of user's data in `$_SESSION` array and redirect to login route if no such data is found. The 
is automatically executed before (or after) a route. You can choose to have a global (application) middleware
for all routes or a middleware for a group of routes or a middleware for a particular route. We do not want
to block all routes and therefore we will create a middleware only for a certain [group of routes](https://www.slimframework.com/docs/objects/router.html#route-groups).

The middleware handler is provided with three input parameters, two of them are already familiar, it is the
`$request` and `$response` objects. The third one is the `$next` callback which represents the next action (a route
that should be called according to URL or another layer of middleware). The middleware can decide whether to call
the `$next` callback or return `$response` like you do in ordinary route. You have to pass the `$request` and
`$response` objects to the `$next` callback. The middleware can also be executed *after* the route itself -- all
you have to do is call `$next` handler beforehand and then modify returned value which is a modified `$response`.

Here is an example how to protect a new route with user profile information using such middleware:

File `src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/auth-route.php %}
{% endhighlight %}

File `templates/profile.latte`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/profile-1.latte %}
{% endhighlight %}

Another option is to store the middleware handler into a variable and add it to selected routes manually:

{% highlight php %}
$authMiddleware = function($request, $response, $next) { ...; $next($request, $response); };

$app->get('/route1', function(...) {...})->add($authMiddleware);
$app->get('/route2', function(...) {...})->add($authMiddleware);
{% endhighlight %}

{: .note}
Now you can see why is it important to give names to your routes. You can transfer all routes into this "auth"
group. Result of this operation is that all these routes' URLs now start with `/auth` string. Because you used named
routes and `{link ...}` macro, you do not have to change URLs in templates at all. 

## Logout
Finally, we have to give our users an option to leave our application. A logout action is usually just deletion of
all user related data from `$_SESSION` variable on server.

{: .note}
Sometimes you wish to leave some data in the `$_SESSION` variable -- the contents of shopping cart, for example.

### Task -- Create a logout route
Make a POST route which will handle logout. It is safer to use POST method because GET logout route can be easily
exploited via [XSS](/articles/security/xss) and [CSRF](TODO). Use [`session_destroy()`](http://php.net/manual/en/function.session-destroy.php)
function. Redirect user to a public route of your application after logout.

File `src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/logout.php %}
{% endhighlight %}

Here is an example of logout form with a single button:

File `templates/profile.latte`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/login/profile-2.latte %}
{% endhighlight %}

Make a link to logout route from main menu. You can display user's login name inside the link. You can also pass
user information into the template inside the middleware. Remember to hide the logout button when there is actually
no user signed in.

{% include /common/login-conclusion.md %}