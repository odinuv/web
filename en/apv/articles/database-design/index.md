---
title: Database Design
permalink: /en/apv/articles/database-design/
---

* TOC
{:toc}

In the previous articles, you learned about the 
[principles of relational databases](/en/apv/articles/relational-database/),
the [basics of SQL](/en/apv/articles/sql-join/) and 
[aggregation in SQL](/en/apv/articles/sql-aggregation/). In all those articles, I used 
[example database](/en/apv/walkthrough/database/#import-database) from 
the [project](/en/apv/course/#project-assignment). There are a number of questions you should
be asking yourself by now, such as:

- Why is the data structure designed as it is?
- Why does the database have so many tables?
- Can I add another table?
- Can I add another column?

In this article, I'll show you how to design your own database structure. The approach I
will describe has no formal methodology. It is a kind of common-sense approach which is 
suitable for small or middle sized databases. A middle sized database is
something you can still [keep in your head](http://paulgraham.com/head.html) -- for most people it is around one
hundred tables.

## Database Modeling
Database (or data) modeling is a process in which you **analyze** the application requirements
(usually retrieved from your customers) and **design** a
[database schema](/en/apv/articles/relational-database/#relational-algebra).
Database schema describes the structure of data stored in your database. Before you
move on to the application implementation, you should **validate** whether the
schema follows certain good practices (normal forms) and fulfills the customer 
requirements.

The outcome of database modeling is **database model**. There are many approaches
that can be used, for relational database, the best and most common option is
**Entity-Relationship model**. This model is written down using ERD (Enity-Relationship Diagram).
An alternative to ER model is e.g. [Object Oriented Model](https://en.wikipedia.org/wiki/Object-oriented_programming).

### E-R Modeling
[E-R Modeling](https://en.wikipedia.org/wiki/Entity–relationship_model) works with the following concepts:
- **entity** -- identifiable real world object (table record)
- entity type -- class of real world object
- **relationship** -- link between entities
- attribute -- property of entity or relationship
- value -- actual value of an attribute
- attribute domain -- set of allowed values for an attribute
- key -- set of attributes which identify an entity

If you still remember the [principles of relational databases](/en/apv/articles/relational-database/#relational-algebra), 
the above should
be very familiar to you. It uses the same words and same concepts as relational 
algebra -- apart from *relation* and *algebra* :) E-R Modeling is a tool to create
diagrams, which nicely convert to relational databases.
If you find E-R modelling similar to [object oriented modeling](https://en.wikipedia.org/wiki/Object-oriented_programming), 
that is good too, because
they are boot tools to solve the same problem -- describe and design structure of data.

{: .note}
Do not confuse *relation* and *relationship*! While *relationship* is colloquially abbreviated
to *relation*, in databases, they have to be distinguished. Can you describe the difference?

{: .solution}
A relation is a set of entities, usually written down as a table. A relationship is
a connection between entities.

### E-R Diagram
The most common representation of an E-R model is an ERD (E-R Diagram). There are 
multiple variants - e.g. Classic (conceptual), Crow's foot, ...
Probably the most common one is Crow's foot (which I will show you later). I will Start
with the Classic / Conceptual diagram, because it is very useful at the beginning of
database design and it is especially good for beginners -- it requires only Brain and 
Pen & Paper. This means, that as you get more proficient, you can safely abandon it.

The Conceptual diagram uses the following notation:

![ERD Legend](/en/apv/articles/database-design/erd-legend.svg)

## Analysis Example
Let's look at the [project assignment](/en/apv/course/#project-assignment):

    Create a web application for recording persons and contacts. The main goal of the application is 
    to record persons (friend, acquaintances), their addresses, relationships and meetings.
    Every person can have a name, nickname, age, location and contacts. Each person can have any
    number of contacts (mobile, Skype, Jabber, ....). A person can have more contacts of the
    same type (e.g. two emails). Each person can have any number of relationships
    with other persons in the database. Each relationship should have type (friend, fiend, acquaintance, spouse, ...)
    and description. Contact and relationship types are recorded in database and can be modified by
    the end-user. The application also records meetings between persons. Each meeting can be joined by any number of persons.
    Each meeting should have a place and date.
    The application must allow user friendly of entering and modifying the data. Take advantage of the proposed schema,
    create a database and implement the entire application. 

Now start with identifying entities and their attributes. The simplest approach is to simply underline
every **noun** in the requirements description (I will ignore general terms: **data**, **database**, **goal**,
and **application**):

Create a web application for recording <span class='underline'>persons</span> 
and <span class='underline'>contacts</span>. The main goal of the 
application is to record <span class='underline'>persons</span> (
<span class='underline'>friend</span>, <span class='underline'>acquaintances</span>), their 
<span class='underline'>addresses</span>, <span class='underline'>relationships</span> and 
<span class='underline'>meetings</span>. Every <span class='underline'>person</span> can have a 
<span class='underline'>name</span>, <span class='underline'>nickname</span>, 
<span class='underline'>age</span>, <span class='underline'>location</span> and 
<span class='underline'>contacts</span>. Each <span class='underline'>person</span> can have any
number of <span class='underline'>contacts</span> (
<span class='underline'>mobile</span>, <span class='underline'>Skype</span>, 
<span class='underline'>Jabber</span>, ....). A <span class='underline'>person</span> can have more 
<span class='underline'>contacts</span> of the same <span class='underline'>type</span> (e.g. two 
<span class='underline'>emails</span>). Each <span class='underline'>person</span> can have any 
number of <span class='underline'>relationships</span<
with other <span class='underline'>persons</span> in the database. Each 
<span class='underline'>relationship</span> should have <span class='underline'>type</span> (
<span class='underline'>friend</span>, <span class='underline'>fiend</span>, 
<span class='underline'>acquaintance</span>, <span class='underline'>spouse</span>, ...)
and <span class='underline'>description</span>. <span class='underline'>Contact</span> and 
relationship <span class='underline'>types</span> are recorded in database 
and can be modified by the end-user. The application 
also records <span class='underline'>meetings</span> between <span class='underline'>persons</span>. Each 
<span class='underline'>meeting</span> can be joined by any number of 
<span class='underline'>persons</span>. Each <span class='underline'>meeting</span> should have a 
<span class='underline'>place</span> and <span class='underline'>date</span>.
The application must allow user friendly of entering and modifying the data.  

Now you take the nouns aside and you should obtain the following list:
- person (friend, acquaintance) can have a:
    - name, 
    - nickname, 
    - age, 
    - location, 
    - contact, 
    - relationship;
- contact (mobile, Skype, Jabber) can have a:
    - type;
- address;
- relationship (friend, fiend, acquaintance, spouse) can have a:
    - type, 
    - description,
- meeting can have a:
    - person, 
    - place, 
    - date

Now you can directly see **entities** and their **attributes**. If you notice an attribute
being another entity (person can have a contact), you just stumbled upon **relationship**.
From here you should be able to draw the conceptual ERD. Try to really do it yourself Before
you look at the solution.

{: .solution}
{: .image-popup}
![ERD Classic](/en/apv/articles/database-design/erd-classic.svg)

The above diagram is one of infinite number of solutions. The requirements are always incomplete
therefore you have to apply common sense and your own judgement to fill in the 
blanks (for example, what are the attributes of address?, what other attributes a contact
needs to have?). Therefore your solution is probably different than mine and it is 
perfectly ok. There is no single right solution or single point of truth. 

Also bear in mind that we are making a **model of the data** the application will use.
The most important feature of any model is that it is simplified. Therefore the task here is not
to enumerate all attributes a person can have. The task is to enumerate all attributes of 
person which **will be useful in the application**. Also keep in mind that the database model 
is bound to change. Therefore if you are not sure about something, don't worry too much about it.
There is always the possibility (and often the need) to change it.

### Relationship Cardinality
When you have the **entities**, **attributes** and entity **relationships**, you can move to 
the next step. This is evaluation of **relationship cardinality**. Relationship
cardinality (or *relationship degree* or *cardinality ratio*) describes how many
entities can relate to the other entity in the relationship. Relationship cardinality
is always evaluated two-way.

Relationship cardinality is usually (but not necessarily) evaluated together with
**Optionality**. Optionality describes if one entity that depends on another one 
can be either **mandatory** or **optional**. I.e. if an entity can exist without being related
to the other entity in the relationship.

For example, if you have entities `person` and `car` and the relationship
`drives`, you can ask the following questions:

- How many persons can drive one car? (answer: 1)
- How many cars can be driven by one person? (answer: 1)
- Does a person have to drive a car? (no)
- Does a car have to be driven by a person? (no) 

The answers above lead to relationship `DRIVES(PERSON:(0,1), CAR:(0,1))`. Now let's 
consider the relationship `owns`.

- How many persons can own one car? (answer: 1)
- How many cars can be owned by one person? (answer: many)
- Does a person have to own a car? (no)
- Does a car have to be owned by a person? (yes) 

The answers above lead to relationship `OWNS(PERSON:(0,N), CAR:(1,1))`. There are three types of
relationship cardinalities:

- 1:1 -- one to one -- `DRIVES(PERSON:(0,1), CAR:(0,1))`
- 1:N -- one to many -- `OWNS(PERSON:(0,N), CAR:(1,1))`
- M:N -- many to many -- `USES(PERSON:(0,M), CAR:(0,N))`

If the relationship allows multiple entities, we do not count them precisely. For the 
database design, it is important to know only whether there can be one or more. Now 
you probably think -- *it is possible that two people own a single car* or 
*car does not have to be owned by anyone* or something like that. The truth is that 
every real relation in the world is M:N or `0..M:0..N`. Because you can always find
some kind of exception to the above answers. Consider for example the `drives` relationship.
Is it possible that one car is driven by two people? Is it possible that a single 
person can drive multiple cars? 

{: .solution}
Yes, for example in the *driving school* or consider for example 
[Abby and Brittany Hensel](https://en.wikipedia.org/wiki/Abby_and_Brittany_Hensel) or
[remote controlled cars](https://www.youtube.com/watch?v=gPv69DM3YsE).

Remember that we are making a model of the real-world. Therefore you should 
always select the **lowest cardinality ratio acceptable for the application**.
This is extremely important. The database model must be a **usable** simplification
of the real world. If it were not a simplification, the result application would be 
infinitely complex (and therefore infinitely expensive). Therefore in the above case
you would probably consider `drives` a 1:1 relationship.

This poses the question -- how to deal with the exceptions in the database model. 
The answer to this question is very difficult and depends highly on the application
itself. Sometimes a field allowing the user to enter an arbitrary note is sufficient.  
Sometimes it is not.

## Using E-R Model
Once you have the E-R model -- the entities and their attributes and the 
relationships and their cardinalities -- you have to convert it to the 
actual database schema. The E-R conceptual model is very close to relational 
database model (as you probably noticed by now):

- Entity type = table,
- Entity = table row,
- Attribute = table column,
- Attribute Value = table cell,
- Relationship = ?

A relationship in the ER model can be represented in two ways in a relational database schema:

- inside a table with a column,
- with a stand-alone table.

It is obviously easier to implement it using only a column and use the table only if
necessary. The relationship *must be represented* by a table either when the 
relationship cardinality is of type M:N or when the relationship itself has attributes.
An example of relationship with attributes is: `TENANCY(LANDLORD, TENANT, BEGIN_DATE, END_DATE, RATE)`.
All of the attributes `BEGIN_DATE`, `END_DATE` and `RATE` are attributes of the tenancy relationship.
They are not properties of the landlord neither of the tenant.

For example if you have a relationship between `person` and `location`, you have multiple options
(depending on the application requirements):

- If a person has only a single location and vice-versa, leave the location in `person` table:
    - `PERSON(ID_PERSON, FIRST_NAME, NICKNAME, CITY, STREET)`
- If a location can be shared by multiple persons, you need `location` table and link it to `person`:
    - `PERSON(ID_PERSON, FIRST_NAME, NICKNAME, ID_LOCATION)`
    - `LOCATION(ID_LOCATION, CITY, STREET)`
- If a single person can have multiple addresses too, you need another table:
    - `PERSON(ID_PERSON, FIRST_NAME, NICKNAME, ID_LOCATION)`
    - `LOCATION(ID_LOCATION, CITY, STREET)`
    - `RESIDENCE(ID_PERSON, ID_LOCATION, BEGIN_DATE)`

A table which exists to represents a M:N relationship is called **association table**. Typically,
the association table has a compound primary key -- `id_person` + `id_location` in the above 
`residence` table. In the [sample database](/en/apv/walkthrough/database/#database-schema), 
there is a `person_meeting` association table.
Sometimes this is also referred to as [**weak entity**](https://en.wikipedia.org/wiki/Weak_entity). The
`person_meeting` (or `residence`) entities have no primary key of their own. They are only
identified by [foreign keys](/en/apv/articles/relational-database/#foreign-key) to other entities. 

### Database Normalization
By converting the relationships, your database schema will gain some new columns and tables. Then
you should check if the database is **normalized**. Normalization is conversion to **normal forms** (NF).
There are more [normal forms](https://en.wikipedia.org/wiki/Database_normalization#List_of_Normal_Forms), 
but first three are most important:

- 1. NF -- attribute values are atomic,
- 2. NF -- relation contains no partial functional dependencies of non-key attributes on key,
- 3. NF -- no non-key attribute transitively depends on key.

Normal forms are only recommendations (violation must be justified). Normal forms are 
nested -- if a relation is in 3. NF, it must be in 2. NF and 1. NF too. 
If a database is normalized it has some positive properties. If a database is not normalized, 
you must verify those properties yourself (or live without them).

#### First Normal Form
First normal form requires that a single value (table cell) of each attribute is
**atomic** -- which means indivisible. That means that it contains only a single value 
and that value cannot be split into something else. Consider this `relationship` table which 
records relations between two persons: 

| 1\_person\_name | 2\_person\_name | 1\_person\_address        | 2\_person\_address       | begin\_date |
|-----------------|-----------------|---------------------------|--------------------------|-------------|
| Karl Oshiro     | Marcel Miranda  | Mozartstraße 33, Linz     | Fountain Rd 27, Stirling | 2016-01-06  |
| Remona Deen     | Karl Oshiro     | Old Rd 182, Muir of Ord   | Mozartstraße 33, Linz    | 2015-12-20  |
| Tuan Brauer     | Marcel Miranda  | Davenport St., 12, Bolton | Fountain Rd 27, Stirling | 2015-10-09  |

This definition of table `relationship` is not in 1. NF because the first four columns are not atomic.
For example, it unclear what first and last name is. It is also unclear what city and street is. Nothing 
prevents the end-user from entering any string into any of the fields -- in some countries and languages,
the street number is written first, in some it is written last. Same goes with the name -- what is
family name in **Park Geun-hye** ? These ambiguities make it impossible to **reliably** sort 
by last name or city, or to **reliably** search for persons living only in a certain city etc.

The (hopefully) obvious solution is to split the value into multiple columns (`first_name`, `last_name`,
`city`, `street_name`, `street_number`). Normalization to 1st NF therefore adds columns to your
database schema. While this may sound easy, you will probably run into situations where it is not
entirely easy to decide what is atomic and what is not.

Consider for example the column `begin_date`, is is a date value, which consists of year, month and day.
Is is atomic? Yes and no. If you consider it being a date value -- i.e. a reference to a point in 
time -- it is atomic. If you consider it a string of three values (in some ambiguous format), then 
it is not atomic. So under normal circumstances, you would consider date as being atomic and use
a single column for it. Is it useful to represent date as three separate values? Sometimes. For example, when
one of the parts of the date are optional -- something has to be done on 10th day of every month; something
was manufactured on january 2016, etc. When one part of the date is missing, it ceases to be a 
reference to a point in time and starts to be a collection of (three) values.

You have to keep in mind that you are making
a **model of the data** and therefore atomicity is evaluated to the application needs. One might for
example argue, that first_name 'Karl' is a string of four characters and therefore it is not atomic.
However, from the application point of view, it is a single value -- first name, which cannot
be split into **meaningful** (for the application) parts.

While all this may seem like nitpicking, it is very important. All these reflections and considerations
help you understand the nature of the problem you're solving in your application. Thus they
help you design the database structure correctly.    

#### Second Normal Form
Below is a modified `relationship` table recording relationships between persons. The table is
in 1st NF, column `ssn` contains [Social Security Number](https://en.wikipedia.org/wiki/Social_Security_number). 
The key of the table is combination of `1_ssn` and `2_ssn` because that identifies the 
relationship between two persons.

| 1\_name | 1\_surname | 1\_ssn | 2\_name | 2\_surname | 2\_ssn | begin_date |
|---------| -----------|--------|---------|------------|--------|------------|
| Karl    | Oshiro     | 123    | Marcel  | Miranda    | 987    | 2016-01-06 |
| Remona  | Deen       | 456    | Karl    | Oshiro     | 123    | 2015-12-20 |
| Tuan    | Brauer     | 789    | Marcel  | Miranda    | 987    | 2015-10-09 |

The above table is not in 2nd NF. A table is in 2NF if 
*it contains no partial functional dependencies of non-key attributes on key*.
The column `begin_date` has full [functional dependency](https://en.wikipedia.org/wiki/Functional_dependency) 
on the key, because both parts of the key (`1_ssn` and `2_ssn`) are necessary to identify the `begin_date`
of a relationship. On the other hand, the columns `1_name`, `1_surname`, 
`2_name` and `2_surname` have only **partial** functional dependency on the 
key because they depend only on either `1_ssn` or `2_ssn`. I.e. changing 
the value of `2_ssn` in the first row would have no effect on Karl Oshiro.
Therefore the table is not in 2nd NF. A table which is not in 2nd NF contains
a lot of [redundant](/en/apv/articles/database-systems/#redundancy-et-al) data.

If a table is not in 2nd NF it suffers with **Insert / Update anomaly** and 
**Delete anomaly**. Delete anomaly would occur if you deleted the last
relationship from the table. With deletion of the relationship you would
also lost all records about the *Tuan Brauer* person. Similarly, and insert 
anomaly occurs when you want to insert a new person in the database. You would
have to fabricate a relationship for the person.

2nd NF applies only to table which have a compound key. If a table has no
compound key, then no partial dependencies can occur and the table is in 2nd NF.
Although in practice, most tables have a compound key. Violation of 2nd NF comes
from an incorrect splitting of entities in the analysis phase. While it may 
seem obvious in the above case, that I mixed `person` and `relationship` into a 
single table, they are cases when the differences may be much more subtle. 
However, the *insert / update / delete anomaly* is something you will definitely notice
and the only way to avoid it is to redesign the database.

Redesigning the database means splitting the above table into two tables -- `relationship`: 

| 1\_ssn | 2\_ssn | begin_date |
|--------|--------|------------|
| 123    | 987    | 2016-01-06 |
| 456    | 123    | 2015-12-20 |
| 789    | 987    | 2015-10-09 |

And `person`:

| ssn | name   | surname |
|-----|--------|---------|
| 123 | Karl   | Oshiro  |
| 456 | Remona | Deen    |
| 789 | Tuan   | Brauer  |
| 987 | Marcel | Miranda |

The above two tables are in 2nd NF (and also in 1st NF). No data are redundant and
inserting a person does not require inserting a relationship. Similarly,
deleting a relationship does not delete a person. To convert a table into 2nd NF, you have to
split it into two tables. Splitting must not cause information loss -- it must be possible to 
reconstruct the original information by [joining the tables](/en/apv/articles/sql-join/#joining-tables).

#### Third normal form
The definition of 3rd NF requires that *no non-key attribute transitively depends on key*. Every
non-key attribute depends on a key (that is a [definition of the key](/en/apv/articles/relational-database/#key)). 
I.e. if you change the value of `id` in the below table, all the other columns will change too
(because it will be a different address).

| id | street           | num | city        | zip     |
|----|------------------|-----|-------------|---------|
| 1  | Mozartstraße     | 33  | Linz        | 4020    |
| 2  | Old Rd           | 182 | Muir of Ord | IV6 7UJ |
| 3  | Davenport Street | 12  | Bolton      | BL1 2LT |
| 4  | Malt Street      | 62  | Bolton      | BL1 2LT |

The above table is not in 3rd NF because it contains **transitive** dependencies on the key.
The attribute `zip` depends on the attribute `city` -- if you change the value of 
`city`, the `zip` code changes too. Therefore the attribute `zip` depends on the key 
(which is `id`) *transitively*.

A table which is not in 3rd NF contains redundant information, which can
be seen in the last two rows. Redundant data in tables lead to 
[inconsistency](/en/apv/articles/database-systems/#integrated-information-system). 
To convert the table into 3rd NF, it again has to be split into two tables `addresses`:

| id | street           | num | zip     |
|----|------------------|-----|---------|
| 1  | Mozartstraße     | 33  | 4020    |
| 2  | Old Rd           | 182 | IV6 7UJ | 
| 3  | Davenport Street | 12  | BL1 2LT | 
| 4  | Malt Street      | 62  | BL1 2LT | 

And `zip_codes`:

| zip       | city        |
|-----------|-------------|
| 4020      | Linz        |
| IV6 7UJ   | Muir of Ord | 
| BL1 2LT   | Bolton      | 

The above database definition is in 3rd NF. Converting to 3rd NF produces so called
[**reference tables**](https://en.wikipedia.org/wiki/Reference_table). These are 
(usually two-column) tables which contain lists
of allowed values for something. In the sample database, there are reference tables
`contact_type` and `relation_type`.

However, the above example with address is not entirely perfect. Addresses do have very high
variability over the world. While the above may acceptable for continental Europe, there 
may be countries where there are no streets, or street numbers or places without zip code or
whatever. The normalization of addresses is often not very strict. Sometimes, you may run into
databases which simply have `address_line_1` and `address_line_2` fields. Which is obviously
not atomic, but it may be much more practical in some cases (if you use the 
address only as a 'single value' printed on package or letter).     

#### Denormalization
This leads us to the concept of **denormalization**. It is perfectly ok to use a relational 
database which is not normalized, provided that you know why and understand the consequences.

One example of this is intentional avoidance of normalization like in the case of addresses.
The risk of inconsistency is minimal, because the end-user always enters the entire address
(including city and zip code) and therefore you may consider the entire address to be 
a single value. The inconsistency is likely to happen in case someone decided to renumber 
zip codes, which happens, but so rarely, that you can deal with it manually when it happens.
All this means, that it is simply impractical to fully normalize addresses, because the 
the positives are not going to outweigh the increased implementation complexity.

Another example of using database which is not normalized are 
[analytical databases](/en/apv/articles/database-systems/#database-systems). These databases are 
build from normalized [OLTP](/en/apv/articles/database-systems/#database-systems) databases
and intentionally store data in joined tables to make select queries easier and faster.
Sometimes such tables may be used in OLTP databases too, but they should always be built
from the base normalized tables.

## Creating database schema
When creating a database schema, we went through the following steps:

- analyze textual requirements from the customer / end-user
- create conceptual Entity-Relationship model (and diagram)
- evaluate relationship cardinality and optionality
- convert relationships to columns or tables 
- normalize to 1st NF (create additional columns)
- normalize to 2nd NF (create additional tables)
- normalize to 3rd NF (create additional reference tables)

By following the above steps, you should transition from **conceptual model**  
(which contains entities and relationships between them):

![ERD Classic](/en/apv/articles/database-design/erd-classic.svg)

To a **logical model** model, from which the database schema
can be created (**physical model**):

![ERD Crow's foot](/en/apv/schema.svg)

The above diagram is also an ERD in so called **Crow's foot notation**. This
notation directly displays relations (tables) and their definitions. With
proper [design software](todo ido), the SQL queries to create tables in database can be 
generated automatically. You can then start using the database.

## Summary
In this article I described the process of designing a database given a textual requirements
for an application. Keep in mind that the above description is applicable to 
small or middle-sized databases. For huge databases you need to use a proper
[methodology](https://en.wikipedia.org/wiki/Data_modeling). Also keep in mind that this is a creative process with no
'one true solution' so you have to decide and choose one of the many different options.
ERD and database normalization are tools that help you along the way, but ultimately you 
must be able to defend your own design decisions.

### New Concepts and Terms
- database model
- entity-relationship model
- ERD
- entity
- attribute
- relationship
- relationship cardinality
- relationship optionality
- association table
- database normalization
- first normal form
- second normal form
- third normal form
- functional dependencies
- denormalization  
