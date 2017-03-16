---
title: Using Database in PHP
permalink: /en/apv/walkthrough/backend/
---

* TOC
{:toc}

In previous chapters, you have learned how to create [PHP scripts](/en/apv/walkthrough/dynamic-page/), and
in the latest chapter also how to 
[work with a database using the SQL language](/en/apv/walkthrough/database/).
In this chapter, you'll learn how to work with the database from within a 
PHP script. This is a very important step in connecting all the 
[technologies in the stack](todo) together.

## Getting Started
Before you start, you need to have working credentials to a database, and
you should have the [sample database](/en/apv/walkthrough/database/#database-schema) imported. Also you should be 
familiar with [creating and running a PHP script](/en/apv/walkthrough/dynamic-page/#getting-started).

To create an application which communicates with a database system, you 
always need some kind of a library. Database libraries are specific to 
the application language (PHP, Java, C++) and database (PostgreSQL, MySQL, ...),
so there are hundreds of them.

For PHP, there is a very good built-in library -- [PDO (PHP Database Objects)](http://php.net/manual/en/class.pdo.php), 
which is capable of communicating with multiple databases (including PostgreSQL and MySQL).

### Connecting to database
To connect to the database, you need to write a [DSN](http://php.net/manual/en/pdo.construct.php) connection string. This is 
done usually once, so it is not at all important to remember this. For PostgreSQL you should
use: 

    pgsql:host=SERVER_NAME;dbname=DATABASE_NAME

The *pgsql* is a [driver name](http://php.net/manual/en/ref.pdo-pgsql.connection.php).
For the [prepared PostgreSQL server](http://php.net/manual/en/ref.pdo-pgsql.connection.php), the 
connection string would be e.g.:

    pgsql:host=akela.mendelu.cz;dbname=xpopelka 

To create a database connection, create a new instance of the [`PDO` class](http://php.net/manual/en/class.pdo.php).
Provide the *DSN connection string*, *database username* and *password* in the constructor.

{% highlight php %}
<?php 

$db = new PDO('pgsql:host=akela.mendelu.cz;dbname=xpopelka', 'xpopelka', 'password');
{% endhighlight %}

### Selecting Data
To select data from the database, use the `query` method of the `PDO` connection object.
Supply a SQL [`SELECT`](/en/apv/walkthrough/database/#select) query as a string to the function. The function will
return a [`PDOStatement` object](http://php.net/manual/en/class.pdostatement.php). The `PDOStatement` 
represents an SQL query and
also its result. One way to obtain the result is calling the 
[`fetchAll` function](http://php.net/manual/en/pdostatement.fetchall.php). 

{% highlight php %}
{% include /en/apv/walkthrough/backend/select-simple.php %}
{% endhighlight %}

The `fetchAll` function returns a [two-dimensional array](/en/apv/walkthrough/dynamic-page/array/). It returns an array
of result table (`person`) rows. Each row is an array indexed by column keys, values 
are table cells. Therefore the following code will print `first_name` of the 
second person (as ordered by `first_name`). I used the [`print_r` function](http://php.net/manual/en/function.print-r.php) to
print the complete array (it's not beautiful, but it shall be good enough at the moment).

{% highlight php %}
{% include /en/apv/walkthrough/backend/select-simple-fetch.php %}
{% endhighlight %}

### Selecting Data with Parameters
You often need to provide dynamic values (obtained from PHP variables and/or HTML forms) to
the SQL queries. E.g. assume you need to run a query like this (where *Bill* is provided
by the end-user and stored in a PHP variable):

{% highlight sql %}
SELECT * FROM person WHERE first_name = 'Bill';
{% endhighlight %}

The solution is to use **prepared statements**. This means that you **prepare** a
SQL statement with **placeholders**, then **bind** values to the placeholders and
then **execute** the statement:

{% highlight php %}
{% include /en/apv/walkthrough/backend/select-prepared.php %}
{% endhighlight %}

In the above query, I have used a placeholder name `:name` (placeholder must start with colon `:`). 
Then I bind a value to it using the [`bindValue`](http://php.net/manual/en/pdostatement.bindvalue.php) 
method of the `$stmt` [`PDOStatement`](http://php.net/manual/en/class.pdostatement.php) 
object. Last, I [`execute`](http://php.net/manual/en/pdostatement.execute.php) the statement. 
Then the result can be printed as in the previous example. 

{: .note}
Parameters in SQL queries are **not** placed inside quotes. They will be added automatically
when the query gets executed. In PHP, the value of the parameter needs to be quoted as
any other string.  

{: .note}
If you are tempted to use the `$personName` variable directly within the SQL query string,
in the `query` method, don't do it! Such approach would introduce [SQL injection vulnerability](todo). 

### Inserting Data
Let's insert a new row in the `location` table. The principle remains the same as in the 
above example with the prepared statement. You just need to use the [`INSERT`](/en/apv/walkthrough/database/#insert) statement and
provide the right parameters to it: 

{% highlight php %}
{% include /en/apv/walkthrough/backend/insert-prepared.php %}
{% endhighlight %}

Note that there is no `fetchAll` call, because the `INSERT` statement does not return a table 
(or anything useful). Because working with prepared parameters can be a little bit tricky, you can
use the `$stmt->debugDumpParams();` function to print the SQL statement and actual values of parameters for
debugging purposes.  
   
{: .note}
I have named the keys in the `$location` variable the same way as the SQL placeholders (`:name`, `:city`, `:country`)
and also the same way as columns in the `location` table. This is not at all necessary, because these names
are totally unrelated. However, it reduces a lot of confusion to use consistent naming (also saves you a lot of time inventing 
new names).

### Error Control
An important part of communicating with the database is [handling errors](todo). There are 
[multiple options](todo), but the easiest way is to use [exceptions](todo). 
The following example extends the previous `INSERT` example with 
error handling.

{% highlight php %}
{% include /en/apv/walkthrough/backend/insert-error.php %}
{% endhighlight %}
 
The first important part is the line `$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);`
which makes the database driver switch into the mode in which it [*throws*](todo) an exception
whenever an error occurs in operations.

Second, I wrapped the whole code in a `try - catch` statement. As the name suggests, the code
inside `try - catch` is executed normally unless an exception occurs. Whenever an exception
occurs, the rest of the `try` code is skipped and the `catch` code is executed.
In the `catch` code I catch exceptions of the [`PDOException`](http://php.net/manual/en/class.pdoexception.php) 
class -- those are exceptions
thrown by the PDO database driver. The method `getMessage` of the exception object returns the
actual error message returned by the database.

The above `INSERT` statement can fail for many reasons, e.g.

- the database server is not available
- the database credentials are wrong
- the inserted values are not allowed in the table (e.g. are too long)
- there is something wrong with the database structure (e.g. a table does not exist)
- many others... 

Try to simulate some of the possible error conditions to make sure that the 
error handling is triggered correctly.

## Task -- Select Data
Select `first_name`, `last_name`, `nickname` of all persons. Order the persons by their
last names and first names (ascending). Make sure to use appropriate error handling.

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend/select-sol-1.php %}
{% endhighlight %}

Notice that I used two try-catch blocks, one for connecting to the database and one for the
actual query. This will become more useful in future, when we need to distinguish between 
errors in different parts of the code. In the first `catch` I have used the `exit` function to
terminate immediately the execution of the script. 

## Task -- Select Pattern
Select `first_name`, `last_name`, `age`, `height` of all persons, whose first name or last name 
begins with **L**. Order the persons by their
height and age (descending). Make sure to use appropriate error handling. I suggest you to approach 
the task in parts, first make a working SQL query, then add it to a PHP script.

{: .solution}
<div markdown='1'>
This was a little test whether you can [search for new stuff](http://bfy.tw/7HLc) --
Use the [AGE function](https://www.postgresql.org/docs/8.4/static/functions-datetime.html) in SQL.
The first person should be *Leonora Nisbet*.
</div> 

{: .solution}
{% highlight sql %}
SELECT first_name, last_name, nickname, AGE(birth_day) AS age, height 
		FROM person 
		WHERE first_name LIKE 'L%' OR last_name LIKE 'L%'
		ORDER BY height DESC, age DESC
{% endhighlight %}

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend/select-sol-2.php %}
{% endhighlight %}

{: .note}
I used an [alias](/en/apv/articles/sql-join/#aliases) in the SQL query to define a new 
name of the computed column. It is important to know
 the column name, because we need to reference it in the PHP script.      

## Task -- Print Data in HTML
A big task lies ahead of you. Print `first_name`, `last_name`, `nickname` and 
`age` rounded to years of all persons ordered by `last_name` and `first_name` (ascending).
Print the persons in a HTML table, one row each. Use a
[layout template](/en/apv/walkthrough/templates-layout/) for the HTML page. 
Again, approach the task in steps, e.g.:

1. Make a static HTML page with some sample data (skip this if you are confident with templates).
2. Make a PHP script to print the page using templates.
3. Make the data in the script dynamic -- load it from a variable, make sure the variable has the same 
format as obtained from the database. 
4. Write the SQL query to obtain the data you want.
5. Hook the SQL query into the PHP script.

### Step 1
Consult the [HTML guide](/en/apv/walkthrough/html/) if you are not sure.

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend/persons-static.html %}
{% endhighlight %}

### Step 2
Create a PHP script, a template and a layout template.

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend/persons-dynamic-1.php %}
{% endhighlight %}

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend/persons-dynamic-1.latte %}
{% endhighlight %}

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend/layout.latte %}
{% endhighlight %}

### Step 3
Define the persons to be displayed as an array in the PHP script, make 
sure the array has the same form as the one 
[returned from the database functions](/en/apv/walkthrough/backend/#selecting-data). 

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend/persons-dynamic-2.php %}
{% endhighlight %}

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend/persons-dynamic-2.latte %}
{% endhighlight %}

### Step 4
Write the SQL query and test that it works. 

{: .solution}
{% highlight sql %}
SELECT first_name, last_name, nickname, date_part('years', AGE(birth_day)) AS age 
FROM person
ORDER BY last_name ASC, first_name ASC
{% endhighlight %}

### Step 5
Modify the PHP script to load the variable from the database. 

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend/persons-list.php %}
{% endhighlight %}

No one is forcing you to take all the above steps separately or in the shown order. 
But **you must always be able to divide a complex task into simpler steps**. This
is really important -- the scripts will become only more and more complicated and there is really 
only one way to be oriented in all the code and debug it. You have to split it into smaller pieces, 
write and test the pieces individually. Notice how -- in the above steps -- I have changed only one thing
at a time. Some parts (like the template layout) don't need to be changed at all. However splitting
the code requires you to understand the connections between all the code parts:

{: .image-popup}
![Schema of variables](/en/apv/walkthrough/backend/code-schematic.png)

## Summary
In this chapter, you have learned how to use SQL queries from within a PHP script.
Non-parametric queries are quite simple (just call the `query` function). Parametric
queries are more complicated (`prepare`, `bindValue`, `execute` function calls).
Using proper error control adds further complexity to the script. However the error control
is very important, otherwise the application will misbehave in case an error condition occurs.
Because the entire application code is now becoming a bit complex, it is really important that
you are able to separate the code into individual parts and test each part individually.

### New Concepts and Terms
- Database Driver
- PDO/PDOStatement
- Prepared Statement
- Query Parameters
- Error Control
