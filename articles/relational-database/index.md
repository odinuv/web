---
title: Relational Database Systems
permalink: /articles/relational-database/
redirect_from: /en/apv/articles/relational-database/
---

* TOC
{:toc}

In the [previous article](/articles/database-systems/), I have described different types of
database systems. In this article I will concentrate on relational
database systems (RDBS). More specifically a **SQL ACID OLTP row-storage relational**
database system as this is a typical type of a database system used in transactional
applications.

## Relational algebra
Relational database systems are built on principles of
[relational algebra](https://en.wikipedia.org/wiki/Relational_algebra).
Relational algebra is a field of mathematics which allows modeling structures of
arbitrary data using **relations**. It is quite an old tool (roughly 1970),
which means that it is very well understood. Relational algebra also defines
the principles and basic properties of the SQL language, which I will describe
in the [next article](/articles/sql-join/).

**Relation** is a
[**Set**](https://en.wikipedia.org/wiki/Set_(mathematics)) of [**tuples**](https://en.wikipedia.org/wiki/Tuple).
A **Tuple** is a list of **attributes** (a<sub>1</sub>, a<sub>2</sub>, a<sub>3</sub>, ..., a<sub>k</sub>).
Each attribute has a **name**, **value** and **domain**.
a<sub>n</sub> marks the **value** of the n-th attribute in the tuple, a<sub>i</sub> in D<sub>i</sub>.

For example: A relation `person` is a set of tuples with three attributes with the
following names: `id`, `first_name`, `last_name`, `age`.
The relation contains the items with the following attribute values:

- id, first\_name, last\_name, age
- 1, John, Doe, 42
- 2, Jenny, Doe, 24

The **domain** (D<sub>n</sub>) of the n-th attribute represents a set of values allowed for
that attribute. This is like a data type but narrower. For example the domains for the attributes can be

- id -- INTEGER
- first_name -- STRING
- last_name -- STRING
- age -- AGE_INTEGER

While AGE_INTEGER is no valid data type, it would represent a domain with a somewhat limited integer.
Valid integers for humans are age probably somewhere in the interval 1..130. Therefore an attribute domain
can be seen as a data type with some additional constraints. The above relation would be formally written
as `PERSON(ID: INTEGER, AGE: AGE_INTEGER, NAME: STRING)`.

Once you know what relation is, you can start working with data mentally. Using the above `person`
relation you can describe some persons. Each person has the same attributes and therefore constitutes
a [**record**](https://en.wikipedia.org/wiki/Record_(computer_science))
(not a *world record*, nor *sound*, but an *entry*). Each record represents some
[**entity**](https://en.wikipedia.org/wiki/Entity) in the
real world (some existing person). Each record can be stored as a **row** in a table:

| id | first_name | last_name |
|----|------------|-----------|
| 1  | John       | Doe       |
| 2  | Jenny      | Doe       |

This means that the **relational databases** are typically
[row-oriented databases](/articles/database-systems/#storage) (but
they don't have to be). It also means that the terms **row**, **entity**, **record**, **tuple** are
often used interchangeably because they ultimately refer to the same thing.

As you can see right above, it is possible to write relations down using
**tables**. This means that:

- a *relation element (tuple)* becomes a *table row*
- a *relation attribute* becomes a *table column*
- a *name of an attribute* becomes a *table column name*
- an *attribute domain* becomes a *column domain*

The definitions of all relations (e.g. `PERSON(ID: INTEGER, AGE: AGE_INTEGER, NAME: STRING)`) used in a
single project are called **relational schema**.  The relational schema is therefore represented
by the table headers of all used tables (plus the domains and some other things, which are not visible
in the tables). In practice, the terms **table** and **relation** (and **schema**) are used
interchangeably. However they do not mean the same! It is particularly important to notice that
not every table is a relation. Apart from the obvious requirements (such as that the table must be
orthogonal), an important distinction is that a relation is a **set**, which means that each of its elements (tuples)
must be unique.

{: .image-popup}
![Relation -- Table](/slides/relational-database/relation.svg)

{: .note}
Do not confuse *Relations* with *relationships*. Relation in a relational database is a set of tuples.

### Operations
Relational algebra defines operations which can be performed on relations. Because relations
are sets, [standard set operations](https://en.wikipedia.org/wiki/Set_(mathematics)#Basic_operations)
are included in it. Relational algebra allows you to create a model of your data and
to work with that model before you actually implement the application. This is a good thing because
it saves a lot of time spent in writing a wrong application code. Relational algebra is the
basis of the SQL language. The SQL language offers much more features, but the core are relational algebra features.
The most important operations of relational algebra are:

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

### Set Operations
The following example shows two relations (R1 and R2) with attributed `color` and `style`. Then it
shows the results of the **union** (∪), difference (−) and intersection (∩) operations
(these are standard set operations, so you should be somewhat familiar with them).

<table>
    {%include /articles/relations.html %}
    <tr>
        <td>R1&nbsp;∪&nbsp;R2</td>
        <td>R1&nbsp;−&nbsp;R2</td>
        <td>R1&nbsp;∩&nbsp;R2</td>
    </tr>
    <tr>
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
                    <td><span style='color:green'>green</span></td>
                    <td style='font-style: italic'>italic</td>
                </tr>
                <tr>
                    <td><span style='color:red'>red</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
                <tr>
                    <td><span style='color:pink'>pink</span></td>
                    <td style='text-transform: uppercase'>capitalized</td>
                </tr>
            </table>
        </td>
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
                    <td><span style='color:red'>red</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <th>Color</th>
                    <th>Style</th>
                </tr>
                <tr>
                    <td><span style='color:green'>green</span></td>
                    <td style='font-style: italic'>italic</td>
                </tr>
            </table>
        </td>
        <td></td>
        <td></td>
    </tr>
</table>

### Relational Operations
The Following example defines the same two relations (R1 and R2) with attributes `color` and `style`
and shows the results of:

- projection -- An operation of relational algebra, which allows to select only some
**attributes** of the relation.
- selection / restriction -- An operation of relational algebra, which allows to select
only some **tuples** (records) of the relation.

<table>
    {%include /articles/relations.html %}
    <tr>
        <td>Projection: R1[Color]</td>
        <td>Projection: R1[Color, Style]</td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <th>Color</th>
                </tr>
                <tr>
                    <td><span style='color:white'>white</span></td>
                </tr>
                <tr>
                    <td><span style='color:green'>green</span></td>
                </tr>
                <tr>
                    <td><span style='color:red'>red</span></td>
                </tr>
            </table>
        </td>
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
                    <td><span style='color:green'>green</span></td>
                    <td style='font-style: italic'>italic</td>
                </tr>
                <tr>
                    <td><span style='color:red'>red</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
            </table>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>Selection: R1[(Color = white) ∨ (Color = red)]</td>
        <td>Both: (R1[Color = green])[Style]</td>
        <td></td>
    </tr>
    <tr>
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
                    <td><span style='color:red'>red</span></td>
                    <td style='text-decoration: underline'>underline</td>
                </tr>
            </table>
        </td>
        <td>
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

In the last example I want to show you the Θ-join (theta-join) operation. It allows connecting two
different relations together, so the relation R1 now has attributes `color1` and `style`, while
the relation R2 has attributes `color2`, `size`, `font`. To connect two relations together, you must
provide a condition on which the rows are assigned to each other. In the following example, the
condition is `color1 = color2`, which means that the output table will have:

- **all columns** from both relations,
- only the **combinations** of rows for which the condition is true.

You may have also noticed that I have skipped the **cartesian product** operation. A cartesian product
of two sets is a set which contains all combinations of all elements from both sets
-- in case of relations it would contain:

- **all columns** from both relations,
- **all combinations** of rows from both relations.

As you can see, a *join is a subset of the cartesian product* of the the two joined sets.
An example of joining relations R1 and R2:

<table>
    <tr>
        <td>R1</td>
        <td>
            <table>
                <tr>
                    <th>Color1</th>
                    <th>Style</th>
                </tr>
                <tr>
                    <td><span style='color:green'>green</span></td>
                    <td style='font-weight: bold'>bold</td>
                </tr>
                <tr>
                    <td><span style='color:green'>green</span></td>
                    <td style='font-style: italic'>italic</td>
                </tr>
                <tr>
                    <td><span style='color:red'>red</span></td>
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
                    <td><span style='color:red'>red</span></td>
                    <td>24</td>
                    <td style='font-family: Palatino'>Palatino</td>
                </tr>
                <tr>
                    <td><span style='color:red'>red</span></td>
                    <td>10</td>
                    <td style='font-family: Verdana'>Verdana</td>
                </tr>
                <tr>
                    <td><span style='color:green'>green</span></td>
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
                    <th>Color</th>
                    <th>Style</th>
                    <th>Color2</th>
                    <th>Size</th>
                    <th>Font</th>
                </tr>
                <tr>
                    <td><span style='color:green'>green</span></td>
                    <td style='font-weight: bold'>bold</td>
                    <td><span style='color:green'>green</span></td>
                    <td>19</td>
                    <td style='font-family: Monaco'>Monaco</td>
                </tr>
                <tr>
                    <td><span style='color:green'>green</span></td>
                    <td style='font-style: italic'>italic</td>
                    <td><span style='color:green'>green</span></td>
                    <td>19</td>
                    <td style='font-family: Monaco'>Monaco</td>
                </tr>
                <tr>
                    <td><span style='color:red'>red</span></td>
                    <td style='text-decoration: underline'>underline</td>
                    <td><span style='color:red'>red</span></td>
                    <td>24</td>
                    <td style='font-family: Palatino'>Palatino</td>
                </tr>
                <tr>
                    <td><span style='color:red'>red</span></td>
                    <td style='text-decoration: underline'>underline</td>
                    <td><span style='color:red'>red</span></td>
                    <td>10</td>
                    <td style='font-family: Verdana'>Verdana</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

If you would like to implement the above join operation in procedural code (e.g. PHP), it would look something
like this:

~~~ php?start_inline=1
$result = [];
foreach ($r1 as $row_r1) {
    foreach ($r2 as $row_r2) {
        if ($r1.color1 == $r2.color2) {
            $result[] = [
                $r1.color1,
                $r1.style,
                $r2.color2,
                $r2.size,
                $r2.font
            ];
        }
    }
}
~~~

## Key
Per the [relation definition](/articles/relational-database/#relational-algebra), it
is a **set** of *tuples*. A set contains each element
at most once, so it means the set items must be unique. And because it is impractical to
rely on chance and luck, there must be a way to ensure the uniqueness of each tuple -- **key**.

**Key** is a minimal set of attributes which uniquely identify every entity (tuple). A *minimal set*
means that each relation attribute can be used at most once (quite logical, isn't it?) and that
there should be no unnecessary attributes -- i.e. attributes which do not add anything to the
uniqueness of the key. Because the value of the key is unique, it is **identifying** for each tuple.
For example a person relation can have the following keys:

    - last name (simple key),
    - first name + last name (compound key),
    - first name + last name + date of birth (compound key),
    - SSN (social security number) (simple key),
    - person number (simple key),
    - passport number (simple key),
    - and many others.

A compound key is a key composed of multiple columns. It then means that the identifier is a
**combination** of values of all the columns in the key and that this combination (not the individual values)
must be unique.

Now if you think about the above keys, you're probably thinking that using only the last_name as
an **identifier** is plain stupid, because there can be multiple persons with the same last name and
it is not at all unique. Yes, but the same applies to all other keys as well, although it is not
so obvious. For example using a passport number is good only as long as you are using it
within **a single country**, there is no guarantee that the passport number is worldwide unique, so
a `passport number + country` would be a better option. But then you run into other issues -- no one
is required to have a passport. What is more there are quite a lot of people who have multiple
passports (each for a different country). In the end, none of the mentioned keys is perfect, though some
of them are better and some are worse.

The only perfect keys are those physically connected with the entity -- in case of persons it can be for
example DNA or fingerprint. In case of artificial things it can be a number imprinted into the thing.

However having those physical keys used in applications is often very impractical. Security concerns aside,
if you would use your DNA to create an e-shop account and then you'd like to have another one for your
company? How would you transfer an account to somebody else?

### Data Model
Questions like these bring us to the whole concept of a **data model**. Although I have used it several times
in this article already, I haven't explained it yet. The single most important feature about any
[model](https://en.wikipedia.org/wiki/Model) is that it is **simplified**. Therefore *data models* do
describe some data in a simplified (and generalized) way. This is incredibly important because the
real world is infinitely complex, so you must simplify so that your applications are not
infinitely complex too. There is a another whole [article article about data modelling](/articles/database-design/), but
for now it is important for you to understand that the data model (including the relations, and their keys)
should be only as good as **necessary**.

In other words, if you are making an address book application, you need a key to distinguish (identify)
the persons in the address book (so a nickname is a pretty good identifier). If you are making an e-shop,
then you only need to distinguish the accounts of the e-shop (so an email is a pretty good identifier).
Therefore you really ought to name the entity properly -- `account`. While this (hopefully) sounds natural
now, it is very important to understand the consequences of choosing a key.

### Key Types
You have already seen that keys can be **simple** (one column) or **compound** (multiple columns).
In application development everyone prefers simple keys, because for compound keys, you must
always use all parts of the key (because the parts themselves are not identifying) and that is
a lot of extra typing.

Because of all the trouble with keys, it is safest to use **artificial keys** in application
development. It is still important to define the natural keys as well, because the user works
with them. But your application should have its own simple key to identify records. This is usually
a number assigned to each record when it is created. Artificial keys are sometimes called
*dumb keys* because they have no meaning (no relationship to the actual data).

Artificial keys should never be displayed to
the end-user, because then they start being natural (as is the case with the passport number, SSN, license
plate, and many other originally artificial identifiers). There are some exceptions to this rule.
A notable exception are things which are supposed to be anonymous, e.g. results of an anonymous
questionnaire. To identify each response you need to generate a key for it and make that key
available to the end-user, because there is by design no natural way to identify that response.

A relation can contain as many keys as you want. Typically a table has at least two keys --
one artificial for the need of the application and one natural for the needs of the user.
For example a relation `USER(id, login, password, email, first_name, last_name)` can have
keys on columns `id`, `login` and `email`. This means that:

- The application can reliably reference the user by `id` (which will never change).
- The end-user can change her login or email (and it won't break anything, because the
application does not rely on it).
- The end-user is identified by her username to other users of the application
(she can keep her email private).
- The end-user may login to the the application by providing either her `email`
or `username` (both are identifying).

The above relation should however never contain a compound key on columns
`email` and `first_name` because if the email is unique, the `first_name`
does not add any new information to it. Such a key would not be a *minimal set*
of attributes.

If a table has multiple keys (which is common), one of the keys should be marked
as a **primary key**. This has nothing to do with relational algebra, but all
relational databases use it to organize the stored data internally. The choice
of a primary key is an implementation detail which allows the database server
to optimize data storage and access. Usually the automatically generated key
(a sequence of integers) is used.

Apart from *primary key* relational database systems allow you to define
a **unique key**. There is a great deal of confusion about this, because
a *unique key* is a [pleonasm](https://en.wikipedia.org/wiki/Pleonasm), because
every key is unique. In fact the *unique key* is simply any other key
than the primary one, so it is a normal key.

### Generating Key
The values of artificial keys have to be generated when a row is inserted into a
relation (table). The simplest solution is to use **auto increment** or
[**sequence**](/articles/database-tech/#automatically-generated-key)
(which are very similar, but still slightly different approaches to
the same thing) to generate a progression of integers usually starting from 1.
This approach is also used in
our [example database](/walkthrough/database/#database-schema) because it is a typical
approach to obtain a simple artificial identifier (**ID**). Keep in mind that it is not at all important
if the sequence of numbers is continuos or has gaps, it is also not important how large
the ID numbers are. The only important property is that they **mustn't repeat**.

Another approach is to use GUIDs. A
[GUID (Globally Unique Identifier)](https://en.wikipedia.org/wiki/Globally_unique_identifier) is
usually an identifier randomly generated using a sophisticated algorithm which makes
sure that there is very low chance that two identical numbers will be generated at the same time.
GUID is used in applications where it is impossible to use one central authority to generate
the simple sequence of numbers. This approach is used in large distributed systems or in
cases where one part of the table cannot be always connected to another part. E.g. assume you
have two physical tables which represent a single relation. When you want to insert data
into that relation you cannot reliably create a sequence of numbers -- you can check the
other table for the largest number (if possible), but by the time you receive the response from
the remote system, the number could have already changed. There is an example
in a [separate article about inserting](/walkthrough/backend-insert/advanced/).

## Foreign Key
A foreign key is quite special, it represents **relationships** between **entities**
(relations). a foreign key represents a **referential integrity constraint**. So far
I have only briefly mentioned that a data model can contain multiple relations. If
it does (which is almost always), there needs to be a way to define that some
relations are linked together.

To define a foreign key an attribute of one relation (R2) on which the foreign Key is
defined must have either:

- a value of an attribute of another relation (R1) (preferably key),
- empty value (`NULL`).

Relation R1 is then called **master** (**parent**) relation and
R2 is called **detail** (**dependent**) relation. Notice that the referenced relation (R1)
is master. This is because the *origin* of the key is there. Notice that
there is a condition hidden in the foreign key definition above: If an attribute
value of a record in one relation is the same as an attribute value of a record
 in anther relation, those two records are related. Can you remember where
 a similar condition was used?

{: .solution}
It is the condition as in [*join*](/articles/sql-join/#joining-tables). Foreign keys are very often used as
join conditions.

For example in the [example database](/walkthrough/database/#database-schema), there are relations `person` and
`contact`. `contact` contains individual values for different persons (an email address,
a phone number, etc.), these must be assigned to a particular person to make sense.
Therefore the `contact` relation has the attribute `id_person` which is a *reference*
to the `id_person` column in the `person` table. The `person` table is the master table
and the `contact` relation is the detail table (provides contact details to persons).

All foreign keys in the relation `CONTACTS(ID_CONTACT, ID_PERSON, ID_CONTACT_TYPE, CONTACT)` are:

- `FOREIGN KEY (id_contact_type) REFERENCES contact_type(id_contact_type)` on `id_contact_type`
column, master table is `contact_type`.
- `FOREIGN KEY (id_person) REFERENCES person(id_person)` on `id_person` column, master
table is `person`.

It is possible to have an entity (relation) which has only foreign keys and has
no own keys. Such an entity is called a **Weak entity**. In
the [example database](/walkthrough/database/#database-schema) is is
the `person-meeting` entity. The `person-meeting` entity represents an attendance of
a person on a meeting (why this is a separate table is described in
[article about database design](/articles/database-design/#using-e-r-model)).
The identifier of the attendance is the combination of
meeting (`id_meeting`) and person (`id_person`) which must be unique (no person can
attend the same meeting twice). So this is the primary (and only) key of the relation.
Because it is composed of only foreign keys, the entity is weak. This somewhat corresponds
to that you would not probably intuitively consider an *attendance* as an entity.

## SQL Language
SQL is a **programming language** which is used to communicate with (relational)
database systems. SQL is most often used to:

- Query the state of a database (aka retrieve data);
- Send requests for database state change (aka modify data);
- Define a database schema (aka create tables).

SQL is a declarative language, this means that you define **What** should be
done, not **how**. It means that it has no such things as assignment, condition or
loop, which you have probably seen in other programing languages. Also, in SQL the
source code is split into **SQL queries**. Each query represents a single
action (get data, update data, etc.) you want to execute on the database server.

The database server contains an interpreter of the SQL language, which
converts the SQL queries to a procedural code and executes them. This has
the advantage that the sender (your application) does not care how the data
is physically stored and organized. The advantage is that it makes working
with the database much simpler as you don't need to worry about many of the
implementation details. The disadvantage of this is you cannot rely on
the implementation details. For example the order of columns or rows
in a database is not guaranteed and can change even between individual queries.

SQL is quite an old language, it is based on the prototype **Sequel** language (1974).
It was first (ISO & ANSI) standardized in 1986 and it is still actively developed
(the last standard version is from 2011). The database server implementations are
quite behind the standards so currently most database servers support
SQL-92 or SQL-1999 versions. SQL has a lot of dialects and derivatives so
each database vendor offers features not supported somewhere else. There is a lot
of confusion about this and there are migration tools which allow you to
move your application from one database vendor to another database vendor.

## Summary
In this article I have described the principles of relational algebra. There
is much more to it -- there are other operations than the ones I have described,
there are mathematical proofs that it is working, etc. Relational algebra is
something that you don't really need when creating a database application.
But the core principles of the SQL language are relational operations and that is
one of the reasons I have written this article -- if you understand the principles,
you can use any relational database server with just a few looks in the manual.

### New Concepts and Terms
- relation
- tuple
- set
- attribute
- table
- domain
- relational algebra
- union
- difference
- intersection
- cartesian product
- projection
- selection / restriction
- join
- simple key
- compound key
- data model
- artificial key
- auto-generated key
- primary key
- foreign key
- master -- detail
- SQL language
