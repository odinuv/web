---
title: SQL injection 
permalink: /en/apv/articles/security/sql-injection/
---

* TOC
{:toc}

This article is about dangerous vulnerability which is often introduced by inexperienced or lazy programmers of web
applications. A good developer should always keep in mind weak spots of technology he is using and avoid them.
Some of those weaknesses are easy to spot and can be deduced easily when you take a while and think about them,
like basic [XSS](TODO) vulnerability. Some of them are a bit more trickier.

You can also read about SQL injection on [Wikipedia](https://en.wikipedia.org/wiki/SQL_injection).

Here is a funny comic strip from [XKCD](https://xkcd.com/327/) which you will fully appreciate after you read this
article and understand its contents. I hope that the motivation of understanding a geeky joke is enough to read and
remember everything written in following lines.

![Exploits of a Mom](https://imgs.xkcd.com/comics/exploits_of_a_mom.png)

## What is SQL injection -- how does it work and how do I know that my code is vulnerable?
SQL injection is a kind of backdoor into SQL interface. It is based on a fact, that SQL commands are passed to database
interface as *strings*. There is no difference between a string which you type in your *source code* (something like
`$db->query('SELECT * FROM person ORDER BY last_name');`) and a string which is *passed into your script from a form*
(or a random url parameter).

Everything depends on the treatment of strings and how you concatenate them into a final SQL statement. When everything
goes OK and your users behave in your application like you expect them to, nothing wrong can happen -- and that is
exactly the reason why a programmer unfamiliar with SQL injection may open a backdoor for attackers. Such person is
blind to weak spots because he is testing the application which he is developing in a way it should be used (or in
a way he expects the people to use it).

An attacker can easily guess SQL queries for particular functionality (like SELECTs or DELETEs) and send a string which
is actually a piece of SQL code that your program naively concatenates into a final query and that string is send
to your database.

Let's see and example for better understanding: following code is meant to load balance from an imaginary bank account
table (there are several types of bank accounts -- that is the purpose filter parameter taken from `$_GET`). The owner
of an account is securely stored in session data storage and cannot be changed easily. Suppose that an attacker wants to
see someone else's account balance.

{% highlight php %}
<?php
$id = $_SESSION['user']['id'];
$sql = "SELECT balance FROM bank_account " .
       "WHERE type = '" . $_GET['filter'] . "' AND owner = '" . $id . "'";
{% endhighlight %}

Note that compared column values in `WHERE` are enclosed in apostrophes `'` which denote SQL strings. Contrary,
from PHP's point of view, everything there is a string and variable containing string is being concatenated into
it. SQL syntax has no meaning for PHP interpreter -- it is really just a string.

The attacker first tests the presence of SQL injection vulnerability by fiddling with filter parameter:

    https://banking.insecure-app.com/account/balance?filter='
    
One of the easiest way is to pass an apostrophe into a query parameter. Let's see what happend on the backend.
This is the query which will be send to the database system (just a string for PHP interpreter):

    SELECT balance FROM bank_account WHERE type = ''' AND owner = '123'
    
This clearly yields into an SQL syntax error which is reported somehow (perhaps a fatal-error message). Failure of SQL
query is usually accompanied by an absolute failure to continue rendering of a page and sometimes a (when the attacker
is lucky) also with a trace of error and even part of SQL statement (this is usually disabled though). An open-source
software is in great disadvantage here because the attacker can study SQL queries directly in application's source code.

{: .note}
Be careful about error reporting, the more precise error reporting you have in production environment, the more
information an attacker gets. 

The attacker now knows, that there is a backdoor opened for him. He probably still does not know the precise
structure of the SQL statement but he can guess column or table names. He can try to pass something like this:

    https://banking.insecure-app.com/account/balance?filter=savings';#
   
Which will result in following SQL query, that gets account balances for **all** accounts in the database. This is
the SQL query after variable substitution:

    SELECT account_name, balance FROM bank_account WHERE type = 'savings';# AND owner = '123'
    
Inside the `$_GET['filter']` variable, the `'` delimits `type` column comparison value and the `;#` part simply tells
that everything behind it is a SQL comment (two dashes can be used too).

Now you should ask yourself:

- How can I avoid this?
- How do I distinguish between apostrophe which is important for query structure and apostrophe in data?
- More generally, how can I tell the SQL query interpreter, that particular apostrophe is merely part of data and
  has no meaning as a delimiter?
  
The answer is easy, you have to escape those unwanted apostrophes for every potentially dangerous substitution value.
Escaping means that you put a backslash in front of the apostrophe: `\'`. It is similar to [escaping](/en/apv/walkthrough/dynamic-page/#working-with-strings)
of apostrophes or quotes in PHP strings to prevent premature ending of string but it is interpreted on another
level -- database system level.

When you forget to sanitize strings from untrusted sources (i.e. visitors of your site or robots) you leave the SQL
injection backdoor opened.

{: .note}
You can see that the SQL injection depends heavily on SQL query structure. If the `type` and `owner` column parameters
were just in opposite order, an attacker would not gain such easy access to other users' data because there would be no
way to how to omit `owner` column comparison.

An attacker may also smuggle an entirely new SQL query using semicolon (semicolon is used to divide SQL statements). 
Fortunatelly PHP's database interfaces does not allow to send multiple SQL querries -- you have to use special functions,
e.g. [`mysqli_multi_query()`](http://php.net/manual/es/mysqli.multi-query.php) for basic MySQL.

## How does a vulnerable code look like and behave?
It is quiet easy to spot SQL injection vulnerability in ones code when you know what you are looking for. Have a look
at lines where SQL statements are defined and check for direct concatenation with variables (especially with `$_POST`,
`$_GET` or `$_COOKIE`). Here is another example of SQL injection. When you just pass numbers into the script,
everything goes smooth but try to pass `5 OR true` as POST's `id` parameter and you just deleted everything stored
inside the `person` table.

{% highlight php %}
<?php
$db = new PDO('...', 'login', 'pass');
if(!empty($_POST['id'])) {
    $db->query('DELETE FROM person WHERE id = ' . $_POST['id']);
}
{% endhighlight %}

The worst thing about SQL injection is that the code works OK when you pass "normal" values into the script.

{: .note}
You can suggest to use [`intval()`](http://php.net/manual/en/function.intval.php) function which would convert
such malicious input into a single zero. But you should rather avoid direct concatenation of variables into
SQL querries at all.

## How can I avoid SQL injection?
It is rather simple: always escape data from untrusted sources. Never pass raw input data into a SQL query. The PDO
interface's style of commands is not super-expressive but with those prepared statements and value binding you avoid
significant scurity risks (although you type much more letters). You can use some more syntax-efficient database
interface or ORM.

### Should I escape all incoming data?
Definitelly not! It might seem reasonable to escape everything that comes into the script via $_POST or $_GET
(and also $_COOKIE, data imported from other web services via API, files...) right in the beginnig of script
execution. But keep in mind, that SQL injection only affects SQL databases. Why would you escape data which
you just store in a text file, [Redis cache](https://redis.io/) or in $_SESSION? You cannot establish effective
escaping policy until you know what kind of database system you are using.

### What if I need to build complicated query? How do I escape one particular string?
Sometimes you need to build a query dynamically, for example when you need to build variable `WHERE` statement,
in that case you have to build SQL query string and setup value placeholders and remember their order of appearence.
PDO's separate [`quote()` method](http://php.net/manual/en/pdo.quote.php) may also be useful.

{% highlight php %}
<?php
$db = new PDO('pgsql:host=localhost;dbname=...', 'login', 'pass');
$filters = ['first_name', 'last_name', 'nickname']; //allowed column names
$sql = 'SELECT * FROM person WHERE ';               //beginning of query
$sep = '';
$actualFilters = [];
foreach($_GET['filter'] as $k => $v) {
    if(in_array($k, $filters)) {                    //$k is only an allowed value
        $sql .= $sep . $k . ' ILIKE ? ';            //use '?' as placeholder for variable
        $sep = ' AND ';                             //operator for next iteration
        $actualFilters[] = '%' . $v . '%';          //store replacement value
    }
}
$stmt = $db->prepare($sql);
$stmt->execute($actualFilters);                      //pass ordered array to repalce '?'
print_r($stmt->fetchAll());
{% endhighlight %}

Try to pass these URL parameters: `script.php?filter[first_name]=ka&filter[last_name]=os`. The SQL string which
is passed into `prepare()` method looks like this: `SELECT * FROM person WHERE first_name ILIKE ? AND last_name ILIKE ?`.
Those question marks are then replaced by values from `$actualFilters` array. The amount of question marks must match
length of `$actualFilters` array. Question marks in SQL query are replaced from left to right with values from
`$actualFilters` array.

{: .note}
Another way is to generate SQL query with ':something' kind of placeholders, than remeber the value and placeholder
in an associative array and then call `bindValue()` inside a loop driven by that associative array.

## Summary
SQL injection can be a nasty and unforgiving bug which you definitelly do not want in your code. **Escape values,
always**. You can use a database interface like PDO which does this for you, but you have to use it correctly.
Using PDO's `query()` method with direct PHP's variable concatenation is wrong practice. Now you can fully enjoy that
comic strip in the header section of this article.