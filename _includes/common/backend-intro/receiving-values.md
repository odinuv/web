One of previous chapters taught you how to build [HTML form](../../html-forms/). The interesting part is how to access
and process this data in a PHP script. The processing part is arbitrary and is covered in following chapters of this
walkthrough. General knowledge of accessing to input data is crucial for development of web page.

Remember, that [HTTP protocol](/articles/web/#http-protocol) can only transmit texts. Therefore everything you
send or receive over it has to be converted into sequence of characters.

## Accessing data in plain PHP
There are generally two most used HTTP methods - *GET* and *POST*. For now, it is not important to know which method
to use when. This chapter only focuses on accessing input data.

### *POST* method
As the name of the method suggests, it is used to send data to the server. Values send by *POST* method are hidden
in request *body*. You cannot see them easily as a user, but it is not difficult to see/modify them for slightly
advanced developer. *POST* request can only be created using [HTML form](../../html-forms/).

To access data send from a form in PHP script, use special super-global variable called `$_POST`. It is an associative
[array](../array/) with keys corresponding to `name` attribute of form input elements. Let's see an example:

~~~ html
<form method="post">
    ...
    <input type="text" name="my_input_name">
    ...
</form>
~~~

Value of such input is available, after being filled by a visitor and form submitted, in `$_POST` associative array
under key `my_input_name`.
 
~~~ php?start_inline=1
...
echo $_POST['my_input_name'];
...
~~~

#### Task -- pass some values using *POST* method
Create a PHP file with form which will have two inputs. Set `method="post"` attribute on form element. Remember to set
name attributes of those inputs. Insert a PHP code right into this file and display text. The form should have no
`action` attribute, because it submits itself to same URL. You can use [empty()](http://php.net/manual/en/function.empty.php)
function to determine whether `$_POST['key']` is filled or not.

{: .solution}
~~~ php
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>POST method experiment</title>
    </head>
    <body>
<?php
    if(!empty($_POST)) {
        //print_r($_POST);
        echo "Greetings ";
        echo $_POST['name'];
        echo $_POST['surname'];
    }
?>
        <form method="post">
            <label>First name</label>
            <input type="text" name="name">
            <br>
            <label>Last name</label>
            <input type="text" name="surname">
            <br>
            <input type="submit" value="Greet me">
        </form>
    </body>
</html>
~~~

{: .note}
Notice, that after you submit the form, the page reloads entirely -- it means that the script is re-executed with
different initial conditions (i.e. the `$_POST` variable contains something) and therefore the script behaves
differently.

#### Task -- try to hide the form after submit
Use `if(...) {...}` [control structure](../control/) to detect whether the form was submitted (i.e. the input in
`$_POST` is available or not).

{: .solution}
~~~ php
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>POST method experiment</title>
    </head>
    <body>
<?php
    if(!empty($_POST)) {
        //print_r($_POST);
        echo "Greetings ";
        echo $_POST['name'];
        echo $_POST['surname'];
    }
    if(empty($_POST)) {
?>
        <form method="post">
            <label>First name</label>
            <input type="text" name="name">
            <br>
            <label>Last name</label>
            <input type="text" name="surname">
            <br>
            <input type="submit" value="Greet me">
        </form>
<?php
    }
?>
    </body>
</html>
~~~

### *GET* method
Values send by *GET* method are visible in *URL* -- you can see and modify them in browser address bar. *GET* parameters
are passed in *query* part of URL behind question mark character in given format as key-value pairs:
        
~~~
       +---HOST---+ +-----PATH-----+ +--------------QUERY--------------+
http://some.host.io/path/to/file.php?param=value&param2=value2&key=value
                                      KEY  VALUE  KEY   VALUE  KEY VALUE
~~~

The key part of this key-value pair is given and PHP script expects particular keys to be present. The value is
arbitrary.

To access data send using *GET* method in PHP script, use special super-global variable called `$_GET`. It is an
associative [array](../array/) with keys corresponding to `key` of the key-value pair in URL query part. Let's see an
example:

~~~ html
<a href="script.php?my_value_name=something">Click it</a>
~~~

Value of key-value pair is available, after the link is clicked, in `$_GET` associative array under key `my_value_name`.
 
~~~ php?start_inline=1
...
echo $_GET['my_value_name'];
...
~~~

*GET* parameters are usually given in HTML links for users to click on them. You can also create a form which uses
*GET* method to pass values from inputs, the browser than creates a URL with key-value pairs constructed from
inputs' `name` attributes and user filled values.

{: .note}
The *GET* method is obviously used when you want to modify displayed information using predefined parameters, e.g.
filtering or ordering because common visitor does not know that he can change parameter values in address bar.
He can only click on coloured links.

#### Task -- pass some values using *GET* method and print them
Create a PHP file and insert HTML code which renders as link to itself (I used `script.php` as filename). Pass two
parameters using GET method.

{: .solution}
~~~ php
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>GET method experiment</title>
    </head>
    <body>
<?php
    if(!empty($_GET)) {
        //print_r($_GET);
        //or
        echo "Greetings ";
        echo $_GET['name'];
        echo $_GET['surname'];
    }
?>
        <a href="script.php?name=John&surname=Doe">Click to greet John Doe</a>
    </body>
</html>
~~~

{: .note}
Notice, that after you click the link, the page reloads entirely -- it means that the script is re-executed with
different initial conditions (i.e. the `$_GET` variable contains something) and therefore the script behaves
differently.

#### Task -- change key or value in address bar and observe behaviour
Click the link so you can see the parameters passed in address bar. Try to change key part, e.g. change
`script.php?name=John&surname=Doe` to `script.php?a=John&b=Doe`. It should display errors saying that keys `name` and
`surname` are not available. Change the value part to `script.php?name=Your name&surname=Your surname` and try it.

#### Task -- take *POST* example, change method to *GET* and observe behaviour
Change the `method="post"` attribute on form to `method="get"` and use `$_GET` variable instead of `$_POST`. You should
see values from input being passed in URL. Otherwise the behaviour should be exactly the same.

## Sanitization of input and output
You expect that users of your application behave somewhat "normally", i.e. they input numbers where numbers should be
present, they do not input HTML code into input meant for username etc. But not all visitors are nice, some of them
want to cause trouble (or they use bots to do it for them).

Take a look at following piece of code. You expect that those two fields are fed with numerical values and than you
add them. What happens, when the user inputs some non-numeric string? What happens when user inputs HTML tag?

~~~ php
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>POST method experiment</title>
    </head>
    <body>
<?php
    if(isset($_POST['a']) && isset($_POST['b'])) {
        $a = $_POST['a'];
        $b = $_POST['b'];
        $c = $a + $b;           //perform addition
        echo "$a + $b = $c";    //print formula and result
    }
?>
        <form method="post">
            <label>Value A</label>
            <input type="text" name="a">
            <br>
            <label>Value B</label>
            <input type="text" name="b">
            <br>
            <input type="submit" value="Add values">
        </form>
    </body>
</html>
~~~

### Task -- try to break the form
- Submit the form without any value.
- Instead of entering numerical values, try to input strings, e.g. `abc` and `def`.
- Enter HTML tag, e.g.: `<a href="http://mendelu.cz">MENDELU</a>`.

{: .solution}
<div markdown="1">
- There should be warnings about using non-numeric values with + operator.
- When you input `<a href="http://mendelu.cz">MENDELU</a>` it is rendered as actual HTML tag. 
</div>

{: .note}
Think about this for a while. Do you want this? What would happen, if such HTML tag or tags are stored on the server
and displayed to other visitors? What if it is not just one HTML tag (e.g. you can display an image with some
advertisement)? It depends -- it OK for [CMS](https://en.wikipedia.org/wiki/Content_management_system) where an
administrator needs to be able to modify content of particular page, it is not OK for public comments.  

### Task -- try to protect the form
Sanitize output first, use [`htmlspecialchars()`](http://php.net/manual/en/function.htmlspecialchars.php) function to
convert `<` and `>` to HTML entities `&lt;` and `&gt;`, this should disable HTML tags from rendering:

{: .solution}
~~~ php
<?php
    if(isset($_POST['a']) && isset($_POST['b'])) {
        $a = $_POST['a'];
        $b = $_POST['b'];
        $c = $a + $b;           //perform addition
        echo htmlspecialchars("$a + $b = $c");    //print formula and result
    }
?>
~~~

Take a look into HTML source and observe what happened. Now try to sanitize input, use [`floatval()`](http://php.net/manual/en/function.floatval.php)
function to convert any non-numeric values to zero.

{: .solution}
~~~ php
<?php
    if(isset($_POST['a']) && isset($_POST['b'])) {
        $a = floatval($_POST['a']);
        $b = floatval($_POST['b']);
        $c = $a + $b;           //perform addition
        echo htmlspecialchars("$a + $b = $c");    //print formula and result
    }
?>
~~~

Your form is now more robust for invalid input and is also secured from [XSS](/articles/security/xss/) vulnerability.

## Summary
You should know how to read *GET* and *POST* input in plain PHP script. If you are going to use a framework to build
your application, you will use different approach to access data but the principle is the same. Remember that form
input values are identified by `name` attribute and query parameters are identified by key part of key-value pair.

There is also variable called `$_REQUEST` which gathers `$_GET`, `$_POST` and `$_COOKIE` arrays together.

### New Concepts and Terms
- GET data
- POST data
- $_GET
- $_POST

### Control question
- When to use GET and when to use POST?
- How do you check incoming data?
- How does web browser build the POST or GET request from a form?