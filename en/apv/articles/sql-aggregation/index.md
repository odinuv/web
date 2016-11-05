---
title: Sub-queries and Aggregation 
permalink: /en/apv/articles/sql-aggregation/
---

* TOC
{:toc}

In [previous article](/en/apv/articles/sql-join/) I described how tables are joined together
in SQL. In this article I will get into more advanced SQL stuff. In 
SQL, there are many ways how one problem can be solved. In procedural 
languages (like PHP), there also many ways how the same procedure can be written.
But these are mostly cosmetic changes, which do not lead to completely different code.
Because SQL is declarative language, there are many *conceptually different* ways
how a task can be described. And each of these ways may or may not lead to 
different sequence of steps executed on the data, which may or may not lead
to same results.

Because of this, it crucial for you to understand what the SQL query is really
doing and **why** it returns the data it returns. In this article, I will
try to explain some of the common approaches and the differences between them.
This is honestly quite difficult and requires a lot of thinking. 
In the second part of the article I will explain what aggregation in SQL is
what is it good for.

## Sub-queries 
A sub-query is a SQL query executed within another query. Because SQL is non-procedural
language, there is really no way to chain results from multiple queries together
or to apply a sequence of queries to data (apart from using temporary tables, which is ugly).
In SQL, sub-queries are used for that. There are multiple options where a sub-query can
be used:

- In place of a table -- This is the most common example, because select query usually returns a table.
- In place of a column -- commonly used together with `IN` operator, the sub-select must return only a single column.
- In place of a value -- rarely used, but still possible, the sub-select should return a single column and row. 

Sub-queries can be used in any SQL command (SELECT, UPDATE, DELETE and with limitations even
in INSERT). However, they are most commonly used within a SELECT query. Also note that it 
is not possible to use UPDATE, DELETE or INSERT commands as sub-queries, because they do
not return a value.

### Example -- Four colours of SQL
Let's say, that you want to list all persons in the database who have an email.

#### Approach 1 -- Joins
If you followed the [previous article](/en/apv/articles/sql-join/) about joins, you should be able to write
it using two `JOIN`s. Try to do it yourself as an exercise:

{: .solution}
{% highlight sql %}
SELECT person.nickname, contact.contact
FROM 
	(person INNER JOIN contact 
		ON person.id_person = contact.id_person
	) INNER JOIN contact_type 
		ON contact.id_contact_type = contact_type.id_contact_type
WHERE 
	contact_type.name LIKE '%mail'
ORDER BY person.nickname ASC
{% endhighlight %}

{: .solution}
{% highlight sql %}
SELECT person.nickname, contact.contact
FROM 
    contact JOIN contact_type USING (id_contact_type) JOIN person USING (id_person) 
WHERE 
	contact_type.name = 'email';
ORDER BY person.nickname    
{% endhighlight %}

One of the two above solutions is roughly what you should have arrived at. I haven't precisely specified
the columns you should select or the ordering, because it does not really matter. The important part 
is that you joined together tables `person` with `contact` and then added `contact_type` (joins to `contact`)
or you can join `contact` and `contact_type` first and then join `person` to them (again joins to `contact`).
Because I wanted only persons with email, a simple inner join should be used and no left or right is 
necessary. The two above queries are equivalent, the second one is not so verbose, but it is still 
unambiguously explicit.

#### Approach 2 -- Sub-queries
An alternative to the above approach is to use a sub-query to contain the condition. 

{% highlight sql %}
SELECT person.nickname, contact_email.contact
FROM 
    person JOIN (
        SELECT contact, id_person FROM 
            contact JOIN (
		        SELECT id_contact_type FROM 
                    contact_type
                WHERE name LIKE '%mail') AS type_email 
            ON contact.id_contact_type = type_email.id_contact_type
    ) AS contact_email
    ON person.id_person = contact_email.id_person
{% endhighlight %}

If you want to understand a nested query, you have to start from the 
inside. The inner-most query is this one:

{% highlight sql %}
SELECT id_contact_type FROM 
    contact_type
WHERE name LIKE '%mail'
{% endhighlight %}

You can run the sub-query as a standalone query. On the sample database, it will
give you a table with a single column `id_contact_type` and a single value `4`.

| id_contact_type |
|-----------------|
| 4               |

Now that you understand the innermost query, you can jump one level up:

{% highlight sql %}
SELECT contact, id_person FROM 
    contact JOIN (
        SELECT id_contact_type FROM 
            contact_type
        WHERE name LIKE '%mail') AS type_email 
ON contact.id_contact_type = type_email.id_contact_type
{% endhighlight %}

The above query takes the `contact` table and joins it with the `type_email` table which is defined by the inner query.
Notice that each sub-query must be assigned an alias -- `AS type_email` in this case -- which enables you
to reference the inner query in the outer query. The outer query cannot reference tables from the inner query 
-- `contact_type` table is not accessible in the outer query above.
You can see the contents of the `type_email` table above. Because I have used an INNER JOIN, the query will 
contain *only* the rows that have the `contact.id_contact_type` value equal to those in `type_email` table 
and since that is only one value, it is essentially same as writing `contact.id_contact_type = 4`. 
Therefore the above query essentially selects all contacts that have type matching `%email`.

Now that you know what the inner queries do, you can again look at the entire query:

{% highlight sql %}
SELECT person.nickname, contact_email.contact
FROM 
    person JOIN (
        SELECT contact, id_person FROM 
            contact JOIN (
		        SELECT id_contact_type FROM 
                    contact_type
                WHERE name LIKE '%mail') AS type_email 
            ON contact.id_contact_type = type_email.id_contact_type
    ) AS contact_email
    ON person.id_person = contact_email.id_person
{% endhighlight %}

The principle is the same, I have assigned alias `contact_email` to the inner query, which contains
all emails in the database. The result table is `INNER` joined with persons, which yields
only the persons having an email. 

While this approach probably looks much more complicated then the first one. It is used
widely and for complicated queries it is in fact easier (because it allows you to run
parts of the query isolated).

#### Approach 3 -- IN operator
The [IN operator](/en/apv/walkthrough/database/#select) is used as part of `WHERE` clause to check if a value of 
a column is in a *set* of values.

{% highlight sql %}
SELECT person.nickname FROM person 
WHERE person.id_person IN (
	SELECT DISTINCT id_person FROM contact 
	WHERE id_contact_type IN (
		SELECT DISTINCT id_contact_type FROM contact_type 
		WHERE name LIKE '%mail'
	)
)
{% endhighlight %}

Again, there are two sub-queries, which you can run standalone. The innermost query is the same as in the
previous example with sub-queries. However this entire query is simpler as there are no joins. 
This in turn means that it is not possible to display results from multiple tables. This is a   
limitation of this approach.

Notice that to be usable in an `IN` operator, the sub-query must return only a single 
column (also it wouldn't make much sense to search for `id_contact_type` in `name` column).
Also notice that I have used the `DISTINCT` keyword in both sub-queries to ensure that the 
result is a **set**. Depending on the database server (and version), this may or may not be 
necessary.   

#### Approach 4 -- EXISTS operator
The fourth approach uses the `EXISTS` operator which is used in the `WHERE` clause and
checks if (for each row) a row exists in the sub-query.

{% highlight sql %}
SELECT person.nickname
FROM person 
WHERE EXISTS (
	SELECT 1 FROM 
		contact 
	WHERE EXISTS (
        SELECT 1 FROM 
            contact_type
        WHERE name LIKE '%mail' AND
            contact.id_contact_type = contact_type.id_contact_type 
	) AND person.id_person = contact.id_person
)
{% endhighlight %}

Because this probably looks a little complicated, lets limit this to the middle
query:

{% highlight sql %}
SELECT * FROM 
    contact 
WHERE EXISTS (
    SELECT 1 FROM 
        contact_type
    WHERE name LIKE '%mail' AND
        contact.id_contact_type = contact_type.id_contact_type 
) AND person.id_person = contact.id_person
{% endhighlight %}

The query selects from the `contact` table rows for which a corresponding 
row exists in the sub-query **and** meets the condition `person.id_person = contact.id_person`.
The inner query selects `1` (which is a column full of ones), because the `EXISTS` operator
checks only if a row is returned (not for the contents of the row). So it does not 
matter what the inner query selects, but it must select something.

The the inner query has the condition that name matches email and
`contact.id_contact_type = contact_type.id_contact_type`. This probably looks strange, because
the query selects from the table `contact_type`, yet it references the table `contact` as well.
This is called a **correlated sub-query**. In SQL, a query cannot reference tables inside a 
sub-query (it can only use its result), but a sub-query can reference its parent query. 
A correlated sub-query must be evaluated together with the its parent query.

The `EXISTS` operator can always be replaced by some other approach. I would also discourage you
from using correlated sub-queries as they are usually both inefficient and incomprehensible.
But there are some rare cases where they must be used, so you should know that something like
that is possible. 

#### Example Summary
The examples above show how the same query (retrieving persons with e-mail) can be written using 
four distinctively different approaches:

- Query 1 -- join everything together, then select what you want.
- Query 2 -- select first, then join together (mind aliases).
- Query 3 -- use `IN` operator and sub-queries to select sets.
- Query 4 -- use `EXISTS` operator and correlated sub-queries.  
 
You have already learned the first one in the [article about joins](/en/apv/articles/sql-join/). 
The second approach with sub-queries is a lot more complicated (and abstract), but it is really
important. There are many problems which cannot be solved without using sub-queries.
The third approach using `IN` operator use-cases can be solved by the first two approaches, but 
it is usually much simpler, efficient and elegant (if it can be used). So you should really learn 
to use it, because it is really worth it. 
The fourth approach using `EXISTS` is not really that important as its use-cases can be solved by the 
other approaches. Besides, I don't like it. Of course, all the approaches can be freely combined,
so a personal favorite of mine would probably be:

{% highlight sql %}
SELECT person.nickname, contact.contact 
FROM person JOIN contact USING (id_person)
WHERE contact.id_contact_type IN (
	SELECT DISTINCT id_contact_type FROM contact_type 
	WHERE name LIKE '%mail'
)
{% endhighlight %}

If you want to display data from multiple tables, you have to use `JOIN`. Therefore the last two 
approaches do not allow you to select contact value. Also notice that you can
freely combine any of the approaches together.

### Example -- Same approach, same result?
In the previous example I showed how a single problem can be solved with multiple 
approaches in SQL. In this example I want to show you that the choice of approach is
not at all cosmetic and has quite deep implications. 

#### Query 1A
Lets start with the following query, which select all person who have 
an address and that address is in Brno city, i.e. all persons living in Brno.

{% highlight sql %}
SELECT person.first_name, person.last_name, location.city
FROM 
    person JOIN location ON person.id_location = location.id_location
WHERE city = 'Brno'
{% endhighlight %}

#### Query 1B
The following query returns exactly the same result. It uses a sub-query
which returns a table named `location_brno` which contains only addresses in Brno
and then joins this table to persons.

{% highlight sql %}
SELECT person.first_name, person.last_name, location_brno.city
	FROM person
		JOIN (
			SELECT city, id_location 
		FROM location
			WHERE city = 'Brno'
		) AS location_brno
ON person.id_location = location_brno.id_location
{% endhighlight %}

#### Query 2A
The following query is made out of the 1A query. I have added `LEFT` to the 
join. If I add only the `LEFT` the result of the query will not change at all.
The `LEFT` join will add people who do not have any address, but those people 
also do not have `city = 'Brno'` therefore they would not be returned.
One option is to add the condition to return `city IS NULL` as well.
Therefore the following query will return all persons living in Brno plus 
those who have no address.

{% highlight sql %}
SELECT person.first_name, person.last_name, location.city
FROM 
    person LEFT JOIN location ON person.id_location = location.id_location
WHERE (city = 'Brno') OR (city IS NULL)
{% endhighlight %}

#### Query 2B
The following query is made out of 1B query. It uses the sub-query and
I have added a `LEFT` to its join. Now this behaves differently to the
2A query right above. The sub-query contains only addresses in 
Brno and there is no search condition in the parent query. This means that the 
`LEFT` join will select all persons and show their addresses provided that
they are in Brno.

{% highlight sql %}
SELECT person.first_name, person.last_name, location_brno.city
	FROM person
		LEFT JOIN (
			SELECT city, id_location 
		FROM location
			WHERE city = 'Brno'
		) AS location_brno
ON person.id_location = location_brno.id_location
{% endhighlight %}

#### Query 3A
An alternative approach is to put the search condition inside the join
condition: 

{% highlight sql %}
SELECT person.first_name, person.last_name, location.city
FROM 
    person LEFT JOIN location 
    ON person.id_location = location.id_location
        AND city = 'Brno'
{% endhighlight %}

The above query has a nice example of using a join in which the join condition
is not a simple equality.
The above query returns the same result as Query 2B because it selects
all persons from the left table and add only matching locations to each person. 
The matching locations must meet the condition that they are both assigned to the
person and also have city equal Brno. Therefore queries 2B and 3A are equivalent.

Although there is nothing technically wrong with this approach, I wouldn't 
recommend it to you. Because the join condition and the search condition is merged together
it has disadvantages of [joining tables with cartesian product](/en/apv/articles/sql-join/#cross-join). 
Specifically,
it makes things harder to debug and more prone to very serious errors. A mistake in 
the search condition or in the logical operators can easily lead to nonsense results.

### Example -- Summary
In this example I wanted to show you how subtle changes in the requirement may
lead to radical changes in the SQL query and vice versa. You have to be very 
careful when writing SQL queries -- you need to understand the requirement very
well and be very precise when implementing it.

It also shows one unfortunate property of SQL. It is easy to run into dead-ends. 
For example, there is no way to turn the query 1A into returning the 
2B result (without using a peculiar join condition). So if you had a requirement
1, which turned into requirement 2 and you initially solved it with query 1A,
you better rewrite the whole thing.

## Aggregation
In SQL aggregation is an operation which merges two or more rows (entities) into one.
It has no relation to [Aggregation in OOP](https://en.wikipedia.org/wiki/Object_composition#Aggregation). 
Aggregation usually needs an aggregation 
function (SUM, MAX, AVG, ...) which performs the merge. 

By definition, aggregation causes loss of information. On the other hand, it enables
to gain overview / high-level information, which would otherwise be difficult to extract.
It is used when you are not interested in all details:

- What is average age of our customer? (vs. list of all customers)
- What is the sum of sales on each day? (vs. list of all receipts)
- What is the sum of sales on each day for each sales person? (vs. list of all receipts)

Aggregation typically contains a **what** and a **how**. When a **what** can be
measured, is called a **metric**. An example of aggregation function, which is not a 
metric is e.g [string_agg](https://www.postgresql.org/docs/devel/static/functions-aggregate.html). 
A **how** defines how that metric should be computed.

- What is average age of our customer? (**metric**: average age, **how**: none)
- What is the sum of sales on each day? (**metric**: sum of sales, **how**: for each working day)
- What is the sum of sales on each day for each sales person? (**metric**: sum of sales, 
    **how**: for each combination of working day and sales person)

The operation or view which allows you to view the details that lead to a particular value
of a metric is called **drill-down**. For example, if you want to know why 
on March 19, Kate had sales of $9684, you would *drill-down* and look at the list of receipts for
that day and that salesperson. All this lead to
[Business Intelligence](https://en.wikipedia.org/wiki/Business_intelligence), 
which is far beyond the scope of this book. All I wanted to
show now is what aggregation is used for. 

### Aggregation functions
All database servers have some commonly used aggregation functions build in: 
`COUNT`, `SUM`, `MAX`, `MIN`, `AVG`, `STDDEV`. Then each database server can have many other
database functions, depending on what was implemented in them. For example, for PostgreSQL,
you can find a current list in [the manual](https://www.postgresql.org/docs/9.5/static/functions-aggregate.html).

An aggregation function takes a column (or [column_expression](https://www.postgresql.org/docs/9.5/static/sql-expressions.html)) 
as an argument. For example
you can run the following queries on the [sample database](/en/apv/walkthrough/database/#import-database):

- `SELECT COUNT(*) FROM person` -- number of **rows** in the `person` table (49).
- `SELECT COUNT(height) FROM person` -- number of **values** in the `height`column (40).
- `SELECT COUNT(DISTINCT height) FROM person` -- number of **unique values** in the `height` column (26).

Note that combining `DISTINCT` and `*` makes no sense. All of the above queries return a single 
row -- they aggregate the **entire table**. This is not that useful, because the 
*metric* (or *what*) is too [coarse grained](https://en.wikipedia.org/wiki/Granularity). 
To control *how* the metric is computed,
you need grouping.     

### GROUP BY clause

{: .highlight}
<pre>
SELECT [ ALL | DISTINCT ] <em>column_expression</em>, ... 
FROM <em>table_expression</em> 
    [ WHERE <em>search_condition</em> ]
    <strong>[ GROUP BY <em>column_expression</em> [, ... ] ]</strong>
    [ HAVING <em>search_condition</em> ]  
    [ ORDER BY { <em>column_expression</em> [ ASC | DESC ] }
        [, <em>column_expression</em> [ASC | DESC ], ... ]
</pre>

`GROUP BY` statement is use to divide the input table (everything in the `FROM` clause) 
into groups. The aggregation function is then applied to each group (the metric is 
computed for each group separately). The result of aggregation contains one row per group
(the metric has a single value for each group).

The grouping is defined by values of a column or columns (or column_expressions). Each 
distinct value (or combination of values) identifies one group. Although the column
is typically ID of some entity, it can be anything.

### Example 
To get a number of emails for each person having a contact, I will use
`contact` as source table:

| id\_contact | id\_person | id\_contact\_type | contact        |
|------------|-----------|-----------------|--------------------|
| 2          | 1         | 4               | john@example.com   |
| 3          | 1         | 4               | johnny@example.com |
| 8          | 1         | 4               | master@example.com |
| 4          | 2         | 4               | jill@example.com   |
| 6          | 2         | 4               | jj@example.com     |
| 7          | 6         | 4               | tom@example.com    |

The metric is *number of contacts* (therefore I will use the 
`COUNT` function). The *how* of the metric is `for each person`, therefore
I need to define a separate group for each person, which I can do by
`GROUP BY id_person`. Since `id_person` is unique for each person, each
group containing a single person id, is guaranteed to contain data
related only to that person.

The complete query is:

{% highlight sql %}
SELECT id_person, COUNT(*) FROM contact GROUP BY id_person
{% endhighlight %}

The `COUNT` function is applied to each group identifier by `id_person` values.
It returns a single value for each group, so the output of the query is:

| id_person | COUNT |
|-----------|-------|
| 1         | 3     |
| 2         | 2     |
| 6         | 1     |

Now there may be some mental twists you need to do here to get into aggregation.
First, notice that I did not use `COUNT(contact)` to count contacts. **What** 
I am counting is defined by the source data, not by what I specified in the
argument of the `COUNT` function. 

This an important thing to keep in your mind. For example if you would like to  
select `number of days it takes for me to reply to an email`, you would have to 
first obtain a table where each row represents a day you haven't replied to a
particular email (which is a difficult task!) or use a different 
aggregation function (which would be a better solution in this case).

Second (and hopefully this is obvious to you), you need to be aware of 
what is unique and **where** it is unique. It is therefore important to 
know what [keys](/en/apv/articles/relational-database/#key) 
are defined on the tables you are using. For example 
in the `contact` table, the `id_person` column is **not unique**
(because each person can have multiple contacts), but it is still unique for 
each person. Doing a group by on the `id_contact` column in the `contact` 
table makes no sense.

### Example 2 -- Aggregation with Optional elements
Things get more complicated when aggregating columns with 
possible [NULLs](/en/apv/articles/sql-join/#null). 
For example: Select number of emails for each 
person (including those persons not having any email).

A Non-solution is the following query:

{% highlight sql %}
SELECT person.id_person, COUNT(*) 
    FROM person LEFT JOIN contact
    ON person.id_person = contact.id_person
WHERE contact.id_contact_type = '4' 
GROUP BY person.id_person
{% endhighlight %}

The above query is non-solution because it does not return persons without an
email. Eventhough it uses a `LEFT JOIN` it won't select persons without email
(id\_contact\_type = 4) because they do not satisfy that condition
(they don't have any contact which would match it).  

To fix this, I need to move the search condition somewhere else, and if 
you followed [the previous example](/en/apv/articles/sql-aggregation/#example----same-approach-same-result), 
you should be able to come with both solutions yourself.

{: .solution}
{% highlight sql %}
SELECT person.id_person, COUNT(*) 
FROM person LEFT JOIN 
    (SELECT id_contact, id_person FROM contact 
    WHERE contact.id_contact_type = '4'
    ) AS contact_email
  ON person.id_person = contact_email.id_person  
GROUP BY person.id_person
{% endhighlight %}

{: .solution}
{% highlight sql %}
SELECT person.id_person, COUNT(*) 
  FROM person LEFT JOIN contact
  ON person.id_person = contact.id_person 
    AND contact.id_contact_type = '4' 
GROUP BY person.id_person
{% endhighlight %}

Because the [sub-query approach is better](/en/apv/articles/sql-aggregation/#summary), I will stick to it. However
the query is still incorrect. It now lists all persons (with each person listed
only once), but none of the persons have count = 0. This is simply incorrect 
because there are persons who do not have an email. This by the way is 
very nice exercise too -- select all persons which have no email.

{: .solution}
{% highlight sql %}
SELECT * FROM persons WHERE id_person NOT IN
    (SELECT id_person FROM contact 
    WHERE id_contact_type = 4)
{% endhighlight %}

The above aggregation query returns 1 for each person because it uses `COUNT(*)` and that
counts number of **rows** (for each group), which is one. To count number of contacts, you 
need to count number of **values** in a column with contacts. You need to use any column
of the `contact` table which is guaranteed to be `NOT NULL`. Then, the `COUNT` function will
return 1 only for persons which have a contact (*no* values in the `contact` table columns are
are null for them) and 0 only for persons which do not have any
contact (*all* values in `contact` table columns are null for them). All of them are, and therefore 
you can use **any column** of the `contact` table. The true solution therefore is:

{% highlight sql %}
SELECT person.id_person, COUNT(contact.id_contact) 
  FROM person LEFT JOIN contact
  ON person.id_person = contact.id_person 
    AND contact.id_contact_type = '4' 
GROUP BY person.id_person
{% endhighlight %}

Notice that the solution heavily depends on how the columns are defined in the database, so you must be able to
[understand table definition](/en/apv/walkthrough/database/#reading-database-structure). Also counting 
(or summing) anything properly requires that you 
wrap your head around the aggregation principle. Hopefully the next example will help you
with that. 

### Example 3 -- Different aggregations   
Consider the following two queries. Can you describe what they return?

{% highlight sql %}
SELECT id_person, COUNT(contact) FROM 
    contact
GROUP BY id_person
{% endhighlight %}

{% highlight sql %}
SELECT id_contact_type, COUNT(contact) FROM 
    contact
GROUP BY id_contact_type
{% endhighlight %}

{: .solution}
The first query returns number of contacts for each person that has a contact (e.g. John has 4 contacts). 
The second query return number of contacts for each contact type (e.g. There are 14 emails in the database). 

## Column *XY* must appear in the GROUP BY clause
When writing aggregation queries, you will often run into the following error:

    Column XY must appear in the GROUP BY clause or be used in an aggregate function.

You need to fully understand the aggregation principle to resolve the error correctly. Consider for example
the following query:

{% highlight sql %}
SELECT id_contact_type, COUNT(contact) FROM 
    contact
GROUP BY id_contact_type
{% endhighlight %}

It will return a table similar to:

| id_contact_type | count |
|-----------------|-------|
| 1               | 21    |
| 2               | 24    |
| 3               | 27    |
| 4               | 37    |

Now what would happen if you add `id_person` column to that table?

{% highlight sql %}
SELECT id_person, id_contact_type, COUNT(contact) FROM 
    contact
GROUP BY id_contact_type
{% endhighlight %}

What do you expect to be in the `id_person` column? Each row of the above table
**aggregates** multiple persons together, therefore there is no single value, that could
be shown in the `id_person` column. You will therefore get the error:

    Error in query: ERROR: column "contact.id_person" must appear in the GROUP BY clause or be used in an aggregate function
    LINE 1: SELECT id_person, id_contact_type, COUNT(contact) FROM

### Solution 1
Solution of the problem depends on what you really want to do. If you want to show
number of contacts for each person and contact type, you need to add the 
`id_person` column to the `GROUP BY` clause:

{% highlight sql %}
SELECT id_person, id_contact_type, COUNT(contact) FROM 
    contact
GROUP BY id_contact_type, id_person
{% endhighlight %} 

This will however yield an entirely different result:

| id_person | id_contact_type | count |
|-----------|-----------------|-------|
| 1         | 4               | 1     |
| 1         | 2               | 1     |
| 2         | 4               | 1     |
| 2         | 2               | 1     |
| ...       | ...             | ...   |
| 47        | 4               | 3     |
| ...       | ...             | ...   |

### Solution 2
If you really want to display all persons for each contact type in a single line, 
you need to use some kind of aggregation to do that. For example on PostgreSQL, you
can use the [`array_agg` function](https://www.postgresql.org/docs/9.5/static/functions-aggregate.html):

{% highlight sql %}
SELECT ARRAY_AGG(id_person ORDER BY id_person) AS id_person, 
    id_contact_type, COUNT(contact) 
FROM 
    contact
GROUP BY id_contact_type
{% endhighlight %}

Which will give you a table like this:

| id_person                                                                                               | id_contact_type | count |
|---------------------------------------------------------------------------------------------------------|-----------------|-------|
| {8,9,10,11,12,13,14,15,16,17,20,21,22,23,24,28,29,30,32,33,34}                                          | 1               | 21    |
| {1,2,3,4,5,6,7,8,9,10,21,22,23,24,25,26,27,28,29,30,31,32,33,34}                                        | 2               | 24    |
| {8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34}                        | 3               | 27    |
| {1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,47,47,47} | 4               | 37    |

### Solution 3
Another possibility is that you want to display every person and their contact and display a total 
number of contacts for each of the contact type.

{% highlight sql %}
SELECT contact.id_person, contact.id_contact_type, type_counts.count 
FROM 
    contact
    JOIN (
        SELECT id_contact_type, COUNT(contact) AS count FROM 
            contact
        GROUP BY id_contact_type
    ) AS type_counts
    ON contact.id_contact_type = type_counts.id_contact_type
ORDER BY id_person
{% endhighlight %}

Which will give you a table like this:

| id_person | id_contact_type | count |
|-----------|-----------------|-------|
| 1         | 4               | 37    |
| 1         | 2               | 24    |
| 2         | 4               | 37    |
| 2         | 2               | 24    |
| ...       | ...             | ...   |

### Summary
As you can see, there are many completely different ways how a query can be written
and what it returns.
Choosing the right solution really depends on what your goals are. You will probably 
often realize that what you initially wanted does not really make much sense and you 
need to go back to the drawing board. 
 
### Example
Now consider the below query. Does it make sense? Will it execute?

{% highlight sql %}
SELECT person.id_person, COUNT(contact.id_contact), person.first_name
    FROM person LEFT JOIN contact
    ON person.id_person = contact.id_person  
GROUP BY person.id_person
{% endhighlight %}

The answer depends on the database server, you use. A more intelligent one
will execute the query without an error. A solution to this query is to
use `GROUP BY person.id_person, person.first_name`. 

Again it is very important to understand the database structure. Both `id_person`
and `first_name` columns come from the `person` table. `id_person` is a key and 
therefore it is unique for each person. If you combine it with any other 
column from the persons table, you cannot obtain any more unique combination than that.

If the database server is clever enough, it will simply assume, that the 
`person.first_name` is part of the `GROUP BY` statement as well. If it is not, you have to
tell it explicitly. In either case, the query result remains the same and you can display
additional columns to the group by. Keep in mind that it depends on the columns though,
you cannot use this approach e.g. for `contact.contact` column.

## HAVING clause
The `HAVING` clause of an SQL query contains search condition applied on the 
aggregated table.

{: .highlight}
<pre>
SELECT [ ALL | DISTINCT ] <em>column_expression</em>, ... 
FROM <em>table_expression</em> 
    [ WHERE <em>search_condition</em> ]
    <strong>[ GROUP BY <em>column_expression</em> [, ... ] ]</strong>
    [ HAVING <em>search_condition</em> ]  
    [ ORDER BY { <em>column_expression</em> [ ASC | DESC ] }
        [, <em>column_expression</em> [ASC | DESC ], ... ]
</pre>

Consider the following query, which selects number of emails (contact type 4) 
for all persons that have an email, and returns only those persons that have 
more than one email.

{% highlight sql %}
SELECT person.id_person, person.nickname, COUNT(contact.id_contact) AS count 
FROM person JOIN contact
    ON person.id_person = contact.id_person
WHERE contact.id_contact_type = '4' 
GROUP BY person.id_person
HAVING COUNT(contact.id_contact) > 1
{% endhighlight %}

The above query will give you:

| id_person | nickname | count |
|-----------|----------|-------|
| 47        | Francis  | 3     |

You cannot put condition `COUNT(contact.id_contact) > 1` in the `WHERE` clause 
because the aggregation is not done there yet. Analogously, you cannot put the
`contact.id_contact_type = '4'` condition to the `HAVING` clause because the
column is not available there anymore. 

If you find the `HAVING` clause confusing, you can always work around it with a subquery.
The following query is equivalent to the above one:

{% highlight sql %}
SELECT person.id_person, person.nickname, contact_count.count
FROM 
    person JOIN
        (SELECT contact.id_person, COUNT(contact.id_contact) AS count 
        FROM contact
        WHERE contact.id_contact_type = '4'
        GROUP BY contact.id_person) AS contact_count
    ON person.id_person = contact_count.id_person
WHERE contact_count.count > 1
{% endhighlight %}

## Group By Column Expression
If you read the [definition](/en/apv/walkthrough/database/#reading-database-structure) properly, you may have noticed that 
`GROUP BY` clause allows you to use a [column expression](https://www.postgresql.org/docs/9.5/static/sql-expressions.html) 
(not only a column name).
The following query takes advantage of that:

{% highlight sql %}
SELECT height / 10 AS height_range, COUNT(person) FROM
person
GROUP BY height_range
ORDER BY height_range
{% endhighlight %}

Which will give you:

| height_range | count |
|--------------|-------|
| 15           | 1     |
| 16           | 12    |
| 17           | 14    |
| 18           | 10    |
| 19           | 3     |
| NULL         | 9     |

Because `height` is an integer column and `10` is also an integer, the expression
`height / 10` is an integer division. This means that `150 / 10 = 15` and
`156 / 10 = 15` as well. If you group by all the people into groups by this 
value, then you effectively divide them by their height into groups:

- height 150-159
- height 160-169
- height 170-179
- height 189-189
- height 190-199
- no height

Then you can see how many people fall into each group, which in fact is a 
[histogram](https://en.wikipedia.org/wiki/Histogram) of people's height. You can pimp the result by using
the [`CASE - WHEN`](https://www.postgresql.org/docs/9.5/static/functions-conditional.html) statement:

{% highlight sql %}
SELECT 
    CASE height / 10 
        WHEN 15 THEN 'height between 150 and 159' 
        WHEN 16 THEN 'height between 150 and 159'
        WHEN 17 THEN 'height between 150 and 159'
        WHEN 18 THEN 'height between 150 and 159'
        WHEN 19 THEN 'height between 150 and 159'
        ELSE 'unknown' END AS height_range, 
    COUNT(person) 
FROM
    person
GROUP BY height / 10
ORDER BY height / 10
{% endhighlight %} 

## Limit number of query results
There are two use cases for limiting number of query results -- 
[**pagination**](https://en.wikipedia.org/wiki/Pagination#Pagination_in_web_content) 
and showing **top x** results. Other uses
are usually wrong, because they fail to deliver some information to end-user.
In either case, you must **always use ORDER BY** when limiting number of rows.

### Pagination
On PostgreSQL use the keywords `LIMIT` and `OFFSET` to select a portion
of results -- e.g. to display second page of results paged by 10 records:

{% highlight sql %}
SELECT * FROM person 
OFFSET 20 LIMIT 10 ORDER BY last_name, first_name
{% endhighlight %}

See the [corresponding part of walkthrough](todo) for an example of implementation 
of entire pagination in PHP. However you should be aware that
pagination is subject to 
[certain Criticism](http://ux.stackexchange.com/questions/36394/when-is-it-better-to-paginate-and-not-to-paginate).

#### MySQL
On MySQL server, the same results can be obtained by the following query: 

{% highlight sql %}
SELECT * FROM person 
LIMIT 20,10 ORDER BY last_name, first_name
{% endhighlight %}

#### Oracle & MS SQL Server
On Microsoft SQL Server and Oracle DB server, the same results can be obtained by the following query: 

{% highlight sql %}
SELECT * FROM person 
WHERE RowNum >= 20 AND RowNum < 30 ORDER BY last_name, first_name
{% endhighlight %}

### TOP X
Other applications of limiting the number of query results are queries 
like "TOP 10 best customers" or "TOP 10 smallest persons". There is a certain 
confusion about how many results should such query return. 
There are three options (assuming top 10 smallest persons problem):

- Order persons by height descending and return the first 10 rows.
- Order heights descending and return all persons having the 10 smallest heights.
- Order persons by height descending, get the 10th height and return all persons with height smaller or
equal to that value.

Each approach may return a different number of results (assuming 
[sample database](/en/apv/walkthrough/database/#import-database)):  

{% highlight sql %}
SELECT * FROM person ORDER BY height LIMIT 10;
{% endhighlight %}

Return 10 rows. Out of 3 persons with height 168 (Tuan Fuchs, Gilda Summer, Alisha Householder	
with height 168, only one is shown (randomly selected).

{% highlight sql %}
SELECT * FROM person WHERE height IN
(SELECT height FROM person ORDER BY height LIMIT 10)
ORDER BY height
{% endhighlight %}

The above query returns 12 rows, highest height is 168.

{% highlight sql %}
SELECT * FROM person WHERE height <= 
    (SELECT DISTINCT height FROM person ORDER BY height OFFSET 9 LIMIT 1)
ORDER BY height;
{% endhighlight %}

The above query return 13 rows, highest height is 169.

## Summary
In this article I have covered some slightly advanced SQL topics -- sub-queries and aggregation.
However, you have to keep in mind that joins, sub-queries and aggregation are essential 
parts of SELECT queries. Then there is plenty of other interesting stuff which I
completely [skipped here](https://www.postgresql.org/docs/9.5/static/sql-select.html). You need to be aware
that SQL offers many different approaches to writing queries. I have shown some
examples of similar queries and different approaches to same tasks. In 
SQL, it is very important that you understand very well what you want to 
do and then you have to specify that very precisely in the query. 

Unfortunately, there is nothing which will help you with analyzing the requirements
and working out the way in which you write a SQL query. You need to train your brain 
to do it for you. This makes writing SQL much more difficult than programming 
[boilerplate code](https://en.wikipedia.org/wiki/Boilerplate_code) in PHP. 
On the other hand, it makes it a very valued skill.
Also please do believe me that rewriting a non-trivial SQL query into procedural 
language (like PHP) is not a good idea. It takes incredible amount of code which 
leads to incredible amount of bugs.  

### New Concepts and Terms
- Sub-query
- Aggregation
- GROUP BY
- HAVING
- Aggregation function
- IN operator 
- LIMIT & OFFSET
