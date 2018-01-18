---
layout: slides
title: Relational Database Systems
description: Principles of relational database systems and introduction to SQL language.
transition: slide
permalink: /slides/relational-database/
redirect_from: /en/apv/slides/relational-database/
---

<section markdown='1'>
## Relational Database Systems (RDBS)
- A typical and most common example of **ACID** database systems.
- Data is modeled using relations (look like tables).
- Quite old (around 1970).
- Forms a basis for the SQL language.
- Relational database system store **entities** / **records** / **rows**.
</section>

<section markdown='1'>
## Relation -- Definition
- Relation -- **Set** of [**tuples**](https://en.wikipedia.org/wiki/Tuple).
- **Tuple** is a list of **attributes** (a<sub>1</sub>, a<sub>2</sub>, a<sub>3</sub>, ..., a<sub>k</sub>).
- An attribute has a **name**, **value** and **domain**.
- a<sub>n</sub> -- **value** of the n-th attribute in the tuple, a<sub>i</sub> in D<sub>i</sub>.
- D<sub>n</sub> -- **domain** of the n-th attribute (a set of values allowed for
the attribute).
- A<sub>n</sub> -- **name** of the n-th attribute.
- `PERSON(ID: INTEGER, AGE: AGE_INTEGER, NAME: STRING)`
- Do not confuse *Relations* with *relationships*!
</section>

<section markdown='1'>
## Relation
- Relations are usually written down using tables.
- Relational schema -- the names and headers of tables;
    - definition of the table form (not data).
- Attribute -- a table column.
- Relation element (tuple) -- a table row.
- Attribute name -- the name of a table column.
- Attribute domain -- a data type of the table column.
- In practice, the terms: relation, schema, tables are used interchangeably.
    - They do not mean the same however!
</section>

<section markdown='1'>
![Relation -- Table](/slides/relational-database/relation.svg)

</section>

<section markdown='1'>
## Relational algebra
- description of a data structure using algebra and logic
- a simple and proven approach
- allows working with the data model before anything is implemented
    - saves a lot of time
- built upon set operations:
    - product, union, intersection, difference
- basis for the SQL language
</section>

<section markdown='1'>
## RA -- Operations
- Standard *set operations*:
    - compatible attributes (columns):
        - union,
        - difference,
        - intersection,
    - cartesian product.
- Special operations:
    - projection,
    - selection / restriction,
    - Θ-join (theta-join),
    - natural join.
</section>

<section markdown='1'>
## RA -- Set Operations

<table>
    {%include /slides/relations.html %}
    <tr>
        <td>R1&nbsp;∪&nbsp;R2</td>
        <td>
            <table>
                <tr>
                    <th>Color</th>
                    <th>Style</th>
                </tr>
                <tr>
                    <td><span style='color:white'>white</span></td>
                    <td style='font-weight: bold'>bold</td>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td style='font-style: italic'>italic</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
                <tr>
                    <td><span style='color:pink'>pink</span></td>
                    <td style='text-transform: uppercase'>capitalized</td>
                </tr>
            </table>
        </td>
        <td>R1&nbsp;−&nbsp;R2</td>
        <td>
            <table>
                <tr>
                    <th>Color</th>
                    <th>Style</th>
                </tr>
                <tr>
                    <td><span style='color:white'>white</span></td>
                    <td style='font-weight: bold'>bold</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</section>


<section markdown='1'>
## RA -- Set Operations

<table>
    {%include /slides/relations.html %}
    <tr>
        <td>R1&nbsp;∩&nbsp;R2</td>
        <td>
            <table>
                <tr>
                    <th>Color</th>
                    <th>Style</th>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td style='font-style: italic'>italic</td>
                </tr>
            </table>
        </td>
        <td></td>
        <td></td>
    </tr>
</table>
</section>

<section markdown='1'>
## RA -- Projection
<table>
    {%include /slides/relations.html %}
    <tr>
        <td colspan='2'>R1[Color]</td>
        <td colspan='2'>R1[Color, Style]</td>
    </tr>
    <tr>
        <td colspan='2'>
            <table>
                <tr>
                    <th>Color</th>
                </tr>
                <tr>
                    <td><span style='color:white'>white</span></td>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                </tr>
            </table>
        </td>
        <td colspan='2'>
            <table>
                <tr>
                    <th>Color</th>
                    <th>Style</th>
                </tr>
                <tr>
                    <td><span style='color:white'>white</span></td>
                    <td style='font-weight: bold'>bold</td>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td style='font-style: italic'>italic</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</section>

<section markdown='1'>
## RA -- Restriction / Selection
<table>
    {%include /slides/relations.html %}
    <tr>
        <td colspan='2'>R1[(Color = white) ∨ (Color = cyan)]</td>
        <td colspan='2'>(R1[Color = yellow])[Style]</td>
    </tr>
    <tr>
        <td colspan='2'>
            <table>
                <tr>
                    <th>Color</th>
                    <th>Style</th>
                </tr>
                <tr>
                    <td><span style='color:white'>white</span></td>
                    <td style='font-weight: bold'>bold</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
            </table>
        </td>
        <td colspan='2'>
            <table>
                <tr>
                    <th>Style</th>
                </tr>
                <tr>
                    <td style='font-style: italic'>italic</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</section>

<section markdown='1'>
<table style='margin-top:-35px'>
    <tr>
        <td>R1</td>
        <td>
            <table>
                <tr>
                    <th>Color1</th>
                    <th>Style</th>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td style='font-weight: bold'>bold</td>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td style='font-style: italic'>italic</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
            </table>
        </td>
        <td>R2</td>
        <td>
            <table>
                <tr>
                    <th>Color2</th>
                    <th>Size</th>
                    <th>Font</th>
                </tr>
                <tr>
                    <td><span style='color:pink'>pink</span></td>
                    <td>17</td>
                    <td style='font-family: Verdana'>Verdana</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td>24</td>
                    <td style='font-family: Palatino'>Palatino</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td>10</td>
                    <td style='font-family: Verdana'>Verdana</td>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td>19</td>
                    <td style='font-family: Monaco'>Monaco</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan='4'>ϴ Join &ndash; R1[Color1 = Color2]R2</td>
    </tr>
    <tr>
        <td colspan='4'>
            <table>
                <tr>
                    <th>Color1</th>
                    <th>Style</th>
                    <th>Color2</th>
                    <th>Size</th>
                    <th>Font</th>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td style='font-weight: bold'>bold</td>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td>19</td>
                    <td style='font-family: Monaco'>Monaco</td>
                </tr>
                <tr>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td style='font-style: italic'>italic</td>
                    <td><span style='color:yellow'>yellow</span></td>
                    <td>19</td>
                    <td style='font-family: Monaco'>Monaco</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td style='text-decoration: underline'>underline</td>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td>24</td>
                    <td style='font-family: Palatino'>Palatino</td>
                </tr>
                <tr>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td style='text-decoration: underline'>underline</td>
                    <td><span style='color:cyan'>cyan</span></td>
                    <td>10</td>
                    <td style='font-family: Verdana'>Verdana</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</section>

<section markdown='1'>
## Key
- Relation is a **set** of tuples -- tuples must be **unique**.
- **Key** is a minimal set of attributes which uniquely identify every entity (tuple) - e.g person:
    - first name + last name + date of birth (compound key);
    - SSN (social security number) (simple key);
    - person number (simple key).
    - How good are they?
- In applications it is safest to use **artificial keys**:
    - also called **dumb keys** -- have no meaning.
- Key is the core **integrity constraint**.
- **Weak entity** -- has only a foreign key (e.g. `person-meeting`).
</section>

<section markdown='1'>
## Key cont.
- There may be multiple keys in a table:
    - PERSON(ID, SSN, FIRST_NAME, LAST_NAME, PASSPORT_NO, DATE_OF_BIRTH),
    - ID,
    - SSN,
    - PASSPORT_NO,
    - FIRST_NAME + LAST_NAME + DATE_OF_BIRTH,
    - but not SSN + PASSPORT_NO!
- One of the keys should be marked as a **primary key**.
- The selection of the **primary key** is an **implementation detail**.
    - It should be the smallest and quickest for machines.
</section>

<section markdown='1'>
## Foreign Key
- Represents **relationships** between **relations** (entities).
- The foreign key is **referential integrity constraint**.
- An attribute of one relation (R2) on which a Foreign Key is defined must have either:
    - A value of an attribute of another relation (R1) (preferably key)
    - An empty value (NULL)
- R1 -- master / parent relation
- R2 -- detail / dependent relation
</section>

<section markdown='1'>
## Foreign Key -- Example
- `CONTACTS(ID_CONTACT, ID_PERSON, ID_CONTACT_TYPE, CONTACT)`
- There are foreign keys on ID_PERSON and ID_CONTACT_TYPE columns:
    - `FOREIGN KEY (id_contact_type) REFERENCES contact_type(id_contact_type)`
    - `FOREIGN KEY (id_person) REFERENCES person(id_person)`
- A master table is `person` and `contact_type`.
</section>

<section markdown='1'>
## SQL Language
- SQL is a **programming language** which can be used to communicate
with a (relational) database system.
- SQL is based on relational algebra, but has many extensions.
- SQL is most often used to:
    - Query the state of the database (aka retrieve data);
    - Send requests for database state change (aka modify data);
    - Define the database schema (aka create tables).
</section>

<section markdown='1'>
## SQL Requirements / Properties
- Data is stored in form of tables (which should be relations).
- The sender (= application) does not care about the physical data storage.
- The order of anything is not guaranteed or assumed:
    - columns are identified by their names,
    - rows are identified by the key values.
- Declarative language:
    - Define **What** should be done, not **how**.
    - No assignment, conditions, loops.
    - The SQL interpreter generates and executes the procedure.
</section>

<section markdown='1'>
## SQL Language
- First prototype: **Sequel** (1974)
- Old, but an actively developed language:
    - ISO & ANSI standards: 1986--2011,
    - 8 versions so far.
- The standard deals with the interpreter, it is not really good place to learn SQL.
- Real-world implementations are behind:
    - SQL-92 is available almost everywhere,
    - SQL-1999 is available with top vendors.
- A lot of dialects and derivatives.
</section>

<section markdown='1'>
## SQL Language -- naming conventions
- **Database objects** -- tables, columns, keys.
- Anything is allowed in name, but must be quoted (`"`).
- To avoid quotes (across different vendors):
    - use no special characters (allowed: `a-z`, `0-9`, `_`),
    - use underscores for delimiters (`id_person`),
    - use either all lower-case or all upper-case,
    - keep it reasonably short (less than approx 30 characters).
- Try to avoid language keywords (SQL has many of them).
</section>

<section markdown='1'>
## General naming conventions
- Think twice about each name.
- The name should be as specific as possible.
    - What does an `item` represent?
    - Would a `product` be better?
- Use no abbreviations (except for `id`).
    - If you must, use known abbreviations.
    - What does `prsn_fn` mean?
- Avoid repetition:
    - e.g. the column `person_name` in the table `persons`;
    - except for columns with keys (`id_person`).
</section>

<section markdown='1'>
## SQL -- Introduction
- Forget procedural programming, SQL is something completely different.
- Using SQL, you define **what** should be done.
    - This is surprisingly more difficult than defining **how** something should be done.
- Nested database objects are accessed with `.` convention:
    - `schema.table.column`,
    - e.g. `my_project.persons.id_person`
    - The schema rarely changes during application run, so it is omitted.
    - Omitting a table name is discouraged except for very simple queries.
</section>

<section markdown='1'>
## SQL -- Data types
- Each database system has different data types, but there are some common:
    - character / character varying / varchar -- a string limited by some length,
    - text / longtext / (whatever)text -- a string virtually unlimited (cell size over 1GB),
    - number / numeric / decimal -- a decimal number with some range (precision, scale),
    - int / integer -- a whole number,
    - datetime / timestamp -- a time value.
</section>

<section markdown='1'>
## SQL -- Syntax Conventions
- Functions and keywords are written in UPPERCASE.
- *Italics* marks placeholder:
    - DELETE FROM *table*
- `[ ]` -- an optional part.
- `{ }` -- a set of elements.
- `|` -- an exclusive selection.
</section>

<section markdown='1'>
## SQL -- Syntax Conventions Examples
- `[ LEFT | RIGHT ] JOIN` represents:
    - `LEFT JOIN`
    - `RIGHT JOIN`
    - `JOIN`
- `a { = | < | > } b` represents:
    - `a = b`
    - `a < b`
    - `a > b`
</section>

<section markdown='1'>
## SQL Commands
- Define the structure of data (database schema) -- DDL (data definition language):
    - `CREATE {SCHEMA | TABLE | COLUMN | INDEX }`
    - `ALTER {SCHEMA | TABLE | COLUMN | INDEX }`
    - `DROP {SCHEMA | TABLE | COLUMN | INDEX }`
- Manipulate with data -- DML (data manipulation language):
    - `INSERT`, `SELECT`, `UPDATE`, `DELETE`
- In certain areas, there can be considerable differences between different database servers!
</section>

<section markdown='1'>
## SQL Commands and Tables
- SQL command results are:
    - `SELECT` command returns results in a table,
    - other commands return only true/false.
- Tables can be:
    - physical -- defined in the database schema
    - virtual:
        - persistent -- **views** (external schema)
        - volatile -- the result of a `SELECT` query
</section>

<section markdown='1'>
## Database Views
- A view is a database object which looks like a table.
- A view is defined by a `SELECT` query.
- A view is usually only for reading and does not contain the actual copy of the data.
    - I.e. it is updated as the underlying tables (used in the defining query) are updated.
- A view (or any `SELECT` query) does not have to be a relation!
- Views are used:
    - for same reasons as functions in procedural programming,
    - to define user sections of the database schema.
</section>

<section markdown='1'>
## Checkpoint
- Why shouldn't you display the value of a dumb (artificial) key to the end-user?
- If one relation has X rows and another relation has Y rows, how many rows can a theta-join of those relations have?
- And how about an intersection?
- Does every relation need to have a key?
- How about a table?
- What is the difference between a relation and a (database) table?
- What is a dot `.` used for in SQL?
- Must every relation have a foreign key?
- Is is possible to write union in the SQL language?
</section>
