---
title: User authentication - login
permalink: /walkthrough/login/
redirect_from: /en/apv/walkthrough/login/
---

* TOC
{:toc}

{% include /common/login.md %}

### Task -- create a form for user registration
It should have an input for login or email and two inputs for password verification (all inputs are required).
You can use [Bootstrap](/walkthrough/css/bootstrap/) CSS styles.

File `templates/register.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough/login/templates/register.latte %}
{% endhighlight %}

### Task -- process registration with PHP script
Use [password_hash()](http://php.net/manual/en/function.password-hash.php) function. Read the documentation
because this function requires actually two input parameters. Second one is the algorithm which is used for
password hash calculation.

File `register.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/login/register.php %}
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
e.g. send an SMS to his cell phone to retype a verification code or distribute user certificates.

### Task -- create a form for user login with PHP script
Create a login form and a PHP script to process login information. You can make error message a bit confusing to
obfuscate existence of user accounts (sometimes you do not wish to easily reveal users of your app -- especially when
you use email address as login). For now, do not bother yourself by the fact that the confirmation is displayed only when
the user sends his credentials. We will handle persistence of authentication flag later.

File `templates/login.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough/login/templates/login.latte %}
{% endhighlight %}

Now we need to verify user information against the database and display errors when there are some. We will use
the [password_hash()](http://php.net/manual/en/function.password-hash.php) counterpart function [password_verify()](http://php.net/manual/en/function.password-verify.php)
similarly as in registration script:

File `login.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/login/login-first.php %}
{% endhighlight %}

## Persisting data between HTTP requests - $_SESSION
You probably noticed that there is no way to tell if a user has authenticated in subsequent HTTP requests due to stateless
nature of [HTTP protocol](/articles/web/#http-protocol). To safely store login information you would probably
want to logically connect subsequent HTTP request from one client (internet browser) and associate these requests with
some kind of server storage. That is exactly what [*sessions*](/articles/cookies-sessions/#sessions) are used for. A session
is a server-side storage which is individual for each client. Client holds only unique key to this storage on its side
(stored in [cookies](/articles/cookies-sessions/#cookies)). Client is responsible for sending this key with every HTTP
request. If the client "forgets" the key, data stored in session is lost. The key is actually called *session ID*.

To initiate work with session storage you have to call PHP function [`session_start()`](http://php.net/manual/en/function.session-start.php)
in the beginning of each of your script (before you send any output, because `session_start()` sends a cookie via
HTTP headers).

In PHP, there is as superglobal `$_SESSION` array which is used to hold various data between HTTP request. These
data are stored on a server and cannot be modified by will of a visitor -- it has to be done by your application's
code. The `$_SESSION` variable is initialized and eventually filled by `session_start()` function.

### Task -- store information about authenticated user
Use `$_SESSION` variable to store authenticated user's data after login. Insert line with `session_start();` function
into start.php script.

File `login.php` (final version):

{: .solution}
{% highlight php %}
{% include /walkthrough/login/login.php %}
{% endhighlight %}

Extended file `start.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/login/include/start.php %}
{% endhighlight %}

## Preventing unauthenticated users from performing actions
You can prevent anonymous users to access all your application's functions or just selected ones. If a visitor
tries to access prohibited function without authentication, he should be redirected to the login page.

### Task -- protect your application
Write a short include-script which will verify presence of user's data in `$_SESSION` array and redirect to login.php
script if no such data is found. Require this script in all PHP scripts where **you want user authentication to be
performed** before execution of that script itself. Place the require command just below the line where you require
start.php script.

File `protect.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/login/include/protect.php %}
{% endhighlight %}

Here is an example how to protect [deletion](/walkthrough/backend-delete/) of persons from database
with created script:

File `delete.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/login/delete.php %}
{% endhighlight %}

{: .note}
You can also pass information about authenticated user into templates in `protect.php` script. This would be useful
to modify your templates according to the presence of selected variable -- e.g. you can show or hide menu buttons
which are not accessible to anonymous user. If you choose to make some modules of your application public, you should
pass user related variables in another way because `protect.php` is not always executed. You can do that in `start.php`
after you start the session. Remember to handle non-existing values (for the case that the user is not logged in yet).

## Logout
Finally, we have to give our users an option to leave our application. A logout action is usually just deletion of
all user related data from `$_SESSION` variable on server.

{: .note}
Sometimes you wish to leave some data in the `$_SESSION` variable -- the contents of shopping cart, for example.

### Task -- Create a logout script
Use [`session_destroy()`](http://php.net/manual/en/function.session-destroy.php) function. Redirect user to public
page of your application after logout. Put logout button to your layout.latte template.

File `logout.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/login/logout.php %}
{% endhighlight %}

Make a link to logout script from main menu. You can display user's login name inside the link.

{% include /common/login-conclusion.md %}
