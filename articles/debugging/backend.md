---
title: Debugging web applications - backend
permalink: /articles/debugging/backend/
---

* TOC
{:toc}

Backend debugging can be tedious because the applications is sometimes running on different computer than you are
writing it. [Install](/course/not-a-student/#apache-based-stack-and-a-database-advanced) local PHP interpreter, web
server and database for serious development. Unfortunately, the error can sometimes be caused by the "environment",
i.e. the code works at your local server and does not work in production. This can be causes by installed libraries,
related applications like database or Apache web server and operating system (type and version).

## PHP debugging

PHP has quiet nice error reporting mechanism. It tells you the line number and the file where the error occurred.
Following code produces quiet handy error message.

~~~ php?start_inline=1
<?php
$sum = $a + $b; //these two variables are not defined
echo $sum;
~~~

![PHP error](/articles/debugging/php-error.png)

There is one thing to be aware of though: when you miss a semicolon, the error will be reported on the following line.

~~~ php?start_inline=1
line  9:    //...
line 10:    $stmt = $this->db->query('...')              //no semicolon here
line 12:    //empty
line 13:    $tplVars['something'] = $stmt->fetchAll();   //the error will be reported for line 13
line 14:    //... 
~~~

PHP has errors divided into several levels (from *ERROR* through *WARNING* to *NOTICE*). Some errors cause your
code to halt (e.g. *PARSE* errors), others like *WARNING* or *NOTICE* are just informational -- your code keeps running.
Notice that the first example still printed the resulting value "0" after those two errors. You can even disable
error reporting with a [function](http://php.net/manual/en/function.error-reporting.php).

{: .note}
Direct error reporting is usually disabled on production servers. Therefore these servers are not good for development
because you can miss out some problems -- e.g. PHP made the values of the variables `$a` and `$b` zero in the first
example -- it is nice, but you should define the initial values of variables by yourself. You never know, where
you application will run and whether the administrator of the server will enable the error reporting in the future.
Serious applications override the error reporting setting to report everything but they also set an [error handler](http://php.net/manual/en/function.set-error-handler.php)
which puts all error reports into a log file and not onto a screen of a visitor.

There are also exceptions which are thrown by some functions. Unhandled exceptions also causes your applications to
stop -- always use `try-catch` block when you know that a function can throw exception. And you can also set a
handler for [unhandled exceptions](http://php.net/manual/en/function.set-exception-handler.php).

### Stack trace
Sometimes you can encounter a *stack trace*. Usually when you use some kind of framework with enabled debugging.
At first it might seem very odd and quiet bulky. Stack trace is a printout of executed functions from top to bottom.
It shows the path of the interpreter in the code, including the code of the framework (which is not very useful).
Every line in the stack trace is a function call which brought the interpreter closer to the error. Take a look at
following image of Slim framework generated stack trace:

{: .image-popup}
![Error stack trace](/articles/debugging/stack-trace.png)

Different frameworks have different stack trace printout tools. Some of them are more useful, some of them less.
Do not be intimidated by the amount of information and try to find *your* PHP files in the stack trace and determine
the problem. Read the error message too.

The stack trace is often caused by uncaught exception, always use try-catch around SQL queries and disable debugging
mode of the framework in production (use logs).

## Concrete error examples
Now that I told you something about PHP's error reporting system, I can proceed to concrete examples. There is usually
two types of actions in the backend: retrieval and display of information and processing of inputs.

You have to be aware of all the kinds of possible PHP script inputs and conditions of execution, because the combination
of input parameter values and environment conditions is crucial to trigger errors:

- query parameters (e.g. `/some-route?id=123`)
- post data (from `<form method="post">`)
- [route placeholders](/walkthrough-slim/passing-values/#using-route-placeholders) (e.g. `/some-route/123`)
- [session values](/articles/cookies-sessions/)
- [HTTP headers](/articles/http/#headers)
- [cookies](/articles/cookies-sessions/) (passed via headers)
- data in the database
- [PHP config](/course/technical-support/#php-configuration)
- operating system and installed software and libraries (Linux VS Windows, Apache version, file system)
- version of PHP itself and installed plugins
- version and type of database (MySQL VS PostgreSQL VS SQLite VS ...)
- ... 

Easiest approach to determine content of a variable is to stop PHP script just anywhere and display contents of
variables using `echo` or `print_r()` function and then calling `exit`. Another way is to use logger.

{: .note}
You might seen using *breakpoints* and *stepping* through your code in another programming environments or just
read about it in JavaScript section. It is not impossible to do this with PHP, but it is problematic
because you code is not executed through your IDE. PHP is executed in a web server's context (and that also
can be on a different machine). To be able to set breakpoints you need to install PHP debugger like
[Xdebug](https://xdebug.org/) and connect it with your IDE. This is very difficult for beginners.

## Input processing errors
Input processing bugs are often caused by typos in variable naming -- check `name` attribute for each input element
and array keys used to access request parameters (either query or body). Input processing is a bit more complicated,
because the error can actually be caused by [previous rendering of another route](/walkthrough-slim/passing-values/#checking-incoming-data).

~~~ html
<form action="/errorneous-route" method="post">
    <input type="text" name="firstName">    <!-- the error is either here... -->
    <input type="submit" value="OK">
</form>
~~~

~~~ php?start_inline=1
$app->post('/errorneous-route', function(Request $request, Response $response) {
    $data = $request->getParsedBody();
    
    print_r($data);     //is it really there?
    exit;               //stop execution
    
    if(!empty($data['first_name'])) {   //...or here 
        //do some work
    } else {
        exit('Supply first name value.');
    }
});
~~~

A common problem with form-processing debugging is that you redirect the user away from the *POST* route. The easiest
thing you can do is to comment out the redirect command or use the `exit` command to stop PHP script.

~~~ php?start_inline=1
$app->post('/errorneous-route', function(Request $request, Response $response) {
    try {
        //...
        
        echo $someValue;    //print some value
        exit;               //stop execution
        
        return $response->withHeader('Location', $this->router->pathFor('other-route'));
    } catch(Exception $e) {
        $this->logger->error($e->getMessage());
        exit('DB error');
    }
});
~~~

### HTTP protocol debugging
Use developer tools (usually under F12 key) to display contents of *GET*, *POST* or cookie request parameters.
Following image shows Chrome developer tools with network console opened. You can find posted values (red) and cookie
values (green) in the details of the request. You should check the values and keys in HTTP request before you start
debugging PHP script. 

{: .image-popup}
![POST variables in chrome developer tools](/articles/debugging/post-request.png)

Another thing to check, although not that important for classical web applications, is [HTTP status code](/articles/http/#response-status-codes)
of the response. This is much more important for [AJAX](/articles/debugging/ajax-rest-api-and-spa/) applications.

{: .note}
Firefox has very similar tools for this.

## Data retrieval errors
Data retrieval is the process which extracts data from the database (using SQL query) and displays them to the user.
This part is more straight forward because everything is done in single load of the page. If your script depends on
query/post parameters, refer to previous section to check the incoming data.

### SQL related errors
Bugs related to retrieval and presentation of information are often caused by wrong SQL queries. Stop your code
right after the query is executed and print the result to be sure what came out of the database.

~~~ php?start_inline=1
$app->get('/errorneous-route', function(Request $request, Response $response) {
    try {
        //the problem is using wrong operator to compare against NULL (should be IS NULL)
        $stmt = $this->db->query('SELECT * FROM person WHERE id_location = NULL ORDER BY last_name');
        
        $tplVars['persons'] = $stmt->fetchAll();
        
        print_r($tplVars['persons']);     //print the result of query, you should see none
        exit;                             //stop the execution
        
        return $this->view->render($response, 'tpl.latte', $tplVars);        
    } catch(Exception $e) {
        $this->logger->error($e->getMessage());
        exit('DB error');
    }
});
~~~

It is crucial to use correct format for given data-types. For example `DATE` columns need the value to be passed
as `YYYY-MM-DD`. You have to convert any national date format into that. **Always** set value for columns without
defined default value although some SQL systems use pseudo-default values (e.g. empty string for `VARCHAR` column).
To pass `NULL`, use real PHP's `null` constant, not `''` (empty string) or `0` (zero). Remember that **everything that
came from HTTP request as parameter is a string** (yeah, because [HTTP](/articles/http/) is text based protocol).

~~~ php?start_inline=1
$app->post('/post-route', function(Request $request, Response $response) {
    $data = $request->getParsedBody();
    $val = !empty($data['...']) ? $data['...'] : null;
    $stmt = $this->db->prepare('INSERT ...');
    $stmt->bindValue(':col', $val);
    //...
});
~~~

### SQL query debugging
Using PDO's prepared statements is great for security but very bad for debugging. There is actually no way to see
the a query with placeholders replaced with actual values. It is because the query and parameters are passed
into the database system separately and the replacement of placeholders is actually carried out by the database
engine itself.

To be sure about the query result use Adminer or another tool to build the query before you plug it into your source
code.

### Template related errors
Another error-rich place is the interface between template and PHP code. Make sure that you understand the structure
that you pass in `$tplVars` variable to the templating engine and that you use right variable names in the template.

Problem with template engine lies in the fact, that template files are not executed as they are, they are in fact
converted into real PHP code (which is stored in cache) and therefore the PHP error reporting from template is very
confusing (it points to some cached files). PHP code which represents the template is usually loosely similar to the
template, you can open the compiled template from cache and look for the line which reported the error to determine
the actual problem in the template.

{: .image-popup}
![Template error](/articles/debugging/template-error.png)

Let's see what is around line 68 in that file:

~~~ php
<?php
  $iterations = 0;
  foreach ($persons as $person) {
?>
  <tr>
    <td><?php echo LR\Filters::escapeHtmlText($person['first_name']) /* line 15 */ ?></td>
    <td><?php echo LR\Filters::escapeHtmlText($person['last_name']) /* line 16 */ ?></td>
    <!-- following line is number 68 in compiled template -->
    <td><?php echo LR\Filters::escapeHtmlText($person['nicknam']) /* line 17 */ ?></td>
    <td><a href="<?php
		  echo $router->pathFor("addContact");
	    ?>?id=<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($person['id_person'])) /* line 18 */ ?>">Add contact</a></td>
  </tr>
<?php
    $iterations++;
  }
?>
~~~

Latte templating engine even includes original line numbers as comments on some of the lines. You can look for similar
structure in the original template file:

~~~ html
{foreach $persons as $person}
<tr>
  <td>{$person['first_name']}</td>
  <td>{$person['last_name']}</td>
  <!-- following line is number 17 in latte file -->
  <td>{$person['nicknam']}</td>
  <td><a href="{link addContact}?id={$person['id_person']}">Add contact</a></td>
</tr>
{/foreach}
~~~

Those two files are not that different, you can easily see, that the problem was a typo in array key `nickname`.
My example was a very simple error, many errors are hard to find because the template is messy -- use indentation,
good editors have functions to format code automatically, and good editors also have macro pairs highlighting. Some
templates are very long -- use inheritance and includes to avoid code repetition. Sometimes the problems is not with
template syntax, but with rendered HTML structure, this is covered in [frontend debugging article](/articles/debugging/frontend/).

## Summary
In comparison with frontend, the backend environment is much more determinate. You usually have only one server with
given versions of PHP, Apache and a database. A great problem is when everything works in development environment and
fails in production.

### New Concepts and Terms
- error levels
- error handler
- exception handler