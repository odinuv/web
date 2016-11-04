---
layout: slides
title: Databases -- Technical Details
description: Database data types, automatically generated keys. 
transition: slide
permalink: /en/apv/slides/database-tech/
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
    - connect to database (`connect` or constructor),
    - execute a query (`exec`, `execute`, `prepare`),
    - fetch a result of SELECT query (`fetch`, `open`, `next`, `seek`) -- work with **resultset**
    - retrieve an error result (`error`, `lastError`).
</section>

<section markdown='1'>
## Pagination
- Uses the keywords `LIMIT` and `OFFSET` on Postgres;
    - Other systems `TOP`, `BOTTOM`, `ROWNUM` keywords.
- `SELECT * FROM person ORDER BY id_person LIMIT 10 OFFSET 5`
- Remember to include `ORDER BY`! Otherwise you'll have random results.
- Criticism:
    - If it is not on the first page, search better.
    - Maybe considered user unfriendly (combined with bad search).
- Other application: "TOP 10 best customers"
    - How many results should such query return?     
</section>

<section markdown='1'>
## Data Types -- String
- character_varying(size) / varchar(size) / nvarchar(size)
    - standard string limited by size
    - size in bytes for ANSI strings
    - size in characters for Unicode strings
- char(size) / character(size) / nchar(size)
    - string limited by size
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
    - 2<sup>15</sup> -- 32 768
- whole numbers:
    - signed (with sign) -- allows negative numbers
    - unsigned (without sign) -- allows only positive numbers
    - do not combine them!
</section>

<section markdown='1'>
## Data Types -- Decimal Numbers
- `real` / `float` / `double`:
    - floating point decimal point;
    - inexact! -- e.g. `2 != 6 / 3` !
    - real range 1e<sup>-37</sup>..1e<sup>37</sup>
    - double range 1e<sup>-307</sup>..1e<sup>308</sup>
- `number` / `numeric` / `decimal(precision, scale)`:
    - fixed decimal point;
    - precision -- maximum number of digit;
    - scale -- number of digits after decimal point.
- `money` -2<sup>63</sup>..2<sup>63</sup> = 92 233 720 368 547 758.08
</section>

<section markdown='1'>
## Data Types -- Timestamp
- Date and time is stored as **timestamp** (an unambiguous point in time).
- Usually number of milliseconds / microseconds from 1.1.1970.
- Range from 4713 BC to 294276 AD.
- Conversion to string date is **very complex**, never ever do it yourself!
- Timestamp fixes leap days, leap seconds, DST...
- Timestamp should contain time zone (use UTC whenever possible).
- Does not allow to store incomplete dates ('January 2016'), use separate columns.
</section>

<section markdown='1'>
## Data Types -- Date Types
- `datetime` / `date` / `time`:
    - In mysql `datetime` is *sort of same* as timestamp
- 'timestamp', 'time', 'date' cannot be used to store date / datetime interval:
    - never assume that an hour has 3600 seconds (can be from 0 up to 7200);
    - because of leap days, seconds;
    - because of DST;
    - `interval` -- store interval of date time values.
</section>

<section markdown='1'>
## Data Types -- Date Alternative
- You may encounter using native application format:
   - column data type is integer
   - use timestamp of the application language:

{% highlight php %}
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
    - non-atomic (1NF), impossible to select part of date
    - ordering works fine though
    - impossible to store or compute interval
    - brings back application and database dependency
    - unreliable when more applications use the database
</section>

<section markdown='1'>
## Data Types -- Binary Data
- bit / boolean / binary / bytea -- a single value,
    - BLOB / image -- binary data,
    - BLOB -- binary large object (LOB, LO).
- Details of working with LO are dependent on the database interface.
    - Send escaped data within the SQL string (limited size), 
    - Binary data must be sent via special functions.
- Use this to store medium sized files, better then storing them in file system.
</section>

<section markdown='1'>
## Automatically Generated Key
- The most commonly used type of primary key:
    - abstract record identifier,
    - independent on outside conditions,
    - **auto-increment** or **sequence**,
    - simpler to use than compound keys (all parts must be used).
- There should be a natural key defined too (for the end-user).
- No database fully follows the standard (historical reasons).
</section>

<section markdown='1'>
## Auto-increment in PostgreSQL
- The column is assigned special data type `serial` when creating table.
    - `CREATE TABLE table (id serial NOT NULL,` ...
    - creates a **sequence** to generate the values;
    - assigns default value to: 
        - `nextval('sequence_name')`
    - cannot be exported exactly (column is integer).
- To obtain last value call: 
    - `SELECT currval('sequence_name')`,
    - or `$db->lastInsertId('sequence_name')` in PDO.
- If value is inserted explicitly, sequence won't update!
    - Subsequent inserts will probably fail!
</section>

<section markdown='1'>
## Currval or Max?
- To obtain the last value of inserted row, you **must always** use predefined functions.
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
- The last insert value is tied to **database session**.
</section>

<section markdown='1'>
## Integrity Constraints
- Basic ones on single table:
    - NOT NULL -- column with required value
    - `UNIQUE (KEY)`, `PRIMARY (KEY)` -- keys
    - `CHECK` -- arbitrary rules, not supported by many systems
- Referential:
    - `FOREIGN KEY` -- dependency between tables
</section>

<section markdown='1'>
## Foreign Key
- It is not possible to UPDATE / DELETE record while ignoring the dependent records. 
- UPDATE refers only to change of the primary key (not used often)
- DELETE is more common, possible behavior settings:
    - `CASCADE` -- delete the dependent records too,
    - `RESTRICT / NO ACTION` -- default behavior, do not allow deletion,
    - `SET NULL` -- set dependent column to null, cancel the relationship
    - decision depends on the application requirements!
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

- If you delete a person, you probably want to delete their contacts too. 
- When deleting from `person` table `id_person=2`, contacts depending on that row will be deleted too.
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

- When the row with `id_location=11` is deleted from `location` table, the 
value in the `person.id_location` table is set to NULL.
- If a person looses their address, we don't want to kill them.
</section>

<section markdown='1'>
## Deleting Records
- Deleting records from database is uneasy task:
    - use `SET NULL` where link can be lost,
    - use `CASCADE` where related records can be lost,
    - use `RESTRICT` in al other cases.
- Can you delete a user from information system?
    - What about the history of operations?
    - Disabling is a better option.
    - What if you need to create someone with same login / email?
- What if the requirement is that someone must always be responsible for an item?         
</section>

<section markdown='1'>
## Database Portability
- The above (and below) differences make portability problematic.
- Making and application portable between multiple database system is rarely wanted and inefficient.
- The goal of universal interfaces is mostly to ease programming.
- The biggest problems are not syntactic differences in SQL, but 
different approaches:
    - What may perform fine on one server can lead to extreme HW requirements on another.
    - Same queries lead to different **execution plans**.    
</section>

<section markdown='1'>
## Database Structure -- Create

{% highlight sql %}
CREATE TABLE table_name ( 
    column data_type [NOT NULL] [DEFAULT value] [PRIMARY KEY]
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
- Database System have very complex configurations:
    - Can cause big changes in behavior;
    - E.g. MySQL / MariaDB storage engines (MyISAM × InnoDB)
- Different implementations of auto-increment
</section>

<section markdown='1'>
## Data Dictionary
- The structure of every DB is stored in another DB.
- Shared database `information_schema`: invisible, accessible, read-only. 
- Show tables in information_schema:
    - `SELECT * FROM information_schema.tables WHERE table_schema = 'information_schema'`
- Show columns of a table:    
    - `SELECT * FROM information_schema.columns WHERE table_name = 'person'`
- If unsupported, there are commands like `DESCRIBE`, `SHOW`
- Modifications throught commands `ALTER`, `RENAME`, `DROP`, `MODIFY`, `ADD` ...
</section>

<section markdown='1'>
## Index
- The most basic -- ISAM (Index Sequential Access Method):
    - Index files, Data files:
        - Like a contact directory (address book, phone book);
        - Speedup read, slow down writes.
    - Different implementations -- hash tables, trees.
- Index should be created on:
    - Keys (usually done automatically)
    - Columns used in JOINs (should be foreign keys)
    - Columns used often in `WHERE` clauses (should be keys)
- Do not create index on all columns!    
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
## Things build on top of SQL
- Doctrine Query Language (DQL), Hibernate Query Language (HQL), Java Persistence Query Language (JPQL), JOOQ, ...
- Usually ORM (Object-Relational Mapping) layer and language which queries the *object model*.
    - The layer generates SQL queries.
- For some kinds of applications (or some parts), ORM is wonderful
    - For some parts is greatly annoying.
    - `u.articles` refers to table:
</section>

<section markdown='1'>
## Things build on top of SQL cont.
{% highlight php %}
$query = $em->createQuery(
    'SELECT COUNT(a.id) FROM CmsUser u 
    LEFT JOIN u.articles a WHERE u.username = ?1 
    GROUP BY u.id'
);
$query->setParameter(1, 'jwage');
{% endhighlight %}
</section>

<section markdown='1'>
## Query Builders
- Not to be confused wit ORM (most ORM support it).
- Fluent interface, Query Builder class:
    - Sometimes less cluttered than plain SQL query;
    - Usually more cluttered than normal query;
    - Hard to test the query outside application;
    - Does not make developing easier anyway;
    - In some cases it is almost necessary.

{% highlight php %}
$qb->select('u')
   ->from('User u')
   ->where('u.id = ?1')
   ->orderBy('u.name', 'ASC')
   ->setParameter(1, 100);
{% endhighlight %}
</section>

<section markdown='1'>
## Checkpoint
- Is it better to set foreign key to `ON DELETE CASCADE` or `ON DELETE SET NULL`?
- Can you store date as integer in database?
- Does every table have an index? 
- Is it better to use MySQL or PostgreSQL DB server?
- Why can't you use `MAX()` to obtain id of the last inserted record?
- Does every hour have 3600 seconds?
- Why can't you use `text` data type everywhere?
- Can you obtain ID of the last inserted record of a different database user?
</section>
