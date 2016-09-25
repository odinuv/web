---
title: Inserting data
permalink: /en/apv/walkthrough/backend-insert/
---

* TOC
{:toc}

In previous chapters, you learned how to [work with HTML forms](/en/apv/walkthrough/html-forms/) 
and [how to organize your code](/en/apv/walkthrough/organize/). Now we add some more code to insert data into the database.
There is no new technology necessary for this, all you need is [SQL INSERT](/en/apv/walkthrough/database/#insert) and
[working with HTML forms](/en/apv/walkthrough/html-forms/). Yet there are some things, which are worth deeper explanation. 

## Getting started
We will create a page for inserting new persons in the database. Let's start with the HTML form.

`templates/person-add.latte`:

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend-insert/templates/person-add.latte %}
{% endhighlight %}

`person-add.php`: 

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend-insert/person-add.php %}
{% endhighlight %}

See how [organizing you code](todo) pays off? Adding a new page to the application requires almost only writing
the necessary HTML code. There is very little overhead now.

As you can see, I put the form in a table so that it is nicely arranged. If you don't like it, use 
another template! This is the good thing about templates -- they separate the HTML code from PHP code, you 
you change one without worrying about the other. If you use the same form *control names* you can use
the bellow PHP script regardless of what your form looks like!

Notice, that I used a `$message` variable in the template. It will come in handy. 

### Inserting Data
It is important to use correct [HTTP method](todo). Since inserting a person is a data changing action, I
am using the POST method (`<form method='post'>`). This means that we will find the form data in 
`$_POST` variable when the user submits the form.

First we need to check that the user submitted the form. If yes, then we need to validate the input from the 
user. All three fields are required (they are mandatory in the `person` table) and must be validated on the
server (in PHP script) because [client side validation is insufficient](todo).
If the user input is valid, then we can send an `INSERT` query to database, to insert the data. We
will need a [prepared statement](todo) to pass in the values.

{% highlight php %}
{% include /en/apv/walkthrough/backend-insert/person-add-2.php %}
{% endhighlight %}
 
Note that I didn't use `exit` in the `catch` statement. Failure to insert data into database is a non-fatal
error -- i.e. the application can continue and display an error to the user and let him correct the error.
So I simply assigned the error to the `$message` variable and then passed that to the template in
`$tplVars['message'] = $message;`.

Try the above script and verify that the form validation works fine. If you put `required` attribute to 
the form controls, either remove it for the test, or use [developer tools](todo) to do so temporarily.

The part of the PHP script which requires deeper explanation is probably this:
{% highlight php %}
if (empty($_POST['birth_day'])) {
    $stmt->bindValue(':birth_day', null);
} else {
    $stmt->bindValue(':birth_day', $_POST['birth_day']);
}
{% endhighlight %}

In the `person` table in the database. The column `birth_day` [allows NULLs](todo), i.e. its value is not 
required. If the user does not fill the date input element, the PHP script will receive an empty 
string. The database server will fail to insert this, because empty string is neither valid date, nor
a NULL (database server is more concerned about data types than PHP). Therefore we need to manually
supply the `null` value in case `birth_day` is not filled. Luckily, PHP `null` is nicely compatible
with database `NULL`. Again it is very important that you understand what values originate from 
where and what variables are connected: 

{: .image-popup}
![Code schema -- Script for inserting data](/en/apv/walkthrough/backend-insert/code-schematic.png)

## Task -- Extend the form
Now extend the form by adding other columns from the `person` table -- `gender` and `height`. Use proper
form controls for the values. Check whether each column is required and handle NULLs correctly if necessary.

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend-insert/templates/person-add-sol.latte %}
{% endhighlight %}

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend-insert/person-add-sol.php %}
{% endhighlight %}

The radio buttons may be replaced by `<select>` control. 
The condition `(empty($_POST['gender']) || ($_POST['gender'] != 'male' && $_POST['gender'] != 'female'))`
could be also written as `(empty($_POST['gender']) || !in_array($_POST['gender'], ['male', 'female']))`.
The condition `(empty($_POST['height']) || empty(intval($_POST['height'])))` first checks that the value 
`$_POST['height']` is defined and non-empty. Then checks if the value converted to integer 
(using [`intval` function](todo)) is still not empty.
In both conditions the order of conditional expressions is important. It must always start with the check
for empty `$_POST` field due to [partial boolean evaluation](todo).

## Summary
In this chapter you learned how to inset data from HTML form into a database table. As usual there are multiple
options how you can implement the application logic -- especially the value validation (e.g. you could trigger
an error if height is not number, instead of ignoring it). When inserting data to database, you need to 
be aware of what values are optional and handle the optional values correctly.

### New Concepts and Terms
- Optional values
- NULL
