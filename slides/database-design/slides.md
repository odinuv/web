---
layout: slides
title: Database Design
description: Modeling relational database structures, database normalization.
transition: slide
permalink: /slides/database-design/
redirect_from: /en/apv/slides/database-design/
---

<section markdown='1'>
## Database Modeling
- So far you have been working with an existing **database schema**.
- How is the database schema created?
- We need a data model:
    - E-R Model -- **Entity** -- **Relationship**;
    - ERD -- Entity-Relationship Diagram.
- The process:
    - Analyze requirements,
    - Design,
    - Validate
- Requires: Brain, Experience, Pen & Paper
</section>

<section markdown='1'>
## E-R Modeling
- **entity** -- identifiable real world object (table record)
- entity type -- class of real world object
- **relationship** -- link between entities
- attribute -- property of entity or relationship
- value -- actual value of an attribute
- attribute domain -- set of allowed values for an attribute
- key -- set of attributes which identify an entity
</section>

<section markdown='1'>
## E-R Modeling
- Sounds familiar?
    - Closely connected with relational modeling.
    - Similar to object oriented modeling:
        - A different solution to the same problem.
- Never confuse **relation** and **relationship**!
- Start with identifying nouns -- entities and their attributes.
</section>

<section markdown='1'>
## Project Assignment
Create a web application for recording persons and contacts. The main goal of the application is
to record persons (friends, acquaintances), their addresses, relationships and meetings.
Every person can have a name, nickname, age, location and contacts. Each person can have any
number of contacts (mobile, Skype, Jabber, ....). A person can have more contacts of the
a type (e.g. two emails). Each person can have any number of relationships
with other persons in the database. Each relationship should have type (friend, fiend, acquaintance, spouse, ...)
and description. Contact and relationship types are recorded in the database and can be modified by
the end-user...
</section>

<section markdown='1'>
## E-R Diagram
- Multiple variants: "Classic", "Crow's foot", ...
- Classic (conceptual) notation:

![ERD Legend](/articles/database-design/erd-legend.svg)
</section>

<section markdown='1'>
## Classic (Conceptual) ERD

![ERD Classic](/articles/database-design/erd-classic.svg)
</section>

<section markdown='1'>
## Relationship Cardinality
- Relationship Cardinality = Relationship degree = Cardinality ratio:
    - How many entities can relate to one other entity,
    - Two way evaluation.
- Optionality -- Mandatory / Optional:
    - Can an entity exist without being related?
- R (Entity1:(min, max), Entity2:(min, max))
    - 1:1 -- DRIVES(PERSON:(0,1), CAR:(0,1))
    - 1:N -- OWNS(PERSON:(0,N), CAR:(1,1))
    - N:M -- USES(PERSON:(0,M), CAR:(0,N))
- All real-world relations are M:N.
    - Remember that we are making a model!
</section>

<section markdown='1'>
## Using E-R Model
- Once you have the E-R model, you have to convert it to the database schema.
- The E-R conceptual model is very close to the relational database model:
    - Entity type = a table,
    - Entity = a table row,
    - Attribute = a table column,
    - Attribute Value = a table cell,
    - Relationship = ?
</section>

<section markdown='1'>
## Converting Relationship
- Relationship can be represented:
    - inside a table with a column,
    - with a stand-alone table.
- Relationship must be represented by a table:
    - when it is a M:N relationship,
    - when it has attributes.
- `TENANCY(LANDLORD, TENANT, BEGIN_DATE, END_DATE, RATE)`
</section>

<section markdown='1'>
## Converting Relationship cont.
- Example `person` -- `location`:
    - If a person has only a single location and vice-versa, leave the location in the `person` table:
        - `PERSON(ID_PERSON, FIRST_NAME, NICKNAME, CITY, STREET)`
    - If a location can be shared by multiple persons, you need the `location` table and link it to `person`:
        - `PERSON(ID_PERSON, FIRST_NAME, NICKNAME, ID_LOCATION)`
        - `LOCATION(ID_LOCATION, CITY, STREET)`
</section>

<section markdown='1'>
## Converting Relationship cont.
- Example `person` -- `location`:
    - If a single person can have multiple addresses too, you need another table:
        - `PERSON(ID_PERSON, FIRST_NAME, NICKNAME)`
        - `LOCATION(ID_LOCATION, CITY, STREET)`
        - `RESIDENCE(ID_PERSON, ID_LOCATION, BEGIN_DATE)`
</section>

<section markdown='1'>
## Database Normalization
- Normalization -- conversion to **normal forms** (NF)
- There are more normal forms, but first three are the most important:
    - 1st NF -- attribute values are atomic,
    - 2nd NF -- relation contains no partial functional dependencies of non-key attributes on a key,
    - 3rd NF -- no non-key attribute transitively depends on a key.
- Other normal forms are not practical.
- Normal forms are only recommendations (but violation must be justified).
</section>

<section markdown='1'>
## Normal Forms
- Normal forms are nested -- if a relation is in 3rd NF, it must be
 in 2nd NF and 1st NF too.
- If a database is in 3rd NF, it has some positive properties.
- If a database is not normalized, you must verify those properties yourself.

![Normal forms](/articles/database-design/normal-forms.svg)
</section>

<section markdown='1'>
## First Normal Form

| 1. Person Name | 2. Person Name | 1. Person Address         | 2. Person Address        | Begin Date |
|----------------|----------------|---------------------------|--------------------------|------------|
| Karl Oshiro    | Marcel Miranda | Mozartstraße 33, Linz     | Fountain Rd 27, Stirling | 2016-01-06 |
| Remona Deen    | Karl Oshiro    | Old Rd 182, Muir of Ord   | Mozartstraße 33, Linz    | 2015-12-20 |
| Tuan Brauer    | Marcel Miranda | Davenport St., 12, Bolton | Fountain Rd 27, Stirling | 2015-10-09 |

</section>

<section markdown='1'>
## First Normal Form
- This definition of the table `relation` is not in 1st NF:
    - undefined order of the first name and last name,
    - impossible to sort by the last name or city,
    - impossible to **reliably** select only the first name,
    - **atomicity** is required from the **application point** of view.
</section>

<section markdown='1'>
## Second Normal Form

| Name1  | SName1 | SSN1 | Name2  | SName2  | SSN2 | Begin Date |
|--------| -------|------|--------|---------|------|------------|
| Karl   | Oshiro | 123  | Marcel | Miranda | 987  | 2016-01-06 |
| Remona | Deen   | 456  | Karl   | Oshiro  | 123  | 2015-12-20 |
| Tuan   | Brauer | 789  | Marcel | Miranda | 987  | 2015-10-09 |

</section>

<section markdown='1'>
## Second Normal Form
- This definition of the table `relation` is in 1st NF and is not in 2nd NF:
    - The key is a combination of `SSN1` and `SSN2` attributes.
    - `Begin date` depends on the both attributes of the key.
    - `Name1` and `SName1` depends only on `SSN1` -- therefore they
        depend only on a part of the key.
    - The table contains redundant data.
    - Insert / Update anomaly, Delete anomaly.
</section>

<section markdown='1'>
## Second Normal Form

| RELATION |      |            | | PERSON |        |         |
|----------|------|------------|-|--------|--------|---------|
| SSN1     | SSN2 | Begin_date | | SSN    | Name   | SName   |
| 123      | 987  | 2016-01-06 | | 123    | Karl   | Oshiro  |
| 456      | 123  | 2015-12-20 | | 456    | Remona | Deen    |
| 789      | 987  | 2015-10-09 | | 789    | Tuan   | Brauer  |
|          |      |            | | 987    | Marcel | Miranda |

</section>

<section markdown='1'>
## Second Normal Form
- This definition of the table `relation` and `person` is in 2nd NF (and therefore in 1st NF):
    - no data is redundant,
    - inserting relationship does not cause inserting of a person,
    - deleting relationship does not delete a person,
    - splitting must not cause information loss.
</section>

<section markdown='1'>
## Third normal form

| ID | Street           | No. | City        | ZIP     |
|----|------------------|-----|-------------|---------|
| 1  | Mozartstraße     | 33  | Linz        | 4020    |
| 2  | Old Rd           | 182 | Muir of Ord | IV6 7UJ |
| 3  | Davenport Street | 12  | Bolton      | BL1 2LT |

- This definition of the `address` table is not in 3rd NF:
    - the `zip` attribute depends on the `city` attribute,
    - a change in `city` will trigger a change in `zip`,
    - `zip` transitively depends on `id`.
</section>

<section markdown='1'>
## Third normal form

| Address |                  |     |         | | ZIP Codes |             |
| ID      | Street           | No. | ZIP     | | ZIP       | City        |
|---------|------------------|-----|---------|-|-----------|-------------|
| 1       | Mozartstraße     | 33  | 4020    | | 4020      | Linz        |
| 2       | Old Rd           | 182 | IV6 7UJ | | IV6 7UJ   | Muir of Ord |
| 3       | Davenport Street | 12  | BL1 2LT | | BL1 2LT   | Bolton      |

- The definition of `address` and `ZIP codes` tables is in 3rd NF:
    - the foreign key is `ZIP code`, removed redundancy of data.
- Not really practical on the address table.
</section>

<section markdown='1'>
## From: Classic (Conceptual) ERD

![ERD Classic](/articles/database-design/erd-classic.svg)
</section>

<section markdown='1'>
## To: Crow's foot ERD

![ERD Crow's foot](/common/schema.svg)
</section>

<section markdown='1'>
## Crow's foot ERD

![ERD Legend](/articles/sql-join/erd-legend.svg)

- The classic diagram contains entities and relationships.
- Some relationships may lead to new tables.
- The crow's foot diagram contains definitions of individual tables.
</section>

<section markdown='1'>
## Checkpoint
- What is the difference between relation and relationship?
- Is it possible to replace ER modelling with object oriented modelling?
- If a database is in 3. NF, can it be used in an application?
- What are possible cardinality ratios?
- When is it practical to store a date as three columns (day, month, year)?
- What is optionality and when is it important?
- Is it possible to determine cardinality unambiguously?
- When is it necessary to create a table for a relationship?
- Why is redundancy unwanted in the database?
- Is it necessary to split a date to maintain atomicity?
</section>
