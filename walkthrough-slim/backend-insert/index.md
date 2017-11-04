---
title: Inserting data
permalink: /walkthrough-slim/backend-insert/
---

* TOC
{:toc}

In previous chapters, you have learned how to [work with HTML forms](/walkthrough-slim/html-forms/).
Now we will add a little bit more of a code to insert data into the database.
There is no new technology necessary for this, all you need is [SQL INSERT](/walkthrough-slim/database/#insert) and
[working with HTML forms](/walkthrough-slim/html-forms/). Yet there are some things, which are worth deeper explanation.

## Getting started
We will create a page for inserting new persons in the database. Let's start with the HTML form.

`templates/person-add.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/backend-insert/person-add.latte %}
{% endhighlight %}

`src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/backend-insert/person-add.php %}
{% endhighlight %}

As you can see, I put the form in a table so that it is nicely arranged. If you don't like it, use
another template! This is the good thing about templates -- they separate the HTML code from the PHP code,
you change one without worrying about the other. If you use the same form *control names* you can use
the bellow PHP script regardless of what your form looks like!

Notice, that I used a `$message` variable in the template. It will come in handy.

### Inserting Data
It is important to use a correct [HTTP method](todo). Since inserting a person is a data changing action, I
am using the POST method (`<form method='post'>`). This means that we will find the form data in
with `$request->getParsedBody()` method when the user submits the form. In pure PHP it would be in `$_POST` variable.

First we need to check that the user submitted the form. If yes, then we need to validate the input from the
user. All three fields are required (they are mandatory in the `person` table) and must be validated on the
server (in the PHP script) because the [client side validation is insufficient](todo).
If the user input is valid, then we can send an `INSERT` query to the database, to insert the data. We
will need a [prepared statement](/walkthrough-slim/database-using/#selecting-data-with-parameters)
to pass in the values.

{% highlight php %}
{% include /walkthrough-slim/backend-insert/person-add-2.php %}
{% endhighlight %}

Note that I didn't use `exit` in the `catch` statement. Failure to insert data into the database is a non-fatal
error -- i.e. the application can continue and display an error to the user and let him correct the error.
So I have simply assigned the error to the `$message` variable and then passed that to the template in
`$tplVars['message'] = $message;`.

{: .note}
There are actually different types of SQL errors, you can check the value returned by `$e->getCode()` method.
For example the duplicate record error is 23505 (unique violation) and the error in date format has code 22007. 

Try the above script and verify that the form validation works fine. If you put the `required` attribute to
the form controls, either remove it for the test, or use [developer tools](/course/not-a-student/#web-browser)
to do so temporarily.

The part of the PHP script which requires deeper explanation is probably this:
~~~php?start_inline=1
if (empty($data['birth_day'])) {
    $stmt->bindValue(':birth_day', null);
} else {
    $stmt->bindValue(':birth_day', $data['birth_day']);
}
~~~

{: .note}
You can use shorter [ternary operator](http://php.net/manual/en/language.operators.comparison.php) to save some space
in your source code: `$stmt->bindValue(':birth_day', empty($data['birth_day']) ? null : $data['birth_day']);`.

In the `person` table in the database. The column `birth_day` [allows NULLs](/articles/sql-join/#null), i.e.
its value is not required. If the user does not fill the date input element, the PHP script will receive an empty
string. The database server will fail to insert this, because the empty string is neither a valid date, nor
a NULL (the database server is more concerned about data types than PHP). Therefore we need to
supply manually the `null` value in case the `birth_day` is not filled. Luckily, the PHP `null` is nicely compatible
with the database `NULL`. Again it is very important that you understand what values originate from
where and what variables are connected:

{: .image-popup}
![Code schema -- Script for inserting data](/common/backend-insert/code-schematic.png)

## Task -- Extend the form
Now extend the form by adding other columns from the `person` table -- `gender` and `height`. Use proper
form controls for the values. Check whether each column is required and handle NULLs correctly if necessary.

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/backend-insert/person-add-sol.latte %}
{% endhighlight %}

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/backend-insert/person-add-sol.php %}
{% endhighlight %}

The radio buttons may be replaced by the `<select>` control.
The condition `(empty($data['gender']) || ($data['gender'] != 'male' && $data['gender'] != 'female'))`
could be also written as `(empty($data['gender']) || !in_array($data['gender'], ['male', 'female']))`.
The condition `(empty($data['height']) || empty(intval($data['height'])))` first checks that the value
`$data['height']` is defined and non-empty. Then it checks if the value converted to an integer
(using the [`intval` function](http://php.net/manual/en/function.intval.php)) is still not empty (i.e. non-zero).
In both conditions the order of conditional expressions is important. It must always start with the check
for an empty `$data` field due to [partial boolean evaluation](todo).

## Summary
In this chapter you have learned how to inset data from a HTML form into a database table. As usual there are multiple
options how you can implement the application logic -- especially the value validation (e.g. you could trigger
an error if height is not a number instead of ignoring it). When inserting data to the database, you need to
be aware of what values are optional and handle the optional values correctly.

### New Concepts and Terms
- Optional values
- NULL
