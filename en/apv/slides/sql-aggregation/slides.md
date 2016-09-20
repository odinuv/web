---
layout: slides
title: SQL Aggregation
description: Aggregation functions in SQL, grouping and sub-queries. 
theme: black
transition: slide
permalink: /en/apv/slides/sql-aggregation/
---

<section markdown='1'>
## Sub Queries
- SQL language is very powerful and rich, there are many ways to solve one problem:
    - Join condition × Where condition,
    - Join × `IN` operator,
    - Join × sub-query.
- All approaches may be combined freely.
- For some problems, some approaches cannot be used.
- Alert: Heavy thinking required!
</section>

<section markdown='1'>
## Example -- Query 1
{% highlight sql %}
SELECT person.nickname, contact.contact
FROM 
  (person JOIN contact 
    ON person.id_person = contact.id_person
  ) JOIN contact_type 
	ON contact.id_contact_type = 
      contact_type.id_contact_type
WHERE 
  contact_type.name LIKE '%mail'
{% endhighlight %}
</section>

<section markdown='1'>
## Example -- Query 2
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
</section>

<section markdown='1'>
## Example -- Query 3
{% highlight sql %}
SELECT person.nickname FROM person 
  WHERE person.id_person IN (
	SELECT DISTINCT id_person FROM contact 
	WHERE id_contact_type IN (
	  SELECT id_contact_type FROM contact_type 
	  WHERE name LIKE '%mail'
	)
)
{% endhighlight %}
</section>

<section markdown='1'>
## Example -- Query 4
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
</section>

<section markdown='1'>
## Example Summary
- Example of 4 different approaches to retrieving persons with e-mail. 
    - They can be combined freely.
- Query 3 and 4 does not allow to select `contact` value, otherwise results are same.
- Query 1 -- join everything together, then select what you want.
- Query 2 -- select first, then join together (mind aliases).
- Query 3 -- use `IN` operator and sub-queries to select sets.
- Query 4 -- use `EXISTS` operator and correlated sub-queries.  
</section>

<section markdown='1'>
## Another Example -- Query 1A

{% highlight sql %}
SELECT person.first_name, person.last_name, 
  location.city
FROM 
  person JOIN location 
    ON person.id_location = location.id_location
WHERE city = 'Brno'
{% endhighlight %}

- Gives you a list of persons living in Brno city.
</section>

<section markdown='1'>
## Example -- Query 1B

{% highlight sql %}
SELECT person.first_name, person.last_name, 
  location_brno.city
FROM person
  JOIN (
    SELECT city, id_location 
	  FROM location
	  WHERE city = 'Brno'
  ) AS location_brno
ON person.id_location = location_brno.id_location
{% endhighlight %}

- Same result as Query 1A
- Sub-query returns a table named `location_brno` which contains only addresses in Brno
</section>

<section markdown='1'>
## Example -- Query 2A

{% highlight sql %}
SELECT person.first_name, person.last_name, 
  location.city
FROM 
  person LEFT JOIN location 
  ON person.id_location = location.id_location
WHERE (city = 'Brno') OR (city IS NULL)
{% endhighlight %}

- Without condition, same result.
- With condition gives you a list of persons living in Brno city or without address.
</section>

<section markdown='1'>
## Example -- Query 2B

{% highlight sql %}
SELECT person.first_name, person.last_name, 
  location_brno.city
FROM person
  LEFT JOIN (
    SELECT city, id_location 
  FROM location
    WHERE city = 'Brno'
  ) AS location_brno
ON person.id_location = location_brno.id_location
{% endhighlight %}

- Gives a list of **all** persons and their address provided that they live in Brno.
</section>

<section markdown='1'>
## Example -- Summary
- In Queries 2A and 2B the search condition is moved into sub-query.     
- Queries 1A and 2A are functionally equivalent.
    - 1A is simpler, but whatever you do, you cannot change it to result 2B.
    - It is an example of a dead-end approach.
- Example of how tiny changes in the query can lead to very different results.
- Example of how tiny changes in the requirements can lead to very different queries.
</section>

<section markdown='1'>
## Aggregation
- Aggregation in SQL is an operation which merges two rows (entities) into one:
    - Needs an aggregation function (SUM, MAX, AVG, ...).
    - Causes loss of information.
- Used to gain overview / high-level information.    
- Used when not interested in all details.
- Examples:
    - What are is the sum of sales on each day? (vs. list of all receipts)
    - What is average age of our customer? (vs. list of all customers)
</section>

<section markdown='1'>
## Aggregation functions
- Commonly used functions: COUNT, SUM, MAX, MIN, AVG.
- Argument is a column (or column_expression).
- Examples:
    - `SELECT COUNT(*) FROM person` -- number of **rows** in the `person` table (49).
    - `SELECT COUNT(height) FROM person` -- number of **values** in the `height`column (40).
    - `SELECT COUNT(DISTINCT height) FROM person` -- number of **unique values** in the `height` column (26).
    - Combining `DISTINCT` and `*` makes no sense.
- All of the above queries return a single row -- they aggregate the **entire table**.    
</section>

<section markdown='1'>
## GROUP BY clause

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
</section>

<section markdown='1'>
## Aggregation of Groups
- Aggregating entire table is not that useful -- too big loss of information.
- Use `GROUP BY` statement to divide table in groups.
    - Aggregation function is applied to each group.
    - Result of aggregation contains one row per group.
    - Group is defined by a column (or columns).
    - Each distinct value (or combination of values) identifies one group.
</section>

<section markdown='1'>
## Example 
- Number of emails for each person having a contact.
- Source table is `contact`:

| id\_contact | id\_person | id\_contact\_type | contact        |
|------------|-----------|-----------------|--------------------|
| 2          | 1         | 4               | john@example.com   |
| 3          | 1         | 4               | johnny@example.com |
| 8          | 1         | 4               | master@example.com |
| 4          | 2         | 4               | jill@example.com   |
| 6          | 2         | 4               | jj@example.com     |
| 7          | 6         | 4               | tom@example.com    |

</section>

<section markdown='1'>
## Example cont.
- `SELECT id_person, COUNT(*) FROM contact GROUP BY id_person`
- `COUNT` function is applied to each group of `id_person` values.
    - How many times does `id_person = X` occur in the table?
    - Multiple rows of original table are merged into one. 

| id\_person | COUNT |
|-----------|-------|
| 1         | 3     |
| 2         | 2     |
| 6         | 1     |

</section>

<section markdown='1'>
## Example 2 -- Aggregation with Optional elements
- Number of emails for each person (including those not having any).
- Non-solution (returns 1 for person without contact, does not return persons without email):

{% highlight sql %}
SELECT person.id_person, COUNT(*) 
    FROM person LEFT JOIN contact
    ON person.id_person = contact.id_person
WHERE contact.id_contact_type = '4' 
GROUP BY person.id_person
{% endhighlight %}
</section>

<section markdown='1'>
## Correction -- All persons (sub-query)

{% highlight sql %}
SELECT person.id_person, COUNT(*) 
FROM person LEFT JOIN 
    (SELECT id_contact, id_person FROM contact 
    WHERE contact.id_contact_type = '4'
    ) AS contact_email
  ON person.id_person = contact_email.id_person  
GROUP BY person.id_person
{% endhighlight %}
</section>

<section markdown='1'>
## Correction -- All persons (join condition)

{% highlight sql %}
SELECT person.id_person, COUNT(*) 
  FROM person LEFT JOIN contact
  ON person.id_person = contact.id_person 
    AND contact.id_contact_type = '4' 
GROUP BY person.id_person
{% endhighlight %}
</section>

<section markdown='1'>
## Correction -- Count Only Values

{% highlight sql %}
SELECT person.id_person, 
  COUNT(contact.id_contact) 
FROM person LEFT JOIN 
    (SELECT id_contact, id_person FROM contact 
    WHERE contact.id_contact_type = '4'
    ) AS contact_email
  ON person.id_person = contact_email.id_person  
GROUP BY person.id_person
{% endhighlight %}
</section>


<section markdown='1'>
- Column *XY* must appear in the GROUP BY clause or be used in an aggregate function.
- `person.first_name` can be added without problem.
- `contact.contact` makes no sense here:

{% highlight sql %}
SELECT person.id_person, COUNT(contact.id_contact), 
  person.first_name, contact.contact
FROM person LEFT JOIN contact
  ON person.id_person = contact.id_person  
GROUP BY person.id_person
{% endhighlight %}
</section>

<section markdown='1'>
## HAVING clause

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
</section>

<section markdown='1'>
- Search condition applied to the result of aggregation:

{% highlight sql %}
SELECT person.id_person, COUNT(contact.id_contact) 
    FROM person LEFT JOIN contact
    ON person.id_person = contact.id_person
WHERE contact.id_contact_type = '4' 
GROUP BY person.id_person
HAVING COUNT(contact.id_contact) > 1
{% endhighlight %}
</section>

<section markdown='1'>
## SQL Summary
- SQL is rich and very complicated language.
- It has many features, but CRUD are the most important ones.
- JOINs, aggregation and basic sub-queries are essential.
- JOIN must be used whenever you need to display data from multiple tables.
- Reading and Debugging SQL queries must be done hierarchically.
</section>

<section markdown='1'>
## SQL Summary
- Selecting the **right data** is complex, you need to understand the requirement.
    - Nothing will help you with that.
    - SQL is not procedural language, you cannot do something and the fix it. You 
    need to be precise and perfect in implementation.
- If a SQL query does not return anything, it does not mean it is wrong (and vice versa) 
</section>

<section markdown='1'>
## Checkpoint
- Does every SELECT with aggregation function need to have a GROUP BY?
- Can you substitute LEFT JOIN with RIGHT JOIN?
- What conditions must a sub-query used with `IN` satisfy?
- Can you list more than one column in `GROUP BY` clause?
- Can you use a sub-query without `JOIN` ?
- Can you use more than one aggregation function in a single query? 
- Does it make sense to use GROUP BY without aggregation function?
- Can you fully replace JOIN by sub-queries?
</section>
