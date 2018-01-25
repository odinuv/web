---
layout: slides
title: Databases -- Technical Details
description: Database data types, automatically generated keys.
transition: slide
permalink: /slides/database-tech/
redirect_from: /en/apv/slides/database-tech/
---

<section markdown='1'>
## Databases -- Oddities
- SQL is standardized, but many implementations do not follow it,
    - some things were implemented long before they were standardized;
- Notable differences:
    - data types,
    - automatically generated keys,
    - constraints.
- I will concentrate on the most common differences.
</section>

<section markdown='1'>
## Relational Database Systems
- Commonly Used RDBMS
    - Adaptive Server Enterprise (Sybase)
    - (IBM) DB2
    - Firebird
    - MariaDB
    - MySQL
    - Oracle Database
    - PostgreSQL
    - (Microsoft) SQL Server
    - SQLite
</section>

<section markdown='1'>
## Database Interfaces
- To use a database system, you need an **interface**:
    - Proprietary:
        - usable for a single database system,
        - more functions,
        - best performance.
    - Generic:
        - better support for standards
        - usable from different applications and for different DBS
        - ODBC, JDBC, PDO, ADODB, ...
</section>

<section markdown='1'>
## Database Interfaces cont.
- Every interface has functions to:
    - connect to a database (`connect` or a constructor),
    - execute a query (`exec`, `execute`, `prepare`),
    - fetch a result of the SELECT query (`fetch`, `open`, `next`, `seek`) -- work with **resultset**
    - retrieve an error result (`error`, `lastError`).
</section>

<section markdown='1'>
## Pagination
- Uses the keywords `LIMIT` and `OFFSET` on Postgres;
    - Other systems `TOP`, `BOTTOM`, `ROWNUM` keywords.
- `SELECT * FROM person ORDER BY id_person LIMIT 10 OFFSET 5`
- Remember to include `ORDER BY`! Otherwise you'll have random results.
- Criticism:
    - If it is not on the first page, search is better.
    - Maybe considered user unfriendly (combined with bad search).
- Other application: "TOP 10 best customers"
    - How many results should such a query return?
</section>


<section markdown='1'>
## Database Structure -- Create

{% highlight sql %}
CREATE TABLE table_name (
    column data_type [NOT NULL] [DEFAULT value] [PRIMARY KEY]
    [, column data_type ...]
)
{% endhighlight %}

{% highlight sql %}
CREATE TABLE contact (
    id_contact serial PRIMARY KEY,
    id_person integer NOT NULL REFERENCES person (id_person),
    id_contact_type integer REFERENCES contact_type (id_contact_type),
    contact character varying(200) NOT NULL
)
{% endhighlight %}
</section>

<section markdown='1'>
## Database Structure -- Create
- `CREATE` statements are practically used only during imports and exports.
    - Because of different data types, it is impossible to use them for migrations.
    - Use special tools for migrations.
- Database Systems have very complex configurations:
    - Can cause big changes in behavior;
    - E.g. MySQL / MariaDB storage engines (MyISAM × InnoDB)
- Different implementations of auto-increment
</section>

<section markdown='1'>
## Data Dictionary
- The structure of every DB is stored in another DB.
- DD is a shared database `information_schema`: invisible, accessible, read-only.
- To show tables in information_schema:
    - `SELECT * FROM information_schema.tables WHERE table_schema = 'information_schema'`
- To show columns of a table:
    - `SELECT * FROM information_schema.columns WHERE table_name = 'person'`
- If unsupported, there are commands like `DESCRIBE`, `SHOW`
- Modifications through commands `ALTER`, `RENAME`, `DROP`, `MODIFY`, `ADD` ...
</section>

<section markdown='1'>
## Data Types -- String
- character_varying(size) / varchar(size) / nvarchar(size)
    - a standard string limited by size
    - size in bytes for ANSI strings
    - size in characters for Unicode strings
- char(size) / character(size) / nchar(size)
    - a string limited by size
    - filled with spaces, not very useful
    - `LIKE` compares without spaces
- text / ntext
    - "unlimited" string
    - size of a cell in gigabytes
</section>

<section markdown='1'>
## Data Types -- Whole Numbers
- bigint -- 8B -- -2<sup>63</sup>..2<sup>63</sup>
    - 2<sup>63</sup> = 9 223 372 036 854 775 808
- integer -- 4B -- -2<sup>31</sup>..2<sup>32</sup>
    - 2<sup>32</sup> = 2 147 483 647
- smallint -- 2B -- -2<sup>15</sup>..2<sup>15</sup>
    - 2<sup>15</sup> = 32 768
- whole numbers:
    - signed (with a sign) -- allows negative numbers
    - unsigned (without a sign) -- allows only positive numbers
    - do not combine them!
</section>

<section markdown='1'>
## Data Types -- Decimal Numbers
- `real` / `float` / `double`:
    - a floating-point decimal;
    - inexact! -- e.g. `2 != 6 / 3` !
    - real range 1e<sup>-37</sup>..1e<sup>37</sup>
    - double range 1e<sup>-307</sup>..1e<sup>308</sup>
- `number` / `numeric` / `decimal(precision, scale)`:
    - a fixed-point decimal;
    - precision -- maximum number of digits;
    - scale -- number of digits after the decimal point.
- `money` -2<sup>63</sup>..2<sup>63</sup> = 92 233 720 368 547 758.08
</section>

<section markdown='1'>
## Data Types -- Timestamp
- Date and time is stored as **timestamp** (an unambiguous point in time).
- Usually number of milliseconds / microseconds from 1.1.1970.
- Range from 4713 BC to 294276 AD.
- Conversion to a string date is **very complex**, never ever do it yourself!
- Timestamp fixes leap days, leap seconds, DST...
- Timestamp should contain a time zone (use UTC whenever possible).
- Does not allow to store incomplete dates ('January 2016'), use separate columns.
</section>

<section markdown='1'>
## Data Types -- Date Types
- `datetime` / `date` / `time`:
    - In mysql `datetime` is *sort of same* as timestamp
- `timestamp`, `time`, `date` cannot be used to store a date / datetime interval:
    - never assume that an hour has 3600 seconds (can be from 0 up to 7200);
        - because of leap days, seconds;
        - because of DST;
    - `interval` -- store the interval of date time values.
</section>

<section markdown='1'>
## Data Types -- Date Alternative
- You may encounter using native application format:
   - a column data type is an integer
   - use the timestamp of the application language:

{% highlight php %}
<?php
...
$db->execute(
    "UPDATE person SET birth_day = :birthDay",
    [':birthDay', time()]
);
{% endhighlight %}
</section>

<section markdown='1'>
## Data Types -- Date Alternative
- pros:
    - simple, for one application without problems
- cons:
    - non-atomic (1NF), impossible to select a part of the date
    - ordering works fine though
    - impossible to store or compute an interval
    - brings back application and database dependency
    - unreliable when more applications use the database
</section>

<section markdown='1'>
## Data Types -- Binary Data
- bit / boolean / binary / bytea -- a single value,
    - BLOB / image -- binary data,
    - BLOB -- binary large object (LOB, LO).
- Details of working with LO are dependent on the database interface.
    - Escaped data may be sent within the SQL string (limited size),
    - Binary data may be sent via special functions ('unlimited' size).
- Use this to store medium sized files, better than storing them in a file system.
</section>

<section markdown='1'>
## Automatically Generated Key
- The most commonly used type of a primary key:
    - an abstract record identifier,
    - independent on outside conditions,
    - **auto-increment** or **sequence**,
    - simpler to use than compound keys (all parts must be used).
- There should be a natural key defined too (for the end-user).
- No database follows the standard fully (historical reasons).
</section>

<section markdown='1'>
## Auto-increment in PostgreSQL
- The column is assigned a special data type `serial` when creating the table.
    - `CREATE TABLE table (id serial NOT NULL,` ...
    - creates a **sequence** to generate the values;
    - assigns a default value to:
        - `nextval('sequence_name')`
    - cannot be exported exactly (the column is an integer).
- To obtain the last value, call:
    - `SELECT currval('sequence_name')`,
    - or `$db->lastInsertId('sequence_name')` in PDO.
- If a value is inserted explicitly, the sequence won't update!
    - Subsequent inserts will probably fail!
</section>

<section markdown='1'>
## Currval or Max?
- To obtain the last value of an inserted row, you **must always** use predefined functions.
- Correct:
    - `SELECT currval('sequence_name')`
    - `$db->lastInsertId('sequence_name')`
    - or:
{% highlight sql %}
SELECT id_person FROM person
WHERE first_name = 'X' AND last_name = 'Y'
    AND nickname = 'Z'
{% endhighlight %}
</section>

<section markdown='1'>
## Currval or Max? cont.
- Incorrect:
    - `SELECT MAX(id) FROM table`
    - Does not work in **concurrent environment**.
- Obtaining the value must be **thread-safe**.
    - Hard to test -- requires multiple users in rapid succession.
- The last-insert-value is tied to the **database session** (connection).
</section>

<section markdown='1'>
## Integrity Constraints
- Basic ones on a single table:
    - NOT NULL -- a column with a required value
    - `UNIQUE (KEY)`, `PRIMARY (KEY)` -- keys
    - `CHECK` -- arbitrary rules, not supported by some systems
        - e.g. `height > 0`
- Referential:
    - `FOREIGN KEY` -- dependency between tables
</section>

<section markdown='1'>
## Foreign Key
- It is not possible to UPDATE / DELETE a record while ignoring the dependent records.
- UPDATE refers only to primary key change (not used often)
- DELETE is more common, possible behavior settings:
    - `CASCADE` -- delete the dependent records too,
    - `RESTRICT / NO ACTION` -- default behavior, do not allow deletion,
    - `SET NULL` -- set the dependent column to null, cancel the relationship
    - the decision depends on the application requirements!
</section>

<section markdown='1'>
## Foreign Key -- Cascade Example

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

</section>

<section markdown='1'>
## Foreign Key -- Cascade Example
{% highlight sql %}
CREATE TABLE contact (
    id_person integer NOT NULL
        REFERENCES person (id_person)
        ON DELETE CASCADE,
    ...
)
{% endhighlight %}

- If you delete a person, you probably want to delete his contacts too.
- When deleting from the `person` table `id_person=2`, contacts depending on that row will be deleted too.
</section>

<section markdown='1'>
## Foreign Key -- Set Null Example

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

</section>

<section markdown='1'>
## Foreign Key -- Set Null Example

{% highlight sql %}
CREATE TABLE person (
    id_location integer NOT NULL
        REFERENCES location (id_location)
        ON DELETE SET NULL,
    ...
)
{% endhighlight %}

- When the row with `id_location=11` is deleted from the `location` table, the
value in the `person.id_location` table is set to NULL.
- If a person looses her address, we don't want to kill her.
</section>

<section markdown='1'>
## Deleting Records
- Deleting records from the database is an uneasy task:
    - use `SET NULL` where a link can be lost,
    - use `CASCADE` where related records can be lost,
    - use `RESTRICT` in all other cases.
- Can you delete a user from information system?
    - What about the history of his operations?
    - Disabling is a better option.
    - What if you need to create someone with the same login / email?
- What if the requirement is that someone must always be responsible for an item?
</section>

<section markdown='1'>
## Database Portability
- The above (and below) differences make portability problematic.
- Making an application portable between multiple database systems is rarely wanted and usually inefficient.
- The goal of universal interfaces is mostly to ease programming.
- The biggest problems are not syntactic differences in SQL, but
different approaches:
    - What may perform fine on one server can lead to extreme HW requirements on another one.
    - Same queries lead to different **execution plans**.
</section>

<section markdown='1'>
## Index
- The most basic -- ISAM (Index Sequential Access Method):
    - Index files, Data files:
        - Like a contact directory (address book, phone book);
        - Speedup reads, slow down writes.
    - Different implementations -- hash tables, trees.
- An index should be created on:
    - Keys (usually done automatically)
    - Columns used in JOINs (should be foreign keys)
    - Columns used often in `WHERE` clauses (should be keys)
- Do not create indexes on all columns!
</section>

<section markdown='1'>
## Index

| Index File    |
| id | position |
|----|----------|
| 1  | 1        |
| 2  | 563      |
| 3  | 1124     |

| first\_name | last\_name | birth_day  | id |
|-------------|------------|------------|----|
| John        | Doe        | 2001-10-20 | 1  |
| Jenny       | Doe        | 1960-15-09 | 2  |
| Gina        | Rae        | NULL       | 3  |

</section>

<section markdown='1'>
## Things built on top of SQL
- Doctrine Query Language (DQL), Hibernate Query Language (HQL), Java Persistence Query Language (JPQL), JOOQ, ...
- Usually an ORM (Object-Relational Mapping) layer and the language which queries the *object model*.
    - The layer generates SQL queries.
- For some kinds of applications (or some parts), ORM is wonderful
    - For some parts is greatly annoying.
    - `u.articles` refers to the table:
</section>

<section markdown='1'>
## Things built on top of SQL cont.
{% highlight php %}
<?php
...
$query = $em->createQuery(
    'SELECT User FROM User
    LEFT JOIN User.address WHERE User.address.city = ?1'
);
$query->setParameter(1, 'Berlin');
$users = $query->getResult();
{% endhighlight %}
</section>

<section markdown='1'>
## Query Builders
- Not to be confused with ORM (most ORM support it).
- Fluent interface, Query Builder class:
    - Sometimes less cluttered than a plain SQL query;
    - Usually more cluttered than a normal query;
    - Hard to test the query outside the application;
    - Does not make developing *that much* easier;
    - In some cases it is almost necessary.

{% highlight php %}
<?php
...
$qb->select('person.*')
   ->orderBy('person.first_name', 'ASC')
   ->from('person')
   ->where('person.person_id = :id')
   ->setParameter(':id', 42);
{% endhighlight %}
</section>

<section markdown='1'>
## Checkpoint
- Is it better to set a foreign key to `ON DELETE CASCADE` or `ON DELETE SET NULL`?
- Can you store a date as an integer in the database?
- Does every table have an index?
- Is it better to use the MySQL or PostgreSQL DB server?
- Why can't you use `MAX()` to obtain ID of the last inserted record?
- Does every hour have 3600 seconds?
- Why can't you use the `text` data type everywhere?
- Can you obtain ID of the last inserted record of a different database user?
</section>
