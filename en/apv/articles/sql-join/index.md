---
title: SQL – Joining data
permalink: /en/apv/articles/sql-join/
---

* TOC
{:toc}

In the previous article I have described [the principles of the relational databases](/en/apv/articles/relational-database/).
This leads to the SQL language which is built upon them and is used by many
database systems worldwide. In this article I will describe in more details how
individual relations (tables) are connected (joined) together. I assume that
you have some basic experience with SQL in [querying individual tables](/en/apv/walkthrough/database/#select).

## Introduction
When working with a database, and especially when working with multiple tables,
it is crucial to understand the structure of the database -- its **database schema**.
There is a full follow up article about the [database design](todo) in which
I explain how to create the schema. But before you start designing your own
databases it is good to know how to work with existing ones.

### Reading the Database Schema
The [example database](/en/apv/walkthrough/database/#database-schema) has the following schema:

{: .image-popup}
![Database Schema](/en/apv/schema.svg)

There are eight tables in the schema, each table has its columns and their data types
listed in the schema. The schema also shows [keys](/en/apv/articles/relational-database/#key):

- a column marked with `PK` is part of a Primary Key,
- a column marked with `FK` is part of a Foreign Key,
- a column marked with `K` is part of some other Key.

The database schema also shows lines representing *relationships* between tables (relations) --
these provide further details about the defined foreign keys. The relationship endpoints
represent **cardinality** of the relationship -- how many records of the relation may
reference how many other rows. A bar means *one*, a circle means *zero* and a foot means *N*. Examples:

{: .image-popup}
![ERD Legend](/en/apv/articles/sql-join/erd-legend.svg)

Reading that you can see for example that:

- the `person_meeting` table has a compound primary key;
- the `person` table has a compound key on the combination `first_name`, `last_name`, `nickname`;
- the `contact_type.name` column must be unique;
- the `meeting.id_location` column references the `location.id_location` column;
- a `meeting` has 1..1 relationship to the `location` therefore a meeting **must have exactly one**
(at least one and at most one) assigned location
- a `location` has 0..N relationship to the `meeting` therefore a location **can be used by zero or more**
meetings (a location does not have to be used in any meeting at all);
- a person can have zero or more contacts;
- a contact must be assigned to exactly one person;
- a person may have zero or more attendances (`person_meeting`);
- an attendance must be assigned to one person.

## Selecting Data
I assume you know how to [select data from a single table](/en/apv/walkthrough/database/#select). When joining multiple
tables together, it is important to follow some good practices. First it is good practice to
be explicit about column names and use dot notation to specify **fully qualified column names**.
So instead of `SELECT description FROM ...` use `SELECT meeting.description FROM ...`, otherwise
you will run into weird errors in case you join tables which happen to have columns with same name.

Also, avoid using `*`, at least in the SQL queries used in your application. When
you are requesting all columns from a table in an application, you make:

- the application inefficient (what if there is a column containing a person photograph?),
- prone to errors which arise from database changes.

Image that you select data from two tables like `SELECT meeting.*, person.* FROM ...`. The
column named `description` will contain the meeting description. When you then add a `description`
column to the `person` table, that column will override the first one (you will have two
columns with the same name) and the query will suddenly start to return the person description! Such errors
are very treacherous so it is best to avoid them in the first place.

### Aliases
Alias allows you to rename a table or a column within a query. E.g. to rename a column you would 
write:

{% highlight sql %}
SELECT id_contact_type AS id, name FROM contact_type 
{% endhighlight %}

The above query will return a table with columns `id` and `name`. The keyword `AS` can be 
omitted, so the below query is also valid:  

{% highlight sql %}
SELECT id_contact_type id, name FROM contact_type 
{% endhighlight %}

Learn to spot when you need aliases. For example you need them when writing
`SELECT meeting.description, relation.description FROM ... ` because in the query *result*, the
column name is never fully qualified - i.e. you will have two columns named `description`.
Therefore use `SELECT meeting.description AS meeting_description, relation.description FROM ... `
(or rename both columns to avoid confusion).

### Relation vs. Table
All results of SELECT queries are returned as tables. However not all of them are relations,
because a relation must have a key (and no duplicates). For managing duplicates, there are two
SQL keywords used: `ALL` and `DISTINCT`. For example, when you write:

{% highlight sql %}
SELECT city FROM location ORDER BY city;
{% endhighlight %}

You will obtain a list of all locations, with only their cities listed. This means that there are
duplicates and the result is not a relation. To remove the duplicates use the keyword `DISTINCT`:

{% highlight sql %}
SELECT DISTINCT city FROM location ORDER BY city;
{% endhighlight %}

Now the query will return each city only once. The keyword `ALL` is the opposite of `DISTINCT`
and lists all values including duplicates. As that is the default behavior, the keyword `ALL` is
rarely used (sometimes it is used to emphasize that you really need the duplicates). It is important
to understand that the `DISTINCT` keyword refers to the entire
table, i.e. the query:

{% highlight sql %}
SELECT DISTINCT city, street_name FROM location ORDER BY city;
{% endhighlight %}

will return unique **combinations** of `city` and `street_name`, therefore it will return
some cities duplicate. The result will be a relation. It is important to be aware of
when you may receive duplicates in the query results because they may change the results
of joins slightly unexpectedly.

### NULL
NULL is a SQL keyword which marks a missing value. It is somewhat similar to a 
[null pointer](https://en.wikipedia.org/wiki/Null_pointer). Because it has no value, it 
requires some care when comparing it. For example the below query will return no rows:

{% highlight sql %}
SELECT * FROM person WHERE height = NULL
{% endhighlight %}

As will the one below: 

{% highlight sql %}
SELECT * FROM person WHERE height != NULL
{% endhighlight %}

Only the query below will really return persons without height:

{% highlight sql %}
SELECT * FROM person WHERE height IS NULL
{% endhighlight %}

I.e. it means that `NULL = NULL` is neither true, nor false. Also there are some things you
need to be aware of when counting with NULLs. You must not confuse NULL with 0. All expressions 
with NULL yield NULL, e.g.:

- 3 + 0 -> 0
- 3 + NULL -> NULL
- 3 / 0 -> ERROR: division by zero   
- 3 / NULL -> NULL

This has some important consequences, e.g. when you have a `person` table: 

|height|
|------|
|10    |
|5     |
|0     |

A query:

{% highlight sql %}
SELECT AVG(height) FROM person
{% endhighlight %}

will return `5`.

|height|
|------|
|10    |
|5     |
|NULL  |

{% highlight sql %}
SELECT AVG(height) FROM person
{% endhighlight %}

will return `7.5`. This means that for example for person height, you cannot replace 
an unknown value with 0. As you can see in the above example, doing so will return wrong
results for e.g *average person height*. Therefore it is very important to use NULL values 
where needed.  

## Joining Tables
The principle of joining tables comes from the 
[Θ-join operator in relational algebra](/en/apv/articles/relational-database/#set-operations).
To join two tables together, you need to provide a condition which will be used to
match individual records. The result of the join will contain all columns of the
two source tables. Usually the join condition is the condition defined
in a [foreign key](/en/apv/articles/relational-database/#foreign-key), although it can really be any condition.

All tables used in the query must be specified in the `FROM` clause:

{: .highlight}
<pre>
SELECT [ ALL | DISTINCT ] <em>column_expression</em>, ...
<strong>FROM <em>table_expression</em></strong>
    [ WHERE <em>search_condition</em> ]
    [ GROUP BY <em>column_expression</em> [, ... ] ]
    [ HAVING <em>search_condition</em> ]
    [ ORDER BY { <em>column_expression</em> [ ASC | DESC ] }
        [, <em>column_expression</em> [ASC | DESC ], ... ]
</pre>

- A table in the *table_expression* is any of:
    - **relation** (a physical table in the schema)
    - **view** (a virtual table in the schema)
    - **result of query** (a volatile table) -- allows [recursion](https://en.wikipedia.org/wiki/Recursion)
    - **result of join** (a volatile table) -- allows [recursion](https://en.wikipedia.org/wiki/Recursion)

Tables are joined using the `JOIN` operator:

{: .highlight}
<pre>
... FROM
*table* [AS *alias*]
    [ NATURAL ] [ LEFT | RIGHT | FULL ] [ INNER | OUTER ] JOIN
*table* [AS *alias*]
	[ ON *join_condition* | USING (*column_name*) ]
[ WHERE ...
</pre>

For example to join a `person` to their `location` you can write:

{% highlight sql %}
SELECT * FROM
    person JOIN location
    ON person.id_location = location.id_location
{% endhighlight %}

The join will return only the rows for which the join condition is true.

### Cross JOIN
The join condition corresponds to the foreign key `FOREIGN KEY (id_location) REFERENCES location(id_location)`
which is defined in the `person` table. This makes sure that the result makes sense.
In case you want to join tables where there is no foreign key, or you want to make a more
complicated join condition, you can use a **cross join** (also called **cartesian product** or **cross product**):

{% highlight sql %}
SELECT * FROM
    person, location
{% endhighlight %}

The above query will return **all combinations** of rows from `person` and `location`. This includes
combinations which make no sense at all! If you run the query, be patient for the result, because
it contains a lot of rows. Do you know how many?

{: .solution}
Number of rows in the `person` table times the number of rows in the `location` table. A few above 2400 in the sample database.

To obtain a sensible result -- list for each person only the location which is *assigned* to that person --
you again need to add that condition:

{% highlight sql %}
SELECT * FROM
    person, location
    WHERE person.id_location = location.id_person
{% endhighlight %}

Now the result is exactly the same as the one you have obtained with the `JOIN` operator.
The cross join has two uses:

- When you have no idea about the join condition, it helps you find it.
- When you really need all combinations of rows from two tables (which is rare, but happens sometimes).

Otherwise I highly discourage you from using it. Putting the join condition into
the `WHERE` statement is functionally equivalent to putting it into the `ON` statement.
But it leads to chaotic SQL queries in which join conditions and search conditions are mixed together.
Which ultimately leads to gross errors where the join conditions become overridden by the
search condition and the query returns rows which makes no sense at all. So you should avoid
using cross joins.

### INNER JOIN
The join I have described above is an **inner join** -- it returns the matching rows from both
tables. It is the default type of a join, but if you want to be explicit (which I strongly suggest),
you write it as:

{% highlight sql %}
SELECT * FROM
    person INNER JOIN location
    ON person.id_location = location.id_location
{% endhighlight %}

This is exactly the same as the query not using the `INNER` keyword.

### OUTER JOIN
An outer join allows you to select matching rows from both tables **plus** some not matching rows.
This is useful in cases where some parts of the relation is optional. For example, let's say you want
to list all persons and their addresses. If you use the `INNER` join, it will give you only those persons
that have an address, so it will not give you all the persons!

To obtain all persons, even those that do not match any location. You need to use an outer join
-- either LEFT or RIGHT:

{% highlight sql %}
SELECT * FROM
    person LEFT OUTER JOIN location
    ON person.id_location = location.id_location
{% endhighlight %}

or:

{% highlight sql %}
SELECT * FROM
    location RIGHT OUTER JOIN person
    ON person.id_location = location.id_location
{% endhighlight %}

The two queries above are equivalent. `LEFT JOIN` takes **all the rows** from the left table
(to the left of the JOIN operator) -- person and matches rows from the remaining table.
Or I can say that the `LEFT JOIN` does an `INNER JOIN` and then adds unmatched rows
from the `LEFT` table. `RIGHT JOIN` works analogously.
Because the order of tables is not important in the join statement, you can use the `LEFT`
or `RIGHT` join depending on what currently suits you. Also note that the
keyword `OUTER` is optional (when there is a LEFT or RIGHT join, it is always outer).

An `INNER JOIN` is symmetric -- both tables are equally important. A LEFT / RIGHT
`OUTER JOIN` is asymmetric as it makes one table more important. It is quite important
to understand what it means for your data.

{% highlight sql %}
SELECT * FROM
    person LEFT JOIN location
    ON person.id_location = location.id_location
{% endhighlight %}

The above query will select all persons irrespective of whether they have some location
or not. It will always give you all persons even if they do not 'live' anywhere.

{% highlight sql %}
SELECT * FROM
    person RIGHT JOIN location
    ON person.id_location = location.id_location
{% endhighlight %}

The above query will give you all locations irrespective of whether some person is using
them. It will always give you all locations even if they are not used anywhere. An outer
join is typically used when there is something optional (relations 0..1:1:N or 1..1:0..N).
It does not make sense to use it in cases where the relationship is required because it
cannot add anything not already returned by `INNER JOIN`.

The answer to the question whether you want to use an inner or outer join fully depends on
the application you are writing. Consider these requests and the corresponding
type of join:

- list all customers and their contact addresses (outer join)
- list all employees enrolled in a course (inner join)
- list all licenses (including unused ones) and the employees they are assigned to (outer join)
- list all occupied meeting rooms (inner join)
- list all customers who bought something and their contact addresses (inner join and outer join)

### JOIN Types
The diagram below shows all the useful join types:

{: .image-popup}
![Join types Venn diagram](/en/apv/articles/sql-join/join-types.svg)

The INNER join is an intersection of the LEFT and RIGHT join. It contains only the rows
common to both tables (and to the LEFT and RIGHT join). Note however that it is not
the intersection of the tables. Its counter part is `FULL OUTER JOIN` which is an
union of both the LEFT and RIGHT join as it contains the matched rows and unmatched rows
from both the left table and the right table. Although there is nothing wrong with it,
the full outer join is rarely used, simply it is not often required in applications.

You may also come across the term *equijoin*. That is no other join type, it is simply
a join which uses equality as the join condition. Most joins are equijoins.

### USING
There is an alternative shorter way to write the JOIN statement provided that the
join condition uses the two columns with the same name. You can write:

{% highlight sql %}
SELECT * FROM
    person LEFT JOIN location
    USING (id_location)
    ON person.id_location = location.id_location
{% endhighlight %}

Which is equivalent to

{% highlight sql %}
SELECT * FROM
    person LEFT JOIN location
    ON person.id_location = location.id_location
{% endhighlight %}

The `USING` statement allows you to simplify a very common type of a join condition. It does
in no way affect the way the tables are joined. You can use it with any of the above modifiers.
The only difference is that the resulting table will contain only a single column `id_location`.

### NATURAL Join
You may also encounter a `NATURAL` join. The natural join is designed for the same purpose as the
`USING` statement, but it takes it one step further -- it automatically assumes that the
join condition is equality of all columns with identical names. So this:

{% highlight sql %}
SELECT * FROM
    person LEFT JOIN location
    USING (id_location)
    ON person.id_location = location.id_location
{% endhighlight %}

is equal to:

{% highlight sql %}
SELECT * FROM
    person NATURAL LEFT JOIN location
{% endhighlight %}

Which is nice and short, but has some catches. First, unless you know the database, it is unclear what
is happening because the join condition is not explicit. This is not good for software developed by
more people. Second, natural join will bite you from behind. Let's say that you want to join tables
`person` and `location` and use natural join. But both the tables have a `description` column (you
can add it and test it!). Running the query:

{% highlight sql %}
SELECT * FROM
    person NATURAL LEFT JOIN location
{% endhighlight %}

would then be equivalent to:

{% highlight sql %}
SELECT * FROM
    person LEFT JOIN location
    USING (id_location)
    ON person.id_location = location.id_location AND person.description = location.description
{% endhighlight %}

So it will probably return no rows at all. And this is very likely something you don't want to do.
Therefore I suggest that you don't use a NATURAL join and are always explicit about the columns you
want to use in your condition.

### Joining more than two tables
A single `JOIN` operator can join only two tables. If you want to join more than two tables, you simply take
advantage of the rule that *a result of a join is a table* as well. If you want to select
all `person`s with all their `contact`s and their `contact_type`s, you would use:

{% highlight sql %}
SELECT * FROM
    (person LEFT JOIN contact
    ON person.id_person = contact.id_person)
    LEFT JOIN contact_type
    ON contact.id_contact_type = contact_type.id_contact_type
ORDER BY person.last_name
{% endhighlight %}

In the above query, first the `person` and `contact` tables are joined. Then the
`contact_type` is join to the result of that join. I have added parentheses for clarity,
but they do not have any effect. If the above seems convoluted to you, imagine that
it works similarly to plus operator. E.g. `person JOIN contact JOIN contact_type` is
similar to `5 + 8 + 13`.

## UNION
Union really has nothing to do with join. But since I mentioned intersection and union operations in the
[join types section](/en/apv/articles/sql-join/#join-types), let's see what SQL UNION operator does.
`UNION` in SQL does normal [union of sets](https://en.wikipedia.org/wiki/Union_(set_theory)). This
means that it operates on two sets of **same elements**. Remember that join operates on two
different tables with different attributes and merges those attributes together. The `UNION` operation
requires two tables with same (or at least data-type compatible) attributes.
For example, assume that you want to select all relations of *Sonny Lona* (which has id = 21) in the sample database,
let's start with the query:

{% highlight sql %}
SELECT * FROM
    relation JOIN person
    ON relation.id_person2 = person.id_person
WHERE relation.id_person1 = '21'
{% endhighlight %}

This will return 4 rows, but the problem is that the relations are always between two persons. So the
above query returns relations of *Sonny Lona* to someone, but not relations of someone to *Sonny Lona*.
These would be returned by the query:

{% highlight sql %}
SELECT * FROM
    relation JOIN person
    ON relation.id_person1 = person.id_person
WHERE relation.id_person2 = '21'
{% endhighlight %}

Note that I have swapped `id_person1` and `id_person2` and the result is 6 rows. Now I have two
tables with the same attributes and I want to merge the results into a single table:

{% highlight sql %}
SELECT * FROM
    relation JOIN person
    ON relation.id_person2 = person.id_person
WHERE relation.id_person1 = '21'

UNION

SELECT * FROM
    relation JOIN person
    ON relation.id_person1 = person.id_person
WHERE relation.id_person2 = '21'

ORDER BY first_name
{% endhighlight %}

The above query will return all 10 rows. Notice there are some oddities with the `UNION` statement.
`UNION` is an operator which expects a `SELECT` statement on both the left and the right side. But the first
`SELECT` statement cannot contain an `ORDER BY` clause, as that can be used only at the end of the
entire query. Also note that in the `ORDER BY` clause, a fully qualified column name is not necessary
because there is only a single column `first_name` in the entire table. By default `UNION` removes
duplicates from the result, if you wan to keep them, use `UNION ALL`.

Similar result can be obtained by another query without using `UNION`:

{% highlight sql %}
SELECT relation.*, person1.first_name AS first_name_1, person1.last_name AS last_name_1,
    person2.first_name AS first_name_2, person2.last_name AS last_name_2
FROM
    relation JOIN person AS person1
        ON relation.id_person1 = person1.id_person
    JOIN person AS person2
        ON relation.id_person2 = person2.id_person
WHERE relation.id_person1 = '21' OR relation.id_person2 = '21'
{% endhighlight %}

The above query is quite interesting because it is a query, where you must use 
[aliases](/en/apv/articles/sql-join/#aliases) on
both tables and columns. It also shows joining more than two tables together and it also
shows that nothing prevents you from joining the same table more times. In the above query
I first join the table `person` to `relation` on the column `id_person`. Then I again join the table
`person`, but on the column `id_person2`. This is possible because the table `relation` has two
links to the table `person` and the join person represents a different person each time
(once it is the first person, second time it is the other one). Because the same table is used
more than once, it must be renamed with alias (it would be sufficient to name one of them), also the
column names must be renamed.

## Summary
In this article I have described how joining tables works in SQL. The join is used to
obtain data from multiple tables and merge their column sets together.
The join is a very important part of the SQL language, no real application can do without it.
I have also shown the `UNION` statement which can merge data from two compatible
tables together. The union is used much less than the join.

Technically, joins are not too complicated. The complex thing about joining tables is that you
have to analyze and understand what the application requires and choose the appropriate
join type. This is very important and there is no step-by-step procedure for that, it
is something you have to figure out on your own.

### New Concepts and Terms
- database schema
- join
- fully qualified name
- inner join
- outer join
- left / right join
- using
- union
