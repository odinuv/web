---
title: Databases – Technical Details
permalink: /articles/database-tech/
redirect_from: /en/apv/articles/database-tech/
---

* TOC
{:toc}

In previous articles you have learned about the common properties of
[relational database systems](/articles/relational-database/) and about the
[basics of the SQL language](/articles/sql-join/). Although all relational database systems (RDBS)
share the same principles and the SQL language is standardized, there is
a considerable amount of features which are specific for each database system.
In this article I will describe some differences between various database systems
and some advanced features of the (mostly PostgreSQL) database
system. I will also describe a little bit how a database systems works internally.

## Introduction
There is quite a lot of commonly used RDBS:

- [Adaptive Server Enterprise (SAP)](http://go.sap.com/product/data-mgmt/sybase-ase.html)
- [(IBM) DB2](http://www.ibm.com/analytics/us/en/technology/db2/)
- [Firebird](http://firebirdsql.org/)
- [MariaDB](https://mariadb.org/)
- [MySQL](http://www.mysql.com/products/community/)
- [Oracle Database](https://www.oracle.com/database/index.html)
- [PostgreSQL](https://www.postgresql.org/)
- [(Microsoft) SQL Server](https://www.microsoft.com/en-us/sql-server/sql-server-2016)
- [SQLite](https://sqlite.org/)

The above list is in no way exhaustive. To help you orient in the list a bit, I'll
try to characterize them briefly. There are some "big guys" -- SAP, DB2, Oracle
and MS SQL Server. Those are large enterprise databases, with hundreds of extensions
and features. They are also designed for big hardware (hundreds of GB of RAM) and
big data (thousands of tables, tables with [TB](https://en.wikipedia.org/wiki/Terabyte) sizes). These databases also
have quite complex configurations, which allows them to be tailored to customers needs.

Then there are "middle guys" -- MariaDb, MySQL, PostgreSQL (and maybe Firebird). Those are versatile
databases usable for many different applications. Then there are "small guys" --
SQLite (and maybe Firebird) -- those are databases for smaller applications. They
are often used as [embedded](https://en.wikipedia.org/wiki/Embedded_database) which means
that they are inherent part of some other application.

The above is only very rough categorization and it does not mean a
database cannot be used in another way. For example MySQL database has an
[embedded mode](https://www.mysql.com/oem/) too, but it is not as popular as SQLite which is part of most
[Android](https://developer.android.com/training/basics/data-storage/databases.html) systems,
therefore many applications on portable devices use SQLite.
Also for example [Facebook uses MySQL](https://code.facebook.com/posts/mysql/)
even though its database is far beyond what MySQL is commonly used for. And some
companies switch [back and forth](https://eng.uber.com/mysql-migration/).

From the "middle guys" MySQL and PostgreSQL are very popular systems. MySQL is
notable for its easy setup and great performance for writing data and simple
select queries. MariaDB is a true open source replacement for MySQL. It is almost 100%
compatible with it and it is [even developed by the same people](https://mariadb.org/about/).
PostgreSQL has a different approach, apart from being a database system it is
also a framework for creating database systems, which means that many other
databases are built upon its core
(e.g. [HP Vertica](http://www8.hp.com/us/en/software-solutions/advanced-sql-big-data-analytics/),
[Redshift](http://docs.aws.amazon.com/redshift/latest/mgmt/welcome.html)).
PostgreSQL also has very advanced extensions for [geographical databases](http://www.postgis.net/)
so it is often used in applications working with maps. PostgreSQL also has a pretty good
support for SQL standards, so that's one of the reasons I've chosen it for this book.

### Database Interfaces
To use a database system, you need an **interface**. There are probably thousands of them,
because each database has a different interface for a different programming language
(e.g. MySQL for C++, PostgreSQL for PHP, ...). Database interfaces are of two kinds:

- Proprietary -- These are usable only for a specific database system (MySQL, PostgreSQL),
with some exceptions (e.g. MySQL interface can be used to connect to MariaDB, because they
are compatible). These interfaces usually offer best performance and support all the
functions of the database.
- Generic -- These interfaces are usable for most databases, the database only provides
a **driver** to the generic interfaces. The generic interface offers only a limited set
of standardized functions (common to all databases). Notable examples are:

- [ODBC](https://en.wikipedia.org/wiki/Open_Database_Connectivity) -- The most generic interface supported across all platforms and programming
    languages.
- [JDBC](https://en.wikipedia.org/wiki/Java_Database_Connectivity) -- Generic interface for Java based applications.
- [PDO](http://php.net/manual/en/book.pdo.php) -- Generic interface for PHP based applications.
- [ADO.NET](https://en.wikipedia.org/wiki/ADO.NET) (successor of ADODB) -- Generic interface for .NET applications.

Every database interface has functions to:

- connect to a database (`connect` or constructor),
- execute a query (`exec`, `execute`, `prepare`),
- fetch a result of a SELECT query (`fetch`, `open`, `next`, `seek`) -- to work 
with a **resultset** (a table returned from a SELECT query)
- retrieve an error result (`error`, `lastError`).

Because there are so many interfaces and databases, you're on your own in finding the
right functions. But there is always some manual you should read.

## Data Dictionary
Data dictionary is a set of information describing meaning and relations between data.
In the area of database systems, this is simply the description of database structure
(database schema). This leads us to third important role of the SQL language (besides
retrieving and modifying data) -- reading and defining a database schema.

### Defining Database Schema
THe SQL language has special commands for defining the database structure. These are mainly
`CREATE`, `ALTER`, `RENAME`, `DROP`, `MODIFY`, `ADD`, ... commands. You have already seen
 a couple of those in the above examples.

{% highlight sql %}
CREATE TABLE table_name (
    column data_type [NOT NULL] [DEFAULT value] [PRIMARY KEY]
    [, column data_type ...]
)
{% endhighlight %}

For example:

{% highlight sql %}
CREATE TABLE contact (
    id_contact serial PRIMARY KEY,
    id_person integer NOT NULL REFERENCES person (id_person),
    id_contact_type integer REFERENCES contact_type (id_contact_type),
    contact character varying(200) NOT NULL
)
{% endhighlight %}

The commands for defining the database structure do depend on many proprietary implementation details
of the given database system -- for example data types or different approaches
to an automatically generated key. Also even within one database system, there
may be complex changes in behavior -- e.g. [MyISAM](http://dev.mysql.com/doc/refman/5.7/en/myisam-storage-engine.html) ×
[InnoDB](http://dev.mysql.com/doc/refman/5.7/en/innodb-introduction.html) storage
engines on the [MySQL database server](http://dev.mysql.com/doc/refman/5.7/en/).
It is therefore the best to use a [good tool](/course/not-a-student/#text-editor-or-ide) for designing the database,
which is also capable of generating the correct SQL queries for you.

SQL statements for defining the database schema are also often used for importing and exporting
databases. Keep in mind however, that due to differences between various database servers,
these database exports should not be used for migrating your database between different databases.
Use specialized [migration tools](https://en.wikipedia.org/wiki/Schema_migration) for that.

### Querying Database Schema
The structure of every database is stored inside another database --- `information_schema`.
The `information_schema` database is shared for all users and every user can use it
to access database schemas of all databases he has access to. The `information_schema` database
is read-only and while always present is not usually shown in a client interface.

The `information_schema` database contains full schema description -- table and columns names
are most commonly used, but integrity constraints and indexes are also present. To
see what is available, you can view the list of tables in `information_schema` by
invoking:

{% highlight sql %}
SELECT * FROM information_schema.tables WHERE table_schema = 'information_schema'
{% endhighlight %}

From here you can continue to specific tables, e.g. to obtain a list of columns for
the `person` table, you would run:

{% highlight sql %}
SELECT * FROM information_schema.columns WHERE table_name = 'person'
{% endhighlight %}

Apart from the `information_schema` database, there are also special
SQL commands like `DESCRIBE` and `SHOW` to describe the database structure. But is is much
easier to use ordinary `SELECT` and the `information_schema` database. The fact that the
database structure can be queried easily means that it is not difficult to create
highly dynamic applications. In such an application, the lists and forms can accommodate to
columns defined in the database which may be reconfigured by altering the database structure.

## Data Types
One of the core differences between database servers are names of data types. while
the names differ, it is usually possible to find an equivalent type.

### Strings
- character_varying(size) / varchar(size) / nvarchar(size):
    - standard string limited by size (thousands of characters),
    - size in bytes for [Single-byte character strings](https://en.wikipedia.org/wiki/SBCS) (no Unicode support),
    - size in characters for [Multi-byte character strings](https://en.wikipedia.org/wiki/Variable-width_encoding)
    ([Unicode](https://en.wikipedia.org/wiki/Unicode) support);
    - **use this one if unsure**.
- char(size) / character(size) / nchar(size):
    - string limited by size,
    - filled with spaces, not very useful, do not use it,
    - `LIKE` compares without spaces.
- text / ntext
    - "unlimited" string,
    -  allows to have cell size in gigabytes,
    - cannot be [indexed](/articles/database-tech/#index),
    - use this type only if varchar does not suffice

### Whole Numbers
- integer --- number occupies 4 bytes -- -2<sup>31</sup>..2<sup>31</sup>
    - 2<sup>31</sup> = 2 147 483 648
    - **use this one** if you are unsure.
- bigint --- number occupies 8 bytes -- -2<sup>63</sup>..2<sup>63</sup>
    - 2<sup>63</sup> = 9 223 372 036 854 775 808
- smallint --- number occupies 2 bytes -- -2<sup>15</sup>..2<sup>15</sup>
    - 2<sup>15</sup> -- 32 768

There is a catch for integers, they can be either:

- [`signed`](https://en.wikipedia.org/wiki/Signedness) (with sign) --- allows negative numbers,
- `unsigned` (without sign) --- allows only positive numbers.

Make sure not to combine them! An unsigned integer has a different
range (e.g. 0..2<sup>32</sup> --- 0..4 294 967 295). Because both types
have the same internal
[binary representation](https://en.wikipedia.org/wiki/Binary_number#Conversion_to_and_from_other_numeral_systems),
it means that e.g. a signed integer with value -1 has the same
[physical representation](https://en.wikipedia.org/wiki/Binary_number#Counting_in_binary) as the
unsigned (32 bit) integer 4 294 967 295.

### Decimal Numbers
- `real` / `float` / `double`:
    - floating point decimal point;
    - real range 1e<sup>-37</sup>..1e<sup>37</sup>
    - double range 1e<sup>-307</sup>..1e<sup>308</sup>
- `number` / `numeric` / `decimal(precision, scale)`:
    - fixed decimal point;
    - precision --- maximum number of digits;
    - scale --- number of digits after decimal point.
- `money` -2<sup>63</sup>..2<sup>63</sup> = 92 233 720 368 547 758.08

There are two basic types of decimal numbers (generally used in computing).
Decimal numbers with a [floating decimal point](https://en.wikipedia.org/wiki/Floating_point) 
and decimal numbers
with a [fixed decimal point](https://en.wikipedia.org/wiki/Fixed-point_arithmetic). The advantage of floating-point decimal
numbers is that they have very variable ranges -- e.g. you can store a number
such as `123456789.12` as well as `0.123456789012`. The disadvantage of
floating point numbers is that their representation is not exact.
This means for example that  `4.0 / 2.0 != 2.0` -- i.e. `4.0 / 2.0` is not equal to
`2.0` but to something like `2.00000000001`. Fixed point decimal numbers
do not have this un-intuitive behavior, but their range must be specified
in the column type. E.g. a column with type `decimal(5,3)` can store numbers
up to `99 999.999`. A number `100 000` would cause an overflow. A
number `1.12345` would be rounded to `1.123`.

### Date and Time
Date and time is stored as a [**timestamp**](https://en.wikipedia.org/wiki/System_time) 
format. A timestamp is stored as a number of milliseconds / microseconds from some
arbitrary date (1.1.1970 for [**unix timestamp**](https://en.wikipedia.org/wiki/Unix_time)). This format is used
because it is a reference to an unambiguous point in time. The range of
the timestamp varies for various databases, but e.g. in PostgreSQL it
is 4713 BC to 294276 AD (with precision to microseconds).

Timestamp format is quite useless on its own, because it is simply a
number of some units from an arbitrary point in time. The conversion
to a date string (`2014-12-22`) is a **very complex** operation.
A word of caution -- never attempt to do this conversion yourself, always
use the functions provided by the database. These functions count with
all the oddities of the human date system such as timezone, leap days, leap seconds,
[DST](https://en.wikipedia.org/wiki/Daylight_saving_time)...

Also you should never assume anything about dates and times. A typical
*wrong* assumption is that an hour has 3600 seconds. Although it
is valid for many hours during a year, it is invalid for hours with
leap second and invalid for hours during with [DST](https://en.wikipedia.org/wiki/Daylight_saving_time) changes
(then there is one hour with 0 seconds and one hour with 7200 seconds).

A timestamp does not allow to store incomplete dates -- e.g. 'January 2016'
because it does not refer to an unambiguous single point in time. A timestamp
also cannot be used to store time intervals (12:30 -- 13:00) for the same
reason.

You can use the following data types in a database system: `datetime` / `date` / `time` / `timestamp`.
All of them are implemented as some kind of a timestamp, so they
share its behavior. Then there is a special type `interval` used to
store an interval of date-time values.

#### Alternatives
You may encounter using native application format in which the column data type is the integer
and the application stores the data in the timestamp of the application. In PHP this
would be implemented like this (using [`time()`](http://php.net/manual/en/function.time.php) function):

~~~ php?start_inline=1
$db->execute(
    "UPDATE person SET birth_day = :birthDay",
    [':birthDay', time()]
);
~~~

The above approach is simple and works for one application without problems.
However I would discourage you from using this approach. As the application
grows, you will run into problems caused by the fact that it is non-atomic (
[1NF](/articles/database-design/#first-normal-form)), which
means that it is impossible to select a part of the date as well as impossible to 
store or compute the interval. It brings back
[application and database dependency](/articles/database-systems/#integrated-information-system).
And it is therefore unreliable when more applications use the database.

### Binary Data
It is also possible to store binary data in a database. This is useful for storing
binary data which is naturally a part of a database record -- for example
a profile photo as a part of the user profile record. Although this is commonly solved by
storing binary files in the file system, I wouldn't recommend this approach.
Storing binary data in the file system makes it more complicated to ensure its security
and it also makes it more difficult to ensure data consistency. Available data
types for binary values:

- bit / boolean / binary / bytea -- a single value,
- BLOB / image -- binary data (BLOB -- Binary Large Object; LOB, LO also used).

Details of working with LO are dependent on the database interface. You can either send the escaped
data within the SQL string (the size is limited to megabytes). If it cannot be used, you have to
send binary data to the database via special functions.

## Automatically Generated Key
An automatically Generated key is the most commonly used type of
the [primary key](/articles/relational-database/#key-types). It
is an abstract record identifier independent on outside conditions. The automatically
generated key is called **auto-increment** or **sequence**. It is simpler to use than
compound keys (in which all parts must be used). For historical reasons
no database system follows the SQL standard fully.

### Auto-increment in PostgreSQL
To create an auto-incrementing key in PostgreSQL you need to create it with
a special data type `serial`. E.g.

{% highlight sql %}
CREATE TABLE relation_type (
    id_relation_type SERIAL NOT NULL PRIMARY KEY,
    name CHARACTER VARYING(200) NOT NULL UNIQUE
);
{% endhighlight %}

When a table is created with the `serial` data type, it automatically creates
a **sequence** to generate the values and assigns a default value to
that column `nextval('relation_type_id_relation_type_seq')`. A sequence is a *database object* (like table, column ...)
which can be used to generate a sequence of numbers. It maintains current number of the sequence.
The name of the sequence `relation_type_id_relation_type_seq` is automatically generated.

To obtain the value of `id` after a row has been inserted into the table,
you have to run the following query:

{% highlight sql %}
SELECT currval('relation_type_id_relation_type_seq')
{% endhighlight %}

`currval` is a database function which obtains CURRent VALue of a database sequence.
Or use the following code in PHP (using [PDO](http://php.net/manual/en/book.pdo.php)):

~~~ php?start_inline=1
...
$db->lastInsertId('relation_type_id_relation_type_seq');
...
~~~

Which will essentially run the above SQL query.
When you insert a row with an automatically generated key, you don't provide the column
in the SQL `INSERT` statements. This means that a default value of the column will
be used, which is `nextval('relation_type_id_relation_type_seq')`. The `nextval` function will increment
the last number of the sequence and return the new value. This value will be inserted
in the row of `my_table`. The `currval` function will return the current value
of the sequence (without modifying it). In the above example, the `lastInsertId` function of
the PDO PHP library essentially runs the `SELECT currval` query.

Note that there are few catches in the above system. A minor one is that if you create a table with
the `SERIAL` data type, and then export the table from the database (e.g. to move the database
to another server), it will be exported as an `INTEGER`. This is no big deal, because the
sequences will be exported too and everything will work as expected.
A bigger catch is that should never explicitly state a value of the auto-generated key.
If you run a query:

{% highlight sql %}
INSERT INTO relation_type (name) VALUES ('new type');
{% endhighlight %}

The database system will automatically assign e.g. the value 10 to the `id_relation_type` of `new type`.
If you then run:

{% highlight sql %}
INSERT INTO relation_type (id_relation_type, name) VALUES (11, 'another type');
{% endhighlight %}

The above query will insert the value 11 in the `id_relation_type` column, but it will 
not update the sequence! 
When you then run a query:

{% highlight sql %}
INSERT INTO relation_type (name) VALUES ('yet another one');
{% endhighlight %}

You will receive an error:

    ERROR:  duplicate key value violates unique constraint "relation_type_pkey"
    DETAIL:  Key (id_relation_type)=(11) already exists.

The only way out of this situation is to alter the sequence to
a higher value manually:

{% highlight sql %}
SELECT pg_catalog.setval('contact_type_id_contact_type_seq', 12, true);
{% endhighlight %}

### Auto-increment in MySQL
In the MySQL database server, you would create a table with an auto-incrementing key
via:

{% highlight sql %}
CREATE TABLE relation_type (
    id_relation_type INTEGER NOT NULL AUTO_INCREMENT,
    name CHARACTER VARYING(200) NOT NULL,
    PRIMARY KEY (id_relation_type),
    UNIQUE (name)
)
{% endhighlight %}

In the PHP application code, you can obtain the last value inserted to `id_relation_type` by
calling:

~~~ php?start_inline=1
...
$db->lastInsertId();
...
~~~

The PDO [`lastInsertId` function](http://php.net/manual/en/pdo.lastinsertid.php) takes
case of the differences between PostgreSQL and MySQL servers.
In MySQL, the function to obtain the last inserted ID is named
[`LAST_INSERT_ID()`](http://dev.mysql.com/doc/refman/5.7/en/information-functions.html#function_last-insert-id).
Also there are no sequences, which means that the function takes no argument:

{% highlight sql %}
INSERT INTO relation_type (name) VALUES ('new type');
SELECT LAST_INSERT_ID();
{% endhighlight %}

The basic principle is the same as in the PostgreSQL database server, there are few minor
differences. In MySQL, the `LAST_INSERT_ID` always refers to
the last insert (as opposed to PostgreSQL where it refers to the last insert to a particular table).
Also in MySQL you can insert the auto-generated value manually and the sequence will automatically
pick up the highest value (as opposed to PostgreSQL where you need to alter the sequence manually).

### Currval / LAST_INSERT_ID or Max?
Now you probably think that this entire 'sequence' business is unnecessarily complex,
because you can simply select the maximum id from a table to obtain the id of the
last inserted row.

{% highlight sql %}
SELECT MAX(id_contact_type) FROM contact_type;
{% endhighlight %}

Well, no, you can't. Although the automatically generated key is a raising sequence of
numbers, it **does not necessarily mean** that the highest number belongs to the last row.
The difference occurs when multiple users use the application (which is quite normal).
In that case, it is possible that between the queries:

{% highlight sql %}
INSERT INTO relation_type (name) VALUES ('yet another one');
SELECT MAX(id_contact_type) FROM contact_type;
{% endhighlight %}

Another user will run her own `INSERT` query. Your `SELECT MAX` query will then
return her record id (the highest one). Your application instance will then
continue to work with the wrong record. This leads to very serious errors. For example, if you
have two users are inserting persons and then meetings for those persons, the above situation will lead to:

- user A inserted person John
- user B inserted person Leon
- user A obtained ID of Leon (wrong)
- user A inserted meetings for John to Leon (wrong)
- user B obtained ID of Leon (right)
- user B inserted meetings for Leon to Leon (right)
- John has no meetings
- Leon has meeting of both John and Leon

The graph below shows this scenario in more detail:

{: .image-popup}
![Request and insert concurrency](/articles/database-tech/insert-concurrency.svg)

You may think that such a scenario is almost
impossible --- the queries run in fraction of seconds. What is the chance that this might occur?
The truth is that this may
happen quite easily as many applications have peaks of usage (the operations in the
applications are not distributed evenly over time). For example on
[booking.com](http://www.booking.com/) you can see something like '19 people are looking at this right now'.
Now you can see the possibility that two of them click the 'buy' button roughly at the same time, 
can't you?

This scenario is called [**race condition**](https://en.wikipedia.org/wiki/Race_condition#Software). It is a
general problem which may occur in any
[concurrent (i.e. parallel) operations](https://en.wikipedia.org/wiki/Concurrent_computing). The nature
of the race condition is random, so it means that
it leads to sparse errors which are really difficult to trace. The fact that the code works
you, does not mean that it is correct! Ensuring that your code does not suffer
from the race condition is also called ensuring 
[**thread safety**](https://en.wikipedia.org/wiki/Thread_safety).

The `currval` function (or any of its alternatives) as [described above](#auto-increment-in-postgresql) does not suffer from a race condition:

{% highlight sql %}
INSERT INTO relation_type (name) VALUES ('yet another one');
SELECT CURRVAL('relation_type_id_relation_type_seq');
{% endhighlight %}

The Currval function (and the sequence) have a special property -- it remembers
the last value for current database connection. This for example means that
if you want to use that function in an
[web admin interface](/walkthrough-slim/database-intro/#getting-started), you have to
put both queries together. Otherwise -- if you run the INSERT query, and then
run the SELECT query -- you will obtain the following error:

    ERROR:  currval of sequence "relation_type_id_relation_type_seq" is not yet defined in this session

This is because by pressing the 'Execute' button twice, you actually created two
unrelated HTTP requests for the admin application. Each of them uses its own connection to
the database, therefore the `currval` function has no INSERT query to relate to.

#### Alternatives
The PostgreSQL database has a nice extension to SQL INSERT -- the `RETURNING` statement:

{% highlight sql %}
INSERT INTO person (first_name, last_name, nickname)
VALUES ('John', 'Doe', 'Johhny')
RETURNING id_person;
{% endhighlight %}

It makes the insert query return the value of the `id_person` for the inserted
row. You therefore have to use the following code in PHP (assuming that `$db` is
[PDO](http://php.net/manual/en/book.pdo.php) instance):

~~~ php?start_inline=1
$stmt = $db->prepare(
    "INSERT INTO person (first_name, last_name, nickname)
    VALUES (':first_name', ':last_name', ':nickname')"
    RETURNING id_person;
);
$stmt->bindValue(':first_name', 'John');
$stmt->bindValue(':last_name', 'Doe');
$stmt->bindValue(':nickname', 'Johnny');
$stmt->execute();
$id = $stmt->fetch()['id_person'];
~~~

This approach can be used only on the PostgreSQL database server, however.
Another alternative is to use another key of the table:

{% highlight sql %}
INSERT INTO person (first_name, last_name, nickname)
    VALUES ('John', 'Doe', 'Johhny');
SELECT id_person WHERE first_name = 'John' AND last_name = 'Doe' AND
    nickname = 'Johhny';
{% endhighlight %}

Because the combination of the `first_name`, `last_name` and `nickname` columns is a
[key](/articles/relational-database/#key), you can be sure that you
select the `id_person` of the correct row.
This approach is reliable, but can be used only on tables where
another key besides the automatically generated one is present. Also it is
quite annoying to have to repeat all the columns and their values.

## Integrity Constraints
[Integrity constraints](/articles/database-systems/#data-integrity) are a
crucial part of the database structure. There are
many extensions on different database systems, but common integrity constrains are:

- Basic ones on a single table:
    - `NOT NULL` -- Ensures that a column has a non empty value.
    - `UNIQUE (KEY)`, `PRIMARY (KEY)` -- Ensures that a column (or combination of columns) has a unique value.
    - `CHECK` -- Ensures arbitrary rules.
- Referential:
    - `FOREIGN KEY` -- Ensures that a dependency between tables is maintained.

The `NOT NULL` constraint ensures that a value of a column is not `NULL`. Practically this
enforces that the column must be listed in all `INSERT` statements (unless a default value
of a column is defined). You must understand, this does not prevent the user from
entering some *almost* empty values -- an empty string, zero, 00:00, etc. This means that there
is very little difference in having `NOT NULL` on string columns. Using `NOT NULL` is
important mainly for the number and the date/datetime columns, because of the
[NULL arithmetic](/articles/sql-join/#null). If you want to ensure that
a column contains a specific value, you need to use the `CHECK` constraint.

### CHECK Constraint
A [`CHECK` constraint](https://www.postgresql.org/docs/9.4/static/ddl-constraints.html)
allows you to add extended validation to a column. For example, the `height` column has
the `integer` type, but only positive integers are valid height. For that I have added the
`height_check` constraint in the `person` table:

{% highlight sql %}
CREATE TABLE person (
    id_person integer NOT NULL,
    nickname character varying(200) NOT NULL,
    first_name character varying(200) NOT NULL,
    last_name character varying(200) NOT NULL,
    id_location integer,
    birth_day date,
    height integer,
    gender gender,
    CONSTRAINT height_check CHECK ((height > 0))
);
{% endhighlight %}

When you try to insert a row with negative height:

{% highlight sql %}
INSERT INTO "person" ("nickname", "first_name", "last_name", "height")
    VALUES ('John', 'Doe', 'Johnny', '-2')
{% endhighlight %}

You will get the following error:

    ERROR:  new row for relation "person" violates check constraint "height_check"
    DETAIL:  Failing row contains (55, John, Doe, Johnny, -2).


### Foreign Key Constraint
The foreign Key Constraint maintains [relationships](/articles/database-design/#e-r-modeling)
between entities (rows) in tables. It means that it is not possible to UPDATE / DELETE a record in
the [master table](/articles/relational-database/#foreign-key) while ignoring the dependent records
in the [child table](/articles/relational-database/#foreign-key). In this case, `UPDATE` 
refers only to the link value change. Because this is usually a value of a primary key (which usually
does not change) it is not very common.

Foreign keys are more often used together with the `DELETE` operation. There are three
possible behavior settings:

- `RESTRICT / NO ACTION` -- This is the default behavior -- don'y allow to delete a
row in the master table if there are any rows dependent on it.
- `CASCADE` -- When deleting a record in the master table, delete the dependent rows in the child
table too.
- `SET NULL` -- When deleting a row in the master table, remove the reference from all
child rows -- i.e. cancel the relationship.
- `SET DEFAULT` -- When deleting a row in the master table, put in a default relationship.

The decision which behavior should be used depends on the application requirements and
is usually different for each individual relationship. I can demonstrate it on the
[sample database](/walkthrough-slim/database-intro/#import-database).

### Foreign Key -- Cascade Example
Look at the following excerpt of the `person` and `contact` table.

| `person`                           |
| id\_person | name   | id\_location |
|------------|--------|--------------|
| 1          | John   | 11           |
| *2*        | *Karl* | *12*         |

| `contact`                                |
| id\_contact | contact        | id_person |
|-------------|----------------|-----------|
| *21*        | *karl@doe.com* | *2*       |
| *22*        | *carl@doe.com* | *2*       |
| 23          | john@doe.com   | 1         |

What if you issue the following DELETE command:

{% highlight sql %}
DELETE FROM person WHERE id_person = '2'
{% endhighlight %}

You should normally receive the following error:

    ERROR:  update or delete on table "person" violates foreign key constraint "person_meeting_id_person_fkey" on table "person_meeting"
    DETAIL:  Key (id_person)=(2) is still referenced from table "person_meeting".

That means the foreign key **constraint** kicked in and protected your database from breaking
its integrity. So although this is an error, it is a good thing. You cannot have contacts
which do not belong to any person. In this case it probably makes sense to delete the contacts
as well. The solution to this is to set the foreign key constraint to the **cascade**:

{% highlight sql %}
ALTER TABLE ONLY person_meeting
    DROP CONSTRAINT person_meeting_id_person_fkey;
ALTER TABLE ONLY person_meeting
    ADD CONSTRAINT person_meeting_id_person_fkey FOREIGN KEY (id_person) REFERENCES person(id_person) ON DELETE CASCADE;
{% endhighlight %}

{: .note}
Be sure to check the name of the foreign key constraint before you run the
above queries. The above corresponds to the default state of the
[sample database](/walkthrough-slim/database-intro/#import-database).

Or when creating a new table, you would do it like this:

{% highlight sql %}
CREATE TABLE contact (
    id_person integer NOT NULL
        REFERENCES person (id_person) ON DELETE CASCADE,
    ...
)
{% endhighlight %}

When the foreign key is set to cascade and you delete a record in the
[master table](/articles/relational-database/#foreign-key),
the database will automatically delete all child records.
I.e. when deleting from `person` table `id_person=2`, contacts depending on
that row (having `id_person=2`) will be deleted too.

### Foreign Key -- Set Null Example
Now look at the following excerpt from the `person` and `location` tables:

| `person`                         |
| id\_person | name | id\_location |
|------------|------|--------------|
| 1          | John | *11*         |
| 2          | Karl | 12           |

| `location`                         |
| id\_location | city  | street      |
|--------------|-------|-------------|
| *11*         | *Ulm* | *Abbey Rd.* |
| 12           | Linz  | Left Rd.    |

What if you want to delete `location` with ID 11? There is a record in the `person`
table with 1, which depends on it -- Here the master table is `location` and the child
is `person`. You probably don't want to delete that person as well
(When demolishing a house you usually let the people walk outside). The
most logical is simply removing the reference -- if an address is lost, we simply
don't know where the person lives/works now. This can be done by setting the
foreign key to `SET NULL`.

{% highlight sql %}
ALTER TABLE ONLY person
    DROP CONSTRAINT person_id_location_fkey;
ALTER TABLE ONLY person
    ADD CONSTRAINT person_id_location_fkey FOREIGN KEY (id_location) REFERENCES location(id_location) ON DELETE SET NULL;
{% endhighlight %}

{% highlight sql %}
CREATE TABLE person (
    id_location integer NOT NULL
        REFERENCES location (id_location)
        ON DELETE SET NULL,
    ...
)
{% endhighlight %}

Now when you try to delete the row with `id_location=11` from the `location` table,
the value `11` in the `person.id_location` column is set to NULL.

### Delete or hide?
Sometimes you may wish to access "deleted" information even after you have removed it. 
It might be helpful in our app just to hide persons we do not want to see in the 
person list and still be able to display such persons participation in past meetings. 
To achieve this behaviour you should add a column (e.g. `deleted`, data-type of this
column can be `datetime` with the possibility of a NULL value --- NULL means that 
a person is not deleted and date and time can be used to store time when that 
person was deleted). Then you should update your
SQL queries which retrieve persons from the database according to your needs.

### Deleting Records Summary
In general, deleting records from the database is an uneasy task; use
these rules to help you out:

- use `SET NULL` or `SET DEFAULT` where a link can be lost,
- use `CASCADE` where related records can be lost,
- use `RESTRICT` in all other cases.

Unfortunately, most real-world situations fall in the last category. When
working in an information system, it is usually necessary to keep all historical
information even if they were supposed to be deleted. Consider for example an
e-shop, where a customer (John.Doe@example.com) wants to terminate his account.
You cannot physically delete that account, because you will loose all operations
the customer did (when he ordered and payed something) and his orders and
invoices etc. So rather than that, you should only disable the account John.Doe@example.com
or mark it as deleted. Now what will you do if users log-in to your system via email and now
when you have disabled the account someone wants to open a new account with the
same e-mail (John.Doe@example.com)? Should you refresh that account or create
a new one (suppose it is a company email and a different person)?

And all that was a simple deletion. They may be more complicated business
requirements. For example a company can have cars or machinery and requires
that someone is always responsible for them. What if the responsible person
leaves the company? If `SET DEFAULT` is not enough, a rule must exist to select a new person responsible
for the machinery and this must be done programmatically in the application code.
All the above situations are quite real and they present a challenge
in good [database design](/articles/database-design/). A good database design allows you to
[keep historical data](http://clarkdave.net/2015/02/historical-records-with-postgresql-and-temporal-tables-and-sql-2011/),
but that is far beyond the scope of this book.

## Index
By now, you should be familiar with several types of **database objects**:
*database* and *schema*, *table* and *view*, *column*,
[*sequence*](/articles/database-tech/#auto-increment-in-postgresql). There
are other types of database objects - such as
[*index*](https://en.wikipedia.org/wiki/Database_index), *function*
(sometimes referred to as
[UDF](https://en.wikipedia.org/wiki/User-defined_function) -- User-Defined Function),
[*triggers*](https://en.wikipedia.org/wiki/Database_trigger) and some other
more advanced objects.

Although working with **indexes** (or indices) falls the into category of advanced database
stuff, you should have a general idea what an **index** is. The main purpose
of an index is to speedup reads -- SELECT statements. There are
different techniques of implementing indexes. The most basic one is
[ISAM](https://en.wikipedia.org/wiki/ISAM) (Index Sequential Access Method).
When using ISAM, the actual data in a database table are physically stored
in a **data file** which allows
[sequential access](https://en.wikipedia.org/wiki/Sequential_access) (that is a normal file
on a hard drive). Additionally to that, an **index file** is created which
links to specific positions in the *data file* and allows
so called [random access](https://en.wikipedia.org/wiki/Random_access).

For example, let's say you have the following `person` table:

| first\_name | last\_name | birth_day  | id |
|-------------|------------|------------|----|
| John        | Doe        | 2001-10-20 | 1  |
| Billy       | Rae        | NULL       | 2  |
| Jenny       | Doe        | 1960-15-09 | 4  |
| Gina        | Rae        | NULL       | 5  |

The *data file* would be ordered as you see it above -- by the
record id -- as the rows were inserted into the table. Now this means
that if you want to find a row with `first_name = 'Gina'`, you have to
go through the entire *data file*. It is important to note that the
*data file* grows with the data in the table and it may very well exceed
hundreds of gigabytes. To avoid reading through all that you can create
an index file (on column `first_name`):

| first_name | position |
|------------|----------|
| Billy      | 22       |
| Gina       | 53       |
| Jenny      | 36       |
| John       | 0        |

The index file contains values of the `first_name` column, but they
are ordered by that column. Each value has a position
([pointer](https://en.wikipedia.org/wiki/Pointer_(computer_programming)))
to the physical position of the full record in the *data file*.

When an index is created, the read operation can be speedup considerably.
When looking for `first_name = 'Gina'`, the database system needs only to
go through the *index file*. The index file is orders of magnitude smaller than
the *data file* -- so it's ten or at most hundreds of megabytes large.
Plus -- because it is ordered -- the search can be optimized. This means that finding
the record in the index is a matter of microseconds. When a record is found in the index,
the database will pickup its physical position in the *data file* -- this again
is a very fast 
[seek](https://en.wikipedia.org/wiki/Hard_disk_drive_performance_characteristics#SEEKTIME) operation.

There are many different implementations of the index system. The one described above
corresponds to a very primitive [hash table](https://en.wikipedia.org/wiki/Hash_table). 
Another type of the index is for example [B-Tree](https://en.wikipedia.org/wiki/B-tree).
Regardless of the actual implementation of the index
mechanism, there are some common properties to indexes.

#### Index Properties
Now you probably think --- why can't I simply create an index on every column and
stop worrying? There are many reasons for that.

What if in the above example, the condition is `first_name = 'Gina' AND last_name = 'Rae'` ?
In that case, the index on the `first_name` column can be anything from good (in case 'Gina' is
the only one named 'Rae') to completely useless (in case everyone in the database is named 'Gina').
In practice, this means that indexes have to be created on different combinations of
columns.

Creating an index has two major drawbacks -- it occupies *some disk space*, and
it *slows down modifications* of the data. When a row is updated in the database, all
indexes referring to the changed values have to be updated and possibly resorted. The larger the
indexes are and the more there are, the more costly the `INSERT`, `UPDATE`, `DELETE` operations are.

This means that an index should be created on:

- Keys -- this is usually done automatically by the database server.
- Columns used in JOINs -- they should have foreign keys defined, so again usually done by the database server.
- Columns used often in `WHERE` clauses -- these often fall in the above categories.

An example of the last category is e.g. searching by the date within a table with reservations. It is
a typical operation, yet the date column is not part of the primary or unique key, nor the foreign key.
So this may be a good candidate for an index.

All the stuff about indexes is pretty complex, but you should be aware of the fact that such a feature exists
and what it is good for. A good rule of thumb is that you should create an index only when
you have a performance problem (otherwise by creating an index blindly you might actually create a performance problem).
When you do so, be sure to verify that the index is really used.

### Explain 
The command to shed a light on those operations is the `EXPLAIN` command. `EXPLAIN` can be
used for example to determine if a query uses an index or not. Reading and understanding
the `EXPLAIN` command is non-trivial and falls to the complex problem of query optimizations.

### Execution Plan
An **execution plan** describes the procedure
generated by the SQL [interpreter](/articles/programming/) to obtain the data you want to select.
Remember that SQL is a [declarative language](/articles/relational-database/#sql-language).
Via SQL you tell the server **what** to do,
but you don't tell it **how** to do it. That *how* is the *execution plan*.
Different SQL queries (returning same results) may use different executions plans and therefore
different performance. Also same queries executed on different database servers may lead to
different execution plans. You can see an execution plan of a query by using
[`EXPLAIN`](https://www.postgresql.org/docs/9.4/static/using-explain.html) or (`EXPLAIN ANALYZE`). For example:

{% highlight sql %}
EXPLAIN ANALYZE
    SELECT * FROM person JOIN contact
        ON person.id_person = contact.id_person
    WHERE person.first_name LIKE 'K%'
{% endhighlight %}

Will give you something like this:

    QUERY PLAN
    Hash Join  (cost=1.65..4.22 rows=7 width=66) (actual time=0.063..0.096 rows=5 loops=1)
    Hash Cond: (contact.id_person = person.id_person)
    ->  Seq Scan on contact  (cost=0.00..2.09 rows=109 width=27) (actual time=0.005..0.019 rows=109 loops=1)
    ->  Hash  (cost=1.61..1.61 rows=3 width=39) (actual time=0.021..0.021 rows=2 loops=1)
            Buckets: 1024  Batches: 1  Memory Usage: 1kB
            ->  Seq Scan on person  (cost=0.00..1.61 rows=3 width=39) (actual time=0.011..0.020 rows=2 loops=1)
                Filter: ((first_name)::text ~~ 'K%'::text)
                Rows Removed by Filter: 47
    Total runtime: 0.152 ms

[Using `EXPLAIN`](https://wiki.postgresql.org/wiki/Using_EXPLAIN) is not at all trivial. But there are
a couple of things you can make out easily -- the first parenthesis contains the **estimate** of the operations and
the second parenthesis contains the actual result. E.g. in the first item:

    Hash Join  (cost=1.65..4.22 rows=7 width=66) (actual time=0.063..0.096 rows=5 loops=1)

You can see that the database server expected that the result will have about 7 rows. **Hash Join**
means that the join is using an [**index**](/articles/database-tech/#index). The join took 0.063..0.096 milliseconds
and in fact yielded five rows. A *Seq scan** is a sequential scan which means that the database
is looping over all the rows of the table (this is slower than hash scan, but is used here, because
the table is tiny). Notice that the actual order of operations is swapped -- the join is the last operation --
i.e. the `person` table had been filtered before it was joined.

There are many ways how an *execution plan* can be created. That is why first the server creates some estimates
and then selects the fastest execution plan. The more complex a query is,
the more options there are. The execution plan may vary on a single database system
depending on tables indexes, server configuration and available hardware resources.
Different database systems may have drastically different execution plans, which means
that a query that performs excellently on one database server may overload a
different database server.

All this means that universal interfaces are designed
mostly so that programmers do not have to learn many database interfaces. They are
not designed to make truly portable applications. In the rest of this article I
will describe the common differences between database systems, but keep in mind that
this is far from true portability of an application.

## Things Built on Top of SQL
Apart from each database system having its own set of SQL extensions, there are completely
new languages built on top of SQL or having similar properties to SQL:
Doctrine Query Language (DQL), Hibernate Query Language (HQL), Java Persistence Query Language (JPQL), JOOQ, ...

### ORM
One area where this is often used is the **ORM layer** (Object-Relational Mapping). ORM layer is part
of the application which is used in applications developed with
[Object Oriented Approach](https://en.wikipedia.org/wiki/Object-oriented_analysis_and_design#Object-oriented_modeling)
which use a [Relational database](/articles/relational-database/). As
I [described before](/articles/database-systems/#data-model), the relational model and Object model are
data (database) models, which are quite similar in some ways. This means that it is possible to
create an ORM layer. The ORM layer is used inside an application instead of a database layer. The layer
is responsible for communicating with the database.

That is, instead of using `$db->query()` on e.g. the [PDO](http://php.net/manual/en/book.pdo.php) database layer, you would
call `$orm->query()` on e.g. the [Doctrine](http://www.doctrine-project.org/) layer. The ORM layer generates an SQL
query, obtains a table from the database and converts the table in a collection of objects
which it returns to your application. Using ORM is great and saves a great deal of work
for some applications (or some parts of them). For other types of applications,
it may get really annoying.

~~~ php?start_inline=1
...
$query = $em->createQuery(
    'SELECT User FROM User
    LEFT JOIN User.address WHERE User.address.city = ?1'
);
$query->setParameter(1, 'Berlin');
$users = $query->getResult();
...
~~~

The above example shows a
[DQL](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/dql-doctrine-query-language.html)
query which retrieves number of articles for each user.
At first sight, you can see that the query is highly similar to the SQL query. There are some
differences however. The join condition is shortened to `User.address` because the
ORM layer is able to figure out the relations on its own. Also the query will return a collection of
`User` objects.

### Query Builders
A **Query builder** is often confused with ORM, because most ORM layers support it. However, a query
builder is a programming interface which is used to generate the (SQL) query string. So a query builder
can be used for SQL or DQL queries, or any other query language (if it supports it).

Example:

~~~ php?start_inline=1
...
$query = qb->select('person.*');
$query->orderBy('person.first_name', 'ASC');
$query->from('person');
$query->where('person.person_id = :id');
$query->setParameter(':id', 42);
...
~~~

Using a query builder has the advantage that various parts of the query can be specified in any order
and not necessarily the one used in the final query. This can have some advantages in code organization.
So it sometimes leads to less cluttered code.
A big disadvantage of a query builder is that the query is not portable --- i.e. you cannot take it to
a database administration interface and run it (and vice versa) which makes it harder to test.
A query builder is often used together
with [**fluent interface**](https://en.wikipedia.org/wiki/Fluent_interface) which makes the syntax nicer:

~~~ php?start_inline=1
...
$qb->select('person.*')
   ->orderBy('person.first_name', 'ASC')
   ->from('person')
   ->where('person.person_id = :id')
   ->setParameter(':id', 42);
...
~~~

There are some cases where using a query builder is almost necessary --- complex
queries with many filtering conditions. It is important to note that unlike ORM, a
query builder does not make query development easier in any way. You have to write the same
query anyway.

## Summary
In this article I went through a number of topics. The common about them is that they go slightly
beyond simply sending SQL queries to a server. From the very broad area of database management,
and query optimizations I picked a few topics which you are likely to
encounter. You should be aware of the differences between database servers and vendors. These
differences are especially visible when defining a database schema (data types, auto incrementing keys, constraints) and when working with automatically generated keys.

### New Concepts and Terms
- database interface
- database data types
- signed integer
- unsigned integer
- floating point number
- timestamp
- auto-increment
- sequence
- last inserted ID
- currval
- NOT NULL
- CHECK
- FOREIGN KEY
- Foreign Key Cascade
- Data Dictionary
- information_schema
- index
- explain
- ORM
- query builder
