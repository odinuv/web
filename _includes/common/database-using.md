
In previous chapters, you have learned how to create [PHP scripts](../backend-intro/), and
in the latest chapter also how to
[work with a database using the SQL language](../database-intro/).
In this chapter, you'll learn how to work with the database from within a
PHP script. This is a very important step in connecting all the
technologies in the stack together.

## Getting Started
Before you start, you need to have working credentials to a database, and
you should have the [sample database](../database-intro/#database-schema) imported. Also you should be
familiar with [creating and running a PHP script](../backend-intro/#getting-started).

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

~~~ php?start_inline=1
$db = new PDO('pgsql:host=akela.mendelu.cz;dbname=xpopelka', 'xpopelka', 'password');
~~~

### Selecting Data
To select data from the database, use the `query` method of the `PDO` connection object.
Supply a SQL [`SELECT`](../database-intro/#select) query as a string to the function. The function will
return a [`PDOStatement` object](http://php.net/manual/en/class.pdostatement.php). The `PDOStatement`
represents an SQL query and
also its result. One way to obtain the result is calling the
[`fetchAll` function](http://php.net/manual/en/pdostatement.fetchall.php).

{% highlight php %}
{% include /common/database-using/select-simple.php %}
{% endhighlight %}

The `fetchAll` function returns a [two-dimensional array](../backend-intro/array/). It returns an array
of result table (`person`) rows. Each row is an array indexed by column keys, values
are table cells. Therefore the following code will print `first_name` of the
second person (as ordered by `first_name`). I used the [`print_r` function](http://php.net/manual/en/function.print-r.php) to
print the complete array (it's not beautiful, but it shall be good enough at the moment).

{% highlight php %}
{% include /common/database-using/select-simple-fetch.php %}
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
{% include /common/database-using/select-prepared.php %}
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
in the `query` method, don't do it! Such approach would introduce [SQL injection vulnerability](/articles/security/sql-injection/).

### Inserting Data
Let's insert a new row in the `location` table. The principle remains the same as in the
above example with the prepared statement. You just need to use the [`INSERT`](../database-intro/#insert) statement and
provide the right parameters to it:

{% highlight php %}
{% include /common/database-using/insert-prepared.php %}
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
An important part of communicating with the database is handling errors. There are
[multiple options](http://php.net/manual/en/pdo.error-handling.php), but the easiest way is to use [exceptions](http://php.net/manual/en/language.exceptions.php).
The following example extends the previous `INSERT` example with
error handling.

{% highlight php %}
{% include /common/database-using/insert-error.php %}
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
{% include /common/database-using/select-sol-1.php %}
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
{% include /common/database-using/select-sol-2.php %}
{% endhighlight %}

{: .note}
I used an [alias](/articles/sql-join/#aliases) in the SQL query to define a new
name of the computed column. It is important to know
 the column name, because we need to reference it in the PHP script.

## Summary
In this chapter, you have learned how to use SQL queries from within a PHP script.
Non-parametric queries are quite simple (just call the `query` function). Parametric
queries are more complicated (`prepare`, `bindValue`, `execute` function calls).
Using proper error control adds further complexity to the script. However the error control
is very important, otherwise the application will misbehave in case an error condition occurs.

### New Concepts and Terms
- Database Driver
- PDO/PDOStatement
- Prepared Statement
- Query Parameters
- Error Control

### Control question
- Is it possible to connect to more than one database server?
- Why is it necessary to check for errors?
- Why use parameter binding?
- Is every query parametrized?
- Does every query have to return rows?