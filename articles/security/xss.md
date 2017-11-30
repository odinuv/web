---
title: Cross site scripting (XSS)
permalink: /articles/security/xss/
redirect_from: /en/apv/articles/xss/
---

* TOC
{:toc}

Cross site scripting (XSS) is a technique which allows the attacker to modify behaviour of visitors browser in a way
he wants. It can be used to display advertisements, perform actions on behalf of the victim or steal personal
information.

The principle of the attack is simple: the attacker smuggles malicious code (usually JavaScript) into vulnerable
page's source code and waits for other visitors to execute such code.

The easiest demonstration of such attack is simple input-echo loop in PHP:

`xss-example.php`:

{% highlight php %}
<!DOCTYPE html>
<html>
    <head>
        <title>Simple XSS</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form method="get">
            <input type="text" name="val">
            <br>
            <input type="submit" value="Send">
        </form>
    </body>
</html>
<?php
    if(!empty($_GET['val'])) {
        echo 'You entered: ' . $_GET['val'];
    }
?>
{% endhighlight %}

Try to insert value `<script>alert('D\'oh')</script>` into the input element and submit the form. Instead of
rendering the letters, the code behaves different: it executes the code as JavaScript and opens the alert dialog.
This behaviour is definitely not desired (you do not want your users to be able to modify functionality of your
application). Now imagine that this string is stored into a database and the message pops up to **every other**
visitor of your online presentation...

The important thing is that the attacker is able to execute *his* code on *your* website. He can point visitors
to your site with given `val` parameter in URL using simply `<a href="http://site.com/?val=..."></a>` tag.

{: .note}
Do not be angry at PHP that it has weak security. The `echo` statement is used to output *exactly* what the developer
wants to output. How else would one be able to generate HTML code using PHP if the `echo` statement would translate
all `<` and `>` to substitute entities? This is similar as with [SQL injection](/articles/security/sql-injection/),
the code merely does what it is told to do. It is your fault that you do not see the consequences.

## How to defend?
To overcome this issue, you have to escape dangerous characters, in this case convert `<` and `>` to `&lt;`
and `&gt;` entities. You can use PHP's function [`htmlspecialchars()`](http://php.net/manual/en/function.htmlspecialchars.php)
to achieve this. But you would have to use this function everywhere in your code. This is tedious and error prone.

{: .note}
Remember that there are also different escaping rules for different contexts - e.g. URL parameter VS JavaScript VS HTML!

To fix the code add this function to the `echo` statement.

{% highlight php %}
<?php
    if(!empty($_GET['val'])) {
        echo 'You entered: ' . htmlspecialchars($_GET['val']);
    }
?>
{% endhighlight %}

You were taught in the walkthrough section to use a [templating engine](/walkthrough-slim/templates/). Such templating
engine removes the burden of remembering to use `htmlspecialchars()` function everywhere because it filters those
dangerous entities automatically.

## Types of attacks
The XSS attack has different levels of severity.

### Local
Based on JavaScript processing of values from query parameters (which is rare with classical web application).
This kind of attack cannot be stopped with backend templating engine. You have to decide whether the text
printed by JavaScript into document's code can be modified by the visitor and use function to remove dangerous
characters. You should use `element.innerText` instead of `element.innerHTML` or `$(selector).text(value)`
instead of `$(selector).html(value)` with jQuery to emphasize that you are printing a text value.

Even weaker variant which cannot be exploited to endanger other visitors is untreated printing of values from form
inputs back to page content.

### Non-persistent
This is the exactly the kind of vulnerability I used in introductory example. Attacker sets up input parameters
in a way which leads to execution of malicious code in visitors browser. This type of attack can be easily
defeated with templating engine. Nevertheless this kind of attack is not persisted and attacker's code is
only executed when visitor clicks the "right" trap-link similarly to previous case.

### Persistent
This scenario is similar to the previous one, except that the malicious code is additionally stored in a database.
It means that the attacker does not have to put traps to lure visitors to visit a page with his code.
All the visitors are presented with affected version of site once they open it, no matter how careful they are.

{: .note}
Even if those first two types of XSS attack seem to be harmless on the first sight, all types of attack are similarly
dangerous. All it takes is to publish ordinary link with supplied attack code on a discussion board, email or
anywhere else online.

## Possible harm
The principle of XSS attack is now clear. I will show you how a XSS vulnerability can be exploited for the benefit
of the attacker. There is quiet a lot of possible ways to exploit XSS, once you can execute JavaScript code on
arbitrary computer, you have same freedom as any web developer using JavaScript with the benefit that your code
is "hosted" on affected website and therefore anonymous.

The simplest use of XSS is to open some popup window perhaps with some kind of advertisement -- simply put,
the attacker wants to catch attention of a visitor and make him to do something else.

More dangerous XSS attack is a combination with [CSRF](/articles/security/csrf/) attack -- the attacker expects that visitor
of affected site is actually logged into another (well known) service. He knows that the browser automatically
appends HTTP headers (i.e. cookies with authorisation tokens) for HTTP requests. The attacker can execute actions
on behalf of his victim -- perhaps he can try to change a password and block the account or issue order of goods.
These kind of attacks are more difficult to perform nowadays thanks to [origin policy](https://en.wikipedia.org/wiki/Same-origin_policy)
applied in web browsers (you cannot easily send AJAX requests to another domain unless that domain allows it)
but still the attacker can make the visitor to submit ordinary form with modified hidden fields. Any action invoked
by the GET method can easily exploited even with simple `<img src="http://target.com/make/some/harm.php">` tag.

XSS can also be used to spy on visitors and send personal data like user credentials to the attacker. This is a very
dangerous scenario.

Another example can be DDoS attack on another service. An attacker can use connectivity of visitors to overload
any online service with random HTTP requests generated by visitors' web browsers.

## Summary
XSS is a very dangerous vulnerability which you can introduce in you code. It is quiet easy to avoid it
by usage of the right tools -- a templating engine. You can read detailed description of XSS attack and check
out more examples on [OWASP page](https://www.owasp.org/index.php/Cross-site_Scripting_(XSS)).