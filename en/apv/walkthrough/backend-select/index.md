---
title: Interaction
permalink: /en/apv/walkthrough/backend-select/
---

* TOC
{:toc}

In the [previous chapter](/en/apv/walkthrough/backend/), you have learned how to use SQL queries from within
PHP scripts. You have also learned how to use parameters in SQL queries using 
[prepared statements](/en/apv/walkthrough/backend/#selecting-data-with-parameters). In this chapter, we will connect
it with HTML forms to build a fully interactive page which communicates with a database.

## Getting Started
In this chapter, we need to get back to [HTML forms](/en/apv/walkthrough/html-forms/) and processing them in PHP.
For processing HTML forms, you need to be familiar with what the browser sends -- 
the [name-value pairs](/en/apv/walkthrough/html-forms/#name-and-value) for controls.

### POST Values
The name-value pairs of form controls accessible in PHP in either `$_GET` or `$_POST` variable. The `$_GET` 
and `$_POST` variables are one of [PHP magical variables](todo). They are magical because they are automatically
(magically) filled with values from the HTTP request. Whether the form controls are available in the 
`$_GET` or `$_POST` variable is determined what `method` attribute is assigned to the HTML form. therefore
having `<form method='post'>` does an [HTTP POST](/en/apv/articles/web/#http-protocol) method and 
PHP will make the name-value pairs available in the `$_POST` variable automatically.  

To demonstrate this, we need a simple script with HTML form. PHP script:

{% highlight php %}
{% include /en/apv/walkthrough/backend-select/form-1.php %}
{% endhighlight %}

HTML form:

{% highlight php %}
{% include /en/apv/walkthrough/backend-select/form-1.latte %}
{% endhighlight %}

Layout template:

{% highlight php %}
{% include /en/apv/walkthrough/backend-select/layout.latte %}
{% endhighlight %}

If you enter some text (e.g. 'fooBar') in the text field in hit the button, 
you should see something like:

    array ( 'someText' => 'fooBar', 'send' => 'something', )

You can see that the `$_POST` array is as an associative array of form controls. The indexes 
in the array are form control names, and the values are control values. This underlines
the importance of knowing 
what [control names and values are](/en/apv/walkthrough/html-forms/#name-and-value).

It is also important to know, that the entire script is stateless, the same 
way [HTTP protocol is](/en/apv/articles/web/#http-protocol). This means that the `$_POST` array is filled
*only for a single execution*. Test the above example and see for yourself, that
the content of `$_POST` array is only filled with what you just entered
(or nothing, if you did not send the form and just loaded the page).

The `GET` method behaves slightly different than the `POST` method in that it changes the URL of the script. This 
means that the state of the form is encoded in the address of the page and therefore remains there
until changed again. It is quite important to decide on the [correct HTTP method to use](todo).  

### Connecting together
Now let's make a page which lists the users in the database and lets the user search within them.
We can list e.g. first name, last name, nickname of each person and order them by the last name and 
first name. For searching we need to create a form with one *search keyword*.
Now let's think about what possible states the page can have and what will be displayed, for example:

- The form was not submitted (page was visited through a link, or reloaded) -- display all persons
- The form was submitted (end user pressed a button): 
 - The end user entered something to search for -- display only the found persons
 - The end user did not enter anything to search for -- display all persons

If you are confident, you can skip right to the [finished page](todo). Otherwise 
Let's start with making a static page first:

{% highlight html %}
{% include /en/apv/walkthrough/backend-select/persons-static.html %}
{% endhighlight %}

Now add a PHP script, which generates the page using a template and a layout template (you can
use one [from the previous chapter](/en/apv/walkthrough/backend/). So the page template would be: 

{% highlight html %}
{% include /en/apv/walkthrough/backend-select/persons-list-1.latte %}
{% endhighlight %}

Let's add the form handling in the PHP script and print out what the user searched for. 
To determine if a form has been submitted, you can use two methods:

- check if the `$_GET` array is not empty (some form has been submitted)
- check if the `$_GET` array contains an element with the button name (check if the specific button has been pressed)

Generally the second option is better, as it works even if there are multiple forms on
a single page. To determine if an array contains an element, we can use the `empty` function: 

{% highlight php %}
{% include /en/apv/walkthrough/backend-select/persons-list-1.php %}
{% endhighlight %}

It is not correct to use the condition `if ($_GET['search'] == '')` because that would trigger a warning 
that the `search` item is not found in the array (and thus cannot be compared to anything). Also the 
`empty` function checks if the value of the variable evaluates to false, taking advantage of the
[boolean conversion](/en/apv/walkthrough/dynamic-page/#boolean-conversions). This means 
we can use it also on the `keyword` field to check whether the
user has entered some non-empty string.

Now we need to prepare two SQL queries to list the users. The query to list all users is pretty simple, 
e.g.:

{% highlight sql %}
SELECT first_name, last_name, nickname, AGE(birth_day) FROM person 
ORDER BY last_name, first_name
{% endhighlight %}

The query for searching is slightly more complicated, to search e.g. for 'bill' we can use:

{% highlight sql %}
SELECT first_name, last_name, nickname, AGE(birth_day) FROM person
WHERE (first_name ILIKE '%bill%') OR (last_name ILIKE '%bill%') OR (nickname ILIKE '%bill%')
ORDER BY last_name, first_name
{% endhighlight %}

I used the [`ILIKE` operator](https://www.postgresql.org/docs/current/static/functions-matching.html) which 
provides a case-insensitive match. Also I used '%' both
on the beginning and at the end of the pattern so that a full-text search is achieved. The pattern
'%bill%' would therefore match any of: 'Bill', 'billy', 'kill-bill', etc.
To achieve the required functionality you need to put the above SQL statements in the 
prepared `if` conditions (assuming you have PDO instance in `$db` variable): 

{% highlight php %}
if (!empty($_GET['search'])) {
	if (!empty($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
		$stmt = $db->prepare('
            SELECT first_name, last_name, nickname, AGE(birth_day) FROM person
            WHERE (first_name ILIKE :keyword) OR (last_name ILIKE :keyword) OR (nickname ILIKE :keyword)
            ORDER BY last_name, first_name
        ');
        $stmt->bindValue('keyword', '%' . $keyword . '%'); 		
        $stmt->execute();
	} else {
		$keyword = '';
		$stmt = $db->query('
            SELECT first_name, last_name, nickname, AGE(birth_day) FROM person 
            ORDER BY last_name, first_name
        ');
	}
} else {
	$keyword = '';
    $stmt = $db->query('
        SELECT first_name, last_name, nickname, AGE(birth_day) FROM person 
        ORDER BY last_name, first_name
    ');
}
{% endhighlight %}

Or use another condition:

{% highlight php %}
if (!empty($_GET['search'])) {
	if (!empty($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
	} else {
		$keyword = '';
	}
} else {
	$keyword = '';
}

if ($keyword) {
    $stmt = $db->prepare('
        SELECT first_name, last_name, nickname, AGE(birth_day) FROM person
        WHERE (first_name ILIKE :keyword) OR (last_name ILIKE :keyword) OR (nickname ILIKE :keyword)
        ORDER BY last_name, first_name
    ');
    $stmt->bindValue('keyword', '%' . $keyword . '%'); 		
    $stmt->execute();    
} else {
    $stmt = $db->query('
        SELECT first_name, last_name, nickname, AGE(birth_day) FROM person 
        ORDER BY last_name, first_name
    ');
}
{% endhighlight %}

### Finalizing
There are many other solutions how the above code can be written. However it is very important to maintain 
consistency of the program behavior in that each branch of the condition changes the state of the program 
in a same way. Notice that no matter what branch of the first condition is executed, we 
will **always have `$keyword` variable defined as a string** although its content may vary.
If you look at the second condition, you'll see that no matter which branch gets executed, we 
will **always have `$stmt` variable defined with an executed SQL statement**. It is therefore 
very important to call `execute` in the first branch of that condition, to make the output compatible
with the output of the second branch. This approach to writing the code prevents a lot of bugs and
weird situations. But it requires you to ask 'what should be the outcome of this piece of code' ?

Let's add the condition to the PHP script together with the connection to the database, `try-catch` for error control
and printing of the results.

{% highlight php %}
{% include /en/apv/walkthrough/backend-select/persons-list-2.php %}
{% endhighlight %}

Perhaps you got the idea that I could've added the `required` attribute to the keyword
form control to prevent the form from being submitted empty and simplify the PHP script. Yes, we
can do that, but it won't simplify the PHP script, because the validation in form is
only on the client side (web browser) and is [unreliable](todo). 

## Task -- Precise the search
One can object that the search form as it is now is too relaxed. What if the user wants to 
search both by the first name and last name? E.g. she knows that she's looking for 
someone named 'John Do*something*'. Your task is now to extend the search script to 
do so. Try to find a solution without adding more form controls.

{: .solution}
<div markdown='1'>
Let's say that the user enters 'John Do' in the search field. We can split the text by a space and 
obtain strings 'John' and 'Do'. Then we can search for them using an SQL query. To split a string
in PHP, you can use the [`explode` function](http://php.net/manual/en/function.explode.php). 
You can use the [`count` function](http://php.net/manual/en/function.count.php) to
count the number of items in the array.
</div>

{: .solution}
{% highlight php %}
<?php
$keyword = 'John Do';
$parts = explode(' ', $keyword);
$first_name = $parts[0];
$last_name = $parts[1];
{% endhighlight %}

{: .solution}
<div markdown='1'>
You need to implement an extended logic to handle all the possible cases. It is not mandatory for the 
end-user to enter two words. What happens when the user enters only a single word? What happens when 
the user enters three words? What are all the possible states?
</div>

{: .solution}
<div markdown='1'>
- The form was not submitted -- display nothing
- The form was submitted (user pressed the search button): 
    - User entered no keyword -- display nothing
    - User entered a single keyword -- display persons with matching first name or last name 
    - User entered two keywords -- split the keyword into words and search for the user with the first name matching the first word and the last name matching the second word
    - User entered three keywords -- display an error message
</div> 

Page template (notice the introduction of `$message` variable:

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend-select/persons-list-sol.latte %}
{% endhighlight %}

PHP script (notice that the queries have different boolean operators):

{% highlight php %}
{% include /en/apv/walkthrough/backend-select/persons-list-sol.php %}
{% endhighlight %}

{: .note}
The above script is written in a slightly different style than 
the [previous one](/en/apv/walkthrough/backend-select/#finalizing). Here, I 
maintained the consistency of state by first initializing the `$persons` and `$message` variables
to some default values and used the conditions to change them only when necessary. This leads 
to more concise code, which may be harder to read as it does not explicitly enumerate all of the 
possible states. This is however a more practical approach. 

## Summary
There are many more options (probably thousands!), how the above search form can be implemented.
For example you can add searching by a nickname, day of birth, height etc. There are many possibilities
how all those criteria can be combined, which leads us to an [application design](todo).   

In this chapter you have learned how to process HTML forms in the PHP script.
You should be familiar with the structure of `$_GET` and `$_POST` variables.
Make sure you understand the rules how HTML form controls are transformed into
[name-value pairs](/en/apv/walkthrough/html-forms/#name-and-value) and subsequently into `$_GET` and `$_POST` variables.
This allows you to implement your own logic into the application behavior. So from now on, most of the 
exercises have a virtually unlimited number of solutions. 

### New Concepts and Terms
- Processing HTML forms
- HTTP GET 
- HTTP POST
- $\_GET and $\_POST magical variables
