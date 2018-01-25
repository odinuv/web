---
layout: slides
title: SQL Basics
description: Introduction to SQL, Joining tables in database.
transition: slide
permalink: /slides/sql-join/
redirect_from: /en/apv/slides/sql-join/
---

<section markdown='1'>
## Introduction
- SQL commands may be terminated with a semicolon `;` (delimiter, not a terminator).
- Strings must be quoted with single quotes `'` (quote numbers as well).
- Create Database -- the SQL command `CREATE`.
    - Syntax is fairly complicated and highly dependent on the specific database system.
    - Check the manual for details.
    - No need to learn this thing!
- Proper tools are able to generate the `CREATE` commands from visual database design.
</section>

<section markdown='1'>
## Create Database

![Database Schema](/common/schema.svg)
</section>

<section markdown='1'>
## Insert data
- The SQL command INSERT INTO [ (*column_list*) ] VALUES (*value_list*)
- `INSERT INTO persons (first_name, last_name, nickname) VALUES ('John', 'Doe', 'Johnny')`
- Columns not listed are inserted with default values (usually `NULL`).
- If the default value is `NULL`, and the column is `NOT NULL`, then a value must be provided.
- In an application code, all columns should be listed.
- An automatically generated primary key (auto_increment, serial) is almost never inserted.
</section>

<section markdown='1'>
## Insert -- examples
{% highlight sql %}
INSERT INTO person (id_person, first_name,
    last_name, nickname, birth_day, gender,
    height, id_location)
VALUES (DEFAULT, 'John', 'Doe', 'Johnny',
    NULL, 'male', DEFAULT, NULL)
{% endhighlight %}

{% highlight sql %}
INSERT INTO person
VALUES (DEFAULT, 'John', 'Doe', 'Johnny')
{% endhighlight %}
</section>

<section markdown='1'>
## Insert -- dates
- Dates are inserted as strings (usually `Y-m-d`) or with a conversion function.
- Insert date -- PostgreSQL (first) vs. MySQL (second):

{% highlight sql %}
INSERT INTO person (first_name, last_name,
    nickname, birth_day)
VALUES ('John', 'Doe', 'Johnny',
    TO_TIMESTAMP('5.1.1984', 'DD.MM.YYYY'))
{% endhighlight %}

{% highlight sql %}
INSERT INTO person (first_name, last_name,
    nickname, birth_day)
VALUES ('John', 'Doe', 'Johnny',
    STR_TO_DATE('5.1.1984', '%d.%m.%Y'))
{% endhighlight %}
</section>

<section markdown='1'>
## Updating data
- The SQL command UPDATE table SET *column* = *expression* [,*column* = *expression* ...] [ WHERE *search_condition* ]
- `UPDATE person SET height = '196' WHERE id_person = '42'`
- If the `WHERE` clause is missing, all rows are updated!
    - `UPDATE person SET birth_day=NULL`
- The `WHERE` condition usually contains a key.
    - If compound, then all parts must be provided!
- To remove a value, set it to `NULL`.
</section>

<section markdown='1'>
## Update Examples
{% highlight sql %}
UPDATE person SET nickname = 'EthyHethy'
WHERE id_person = '1'
{% endhighlight %}

{% highlight sql %}
UPDATE person SET nickname = 'EthyHethy'
WHERE first_name = 'Ethyl'
    AND last_name = 'Herren' AND nickname='Ethy'
{% endhighlight %}
</section>

<section markdown='1'>
## Deleting Data
- The SQL command DELETE FROM *table* WHERE *search_condition*
- `DELETE FROM persons WHERE id_person = 42`
- If the search condition is missing, **all rows in the table will be deleted**.
- DELETE removes entire rows; to remove a single value, use UPDATE.
</section>

<section markdown='1'>
## Selecting Data
- The SQL command SELECT FROM *tables* WHERE *search_condition*
- SELECT is by far the most complicated SQL command.
    - You can be learning it for years and never finish.
- Important clauses:
    - `FROM` -- source tables from which you select data,
    - `WHERE` -- a search condition -- the same as in `UPDATE` or `DELETE`,
    - `JOIN` -- for joining multiple tables together,
    - `ORDER BY` -- for ordering rows in the result,
    - `GROUP BY` -- for aggregating data,
    - `HAVING` -- a search condition for aggregated data.
</section>

<section markdown='1'>
## Select syntax (simplified)

{: .highlight}
<pre>
SELECT [ ALL | DISTINCT ] <em>column_expression</em>, ...
FROM <em>table_expression</em>
    [ WHERE <em>search_condition</em> ]
    [ GROUP BY <em>column_expression</em> [, ... ] ]
    [ HAVING <em>search_condition</em> ]
    [ ORDER BY { <em>column_expression</em> [ ASC | DESC ] }
        [, <em>column_expression</em> [ASC | DESC ], ... ]
</pre>
</section>

<section markdown='1'>
## Select Expressions
- *column_expression* is either a column name or expression which evaluates to a single value:
    - arithmetic operation: `4 + 2`,
    - function call: `MAX(column)`,
    - sometimes a SQL query is also allowed.
- `SELECT ... FROM` -- projection from relational algebra
- `WHERE` -- restriction from relational algebra
- `SELECT * FROM persons` -- all columns and all rows from the table `persons`
- `SELECT id_person, first_name, last_name FROM persons WHERE height > 190`
</section>

<section markdown='1'>
## SELECT Clause

{: .highlight}
<pre>
<strong>SELECT [ ALL | DISTINCT ] <em>column_expression</em>, ...</strong>
FROM <em>table_expression</em>
    [ WHERE <em>search_condition</em> ]
    [ GROUP BY <em>column_expression</em> [, ... ] ]
    [ HAVING <em>search_condition</em> ]
    [ ORDER BY { <em>column_expression</em> [ ASC | DESC ] }
        [, <em>column_expression</em> [ASC | DESC ], ... ]
</pre>
</section>

<section markdown='1'>
## SELECT Clause

- SELECT [ ALL | DISTINCT ] { \* | *table*.\* | [*table*.]*column* [AS *alias*] [, *table*.]*column* [ AS *alias*] ... }
FROM ...
- `*` -- select all columns available in the `FROM` clause.
- `table.*` -- select all columns from the given table.
- `table.column` -- select the column from the given table.
- `AS` -- assign a temporary different name to a column -- **alias**.
</section>

<section markdown='1'>
## SELECT -- Examples
- Variants of the same query:
    - `SELECT meeting.id_meeting, meeting.start, meeting.description, meeting.duration, meeting.id_location FROM meeting`
    - `SELECT meeting.* FROM meeting`
    - `SELECT * FROM meeting`
- Select all places where some meeting occurs:
    - `SELECT id_location FROM meeting`
    - `SELECT ALL id_location FROM meeting`
- Without duplicate rows (table × relation):
    `SELECT DISTINCT id_location FROM meeting`
</section>

<section markdown='1'>
## FROM Clause

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
</section>

<section markdown='1'>
## Table Expression
- Selecting data from a single table is not really useful.
- To select data from multiple tables, they must be JOINed.
- By joining tables (Θ - join) the original schema can be reconstructed.
- A table is:
    - **relation** (a physical table in a schema)
    - **view** (a virtual table in a schema)
    - **result of query** (a volatile table)
    - **result of join** (a volatile table)
</section>

<section markdown='1'>
## JOIN Operator

{: .highlight}
<pre>
... FROM
<em>table</em> [AS <em>alias</em>]
	[ LEFT | RIGHT | INNER ] JOIN
<em>table</em> [AS <em>alias</em>]
	ON <em>join_condition</em>
[ WHERE ...
</pre>

- On both *left* and *right* side of the JOIN, there is a table.
- The joined table contains rows for which the join condition is true.
- CROSS JOIN / Cartesian Join / Cartesian Product :
    - `SELECT * FROM persons, locations`
</section>

<section markdown='1'>
## INNER JOIN Operator
- You can join with Cartesian Product. `JOIN` is more flexible.
- `SELECT * FROM persons INNER JOIN contact ON persons.id_person = contact.id_person`
- Selects rows from both tables which satisfy the join condition (1:1 or 1:1..N).
- Selects all persons which have some contact.
- Each person is listed as many times as she has contacts.
- If column names are same, the condition can be shortened:
    - `SELECT * FROM persons INNER JOIN contact USING(id_person)`
- `INNER JOIN` is default and symmetric.
</section>

<section markdown='1'>
## LEFT / RIGHT JOIN
- `SELECT * FROM person LEFT JOIN contact ON person.id_person = contact.id_person`
    - Selects **all rows from the left** table and rows satisfying the condition from the right table (1:0..1 or 1:0..N).
    - Selects all persons and if the persons have contacts, lists the contacts too.
- `SELECT * FROM person RIGHT JOIN contact ON person.id_person = contact.id_person`
    - Selects **all rows from the right** table and rows satisfying the condition from the left table.
    - Selects all contacts and lists persons with each contact (same as INNER JOIN in this case).
</section>

<section markdown='1'>
## LEFT / RIGHT JOIN
- `SELECT * FROM relation LEFT JOIN relation_type ON relation.id_relation_type = relation_type.id_relation_type`
    - Selects all relations and lists the relation type for each relation.
    - Lists also relations which have no type (cannot exist).
- `SELECT * FROM relation RIGHT JOIN relation_type ON relation.id_relation_type = relation_type.id_relation_type`
    - Select all relation types and assigns the relation type to each relation.
    - Lists also relation types which are not used.
</section>

<section markdown='1'>
## JOIN Examples
- Equivalent queries:
{% highlight sql %}
SELECT * FROM
    contact LEFT JOIN contact_type
    ON contact.id_contact_type =
        contact_type.id_contact_type
{% endhighlight %}

{% highlight sql %}
SELECT * FROM
    contact_type RIGHT JOIN contact
    ON contact.id_contact_type =
        contact_type.id_contact_type
{% endhighlight %}

</section>

<section markdown='1'>
## JOIN Examples
- Equivalent queries:
{% highlight sql %}
SELECT * FROM
    contact INNER JOIN contact_type
    ON contact.id_contact_type =
        contact_type.id_contact_type
{% endhighlight %}

{% highlight sql %}
SELECT * FROM contact NATURAL JOIN contact_type
{% endhighlight %}
</section>

<section markdown='1'>
## JOIN Summary
- JOIN is used to obtain data from multiple tables.
- An alias is used when the same table is used more times in join.
- The join condition is usually an equality between two columns.
    - One of them usually has a foreign key.
- The join condition can be more exotic (AND / OR, inequality)
- Join connects tables -- relations, views, other joins, selects.
</section>

<section markdown='1'>
## WHERE Clause

{: .highlight}
<pre>
SELECT [ ALL | DISTINCT ] <em>column_expression</em>, ...
FROM <em>table_expression</em>
    <strong>[ WHERE <em>search_condition</em> ]</strong>
    [ GROUP BY <em>column_expression</em> [, ... ] ]
    [ HAVING <em>search_condition</em> ]
    [ ORDER BY { <em>column_expression</em> [ ASC | DESC ] }
        [, <em>column_expression</em> [ASC | DESC ], ... ]
</pre>
</section>

<section markdown='1'>
## WHERE Clause

{: .highlight}
<pre>
WHERE  {
<em>column_expression</em>
    [NOT] { = | <> | < | <= | > | >= } <em>column_expression</em> |
	{ ALL | ANY | SOME } pod-dotaz |
<em>column_expression</em>
    [NOT] IN ( { <em>set_of_values</em> | <em>sub-query</em> } ) |
<em>column_expression</em> [NOT] LIKE <em>pattern</em> |
	[ { AND | OR } …]
</pre>
</section>

<section markdown='1'>
## WHERE Clause
- `LIKE` pattern can contain:
    - underscore `_` -- placeholder for a single character:
        - `'Ju_y'` matches 'July', 'Judy'
    - percent `%` -- placeholder for 0 or more characters:
        - `'J%'` matches 'Jo', 'June', ...
- `NOT` operator is unary boolean operator -- two notations:
    - `WHERE NOT first_name LIKE 'J%'`
    - `WHERE first_name NOT LIKE 'J%'`

{% highlight sql %}
SELECT first_name, last_name FROM person
WHERE (first_name LIKE 'P%')
    OR (first_name LIKE 'L%')
{% endhighlight %}
</section>

<section markdown='1'>
## IN Operator
- Matches a column value against a **set** of values:
    - static list in the query,
    - dynamic result of a sub-query.
- In either case it shouldn't have duplicates.

{% highlight sql %}
SELECT first_name, last_name FROM person
WHERE first_name IN ('Judy', 'July')
{% endhighlight %}
</section>

<section markdown='1'>
## IN Operator
{% highlight sql %}
SELECT first_name, last_name FROM person
WHERE id_location IN (
    SELECT id_location FROM location
    WHERE country = 'United Kingdom'
)
{% endhighlight %}
</section>

<section markdown='1'>
## ORDER BY Clause

{: .highlight}
<pre>
SELECT [ ALL | DISTINCT ] <em>column_expression</em>, ...
FROM <em>table_expression</em>
    [ WHERE <em>search_condition</em> ]
    [ GROUP BY <em>column_expression</em> [, ... ] ]
    [ HAVING <em>search_condition</em> ]
    <strong>[ ORDER BY { <em>column_expression</em> [ ASC | DESC ] }
        [, <em>column_expression</em> [ASC | DESC ], ... ]</strong>
</pre>
</section>

<section markdown='1'>
## ORDER BY Clause

- Ordering can be done by multiple criteria, modifiers apply to each criteria:
    - `ASC` -- ascending (A-Z, oldest-newest) -- default ordering,
    - `DESC` -- descending (Z-A, newest-oldest).

{% highlight sql %}
SELECT * FROM person
ORDER BY last_name DESC, nickname DESC
{% endhighlight %}
</section>

<section markdown='1'>
## Checkpoint
- Is it possible to join more than two tables?
- What happens if you run a `DELETE` without a `WHERE`?
- Can you join a table in the database with result of a `SELECT`?
- What are aliases useful for?
- Is it necessary to give the join condition for every join?
- Why should you list column names in an `INSERT`?
- Can you insert date to the database in arbitrary format?
- What are the most common methods of joining tables?
- Why is using a cartesian product not a good idea?
</section>
