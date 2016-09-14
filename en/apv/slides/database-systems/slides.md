---
layout: slides
title: Database Systems
description: Overview of database systems in general, list of different types of database systems.
transition: slide
permalink: /en/apv/slides/database-systems/
---

<section markdown='1'>
## Introduction 
- **Data** -- some values obtained by observation or measuring.
- **Information** -- interpretation of data and relations between them.
    - Data which lower entropy of the systems.
    - Repeated / duplicated data bear no information.
- **Database** -- generic structure for storing data;
    - could be even a file system.
- **Database system** -- application managing data in database.
- **Interface** -- means for connecting systems together.
</section>

<section markdown='1'>
## Bulk Data-Processing 
- Goal is to obtain information from data.
- The majority of BDP applications are **Information Systems**:
    - Company **Information Systems**
        - contains a collection of many different agendas (SIS),
        - e.g. finance, inventory, facility,
        - it is not just the software.
    - Specialized **Information Systems**
        - single agenda.
</section>

<section markdown='1'>
## Separate Information Systems
- The company information system is composed of unrelated sub-systems (SIS):
    - each system has its own application code,
    - each system has its own data store.
- Format and structure of data are tied to each sub-system requirements:
    - therefore they are **incompatible**,
    - where there is incompatibility, there is **isolation**,
    - where there is isolation, there is **redundancy**,
    - where there is redundancy, there is **inconsistency**.
- No one wants inconsistency.
</section>

<section markdown='1'>
## Separate Information Systems
- Isolation and incompatibility -- data can be used only by the 'owning' application.
    - Data are unreadable (unknown or proprietary format).
    - Data are unintelligible (no documentation).
- Redundancy -- one piece of data in multiple locations.
    - Do not confuse with backups (no master -- copy).
- Inconsistency -- occurs when redundant data are incompletely updated.
    - Civil service is a good (bad ?) example.
- Ad-hoc queries are very expensive (substantial effort or new application).
- Difficult to ensure data integrity and security.
</section>

<section markdown='1'>
## Data integrity
- Integrity -- state of the data (database) when all data are complete and correct.
- What is correct is determined by **integrity constraints**, e.g: 
    - Age is positive integer.
    - Every person has age (age cannot be empty).
    - Every person has address (address cannot be empty).
- Integrity constraints are not easy!
- **Integrity violation** occurs usually by bad **data sanitization**.
</section>

<section markdown='1'>
## Separate Information Systems
- How it happens:
    - development of the company -- leftover legacy systems which do not integrate;
    - company merger -- difficult to integrate information systems together (imagine a bank);
    - lack of money -- cheap solution which does not adapt to existing systems (and does not integrate well); 
    - surplus of money -- expensive solution -- DTTO;
    - laziness -- no one cared for integration effort.
</section>

<section markdown='1'>
## Integrated Information System
- Ensures that data have one true master version:
    - using a centralized database: 
        - all applications connect to single database server; 
        - does not need to be physically a single machine;
        - classic approach.
    - using distributed database or a collection of APIs:
        - data may be distributed over various systems;
        - each piece (or rather class) has master origin.
</section>

<section markdown='1'>
## (Centralized) Database system 
- Data are stored and managed one one place.
- Data files have set structure, hidden to outside world.
- Data may be accessed only using the DBS interface.
- Database system takes care of concurrent access of multiple users, permissions and data integrity.
- Database system operations are optimized to lower **time complexity**.
</section>

<section markdown='1'>
## Database Systems
1. OLTP -- Online Transaction Processing:
    - the foundation of all -- processing of daily operations,
    - every information system must have this,
2. DWH -- Data Warehouse:
    - analytical systems, analytical queries,
    - large amount of read data, almost no data written.
3. Other:
    - special analysis -- text processing, image processing, predictions, etc.
- Different technologies, but SQL language is used in most DBS. 
- Focus on OLTP, because that is the starting point.
</section>

<section markdown='1'>
## Data Model
- Set of resources to model and describe data. 
- Output of DM is database schema -- declaration of the **database structure** (database template).
- Different tools:
    - functions,
    - graphs (from graph theory),
    - relations (sets),
    - objects.
- Database is something which can hold data.
- Database schema is description of database structure.
- Object data model and relation data model are two approaches to the same problem.

</section>

<section markdown='1'>
## Hierarchical Model
- Data are organized in tree-like structures.
- The relation between records is parent-child.
- A child has one parent.
- One parent can have more children.
- For general use databases is not very suitable, special uses:
    - DNS, LDAP,
    - file systems (links ignored),
    - XML (partially HTML).
</section>

<section markdown='1'>
## Network Model
- Extended hierarchical model.
- Each record (vertex) can be connected to any number of different vertices.
- Handles relations 1:N, M:N and cyclic relations.
- Very universal and flexible, no usable implementations.
- Considered as Network model with limitations: 
    - file system (links not ignored),
    - HTML DOM (Document Object Model).
</section>

<section markdown='1'>
## Relational Model
- Describes data with relations (something like table, will explain later).
- Designed around 1970 (E. F. Codd, in IBM).
- Build on hard maths -- relational algebra.
- Relational database system -- **RDBS**.
- Gave birth to and uses SQL language for querying.
- Widespread:
    - DB2 (IBM), Firebird, MySQL,
    - Oracle Database, PostgreSQL, SQL Server (Microsoft), etc.
</section>

<section markdown='1'>
## Object-Relation Model
- Combination of object and relational model:
    - SQL query language or similar;
    - relational implementation of database structure;
    - data results in form of objects;
    - supports class hierarchy, inheritance and encapsulation;
    - supposedly faster than converting from RDBS;
    - supports multi-valued attributes.
- Instead of records, objects are returned.
- Pure object databases do also exist.

</section>

<section markdown='1'>
## ACID
- **Transaction** -- one action, optionally composed of multiple operations
(e.g. insert a person together with contact information and meetings, …).
- **Atomicity** -- either all operations in a transaction must be performed,
or none of them (*rollback*).
- **Consistency** -- before and after the transaction, the database is in 
a consistent state, during the transaction it may not be (imagine buying something).
- **Isolation** -- concurrently running transactions behave **as if** they 
are running sequentially.
- **Durability** -- a finished transaction is permanent.
- ACID is what common sense expect from database.
</section>

<section markdown='1'>
## SQL × NoSQL
- Virtually all ACID databases use SQL language or some SQL dialect or similar language.
- The other option is BASE:
    - **B**asically **A**vailable, **S**oft state, **E**ventual consistency;
    - if a record is not updated any more, all queries to that record will
    *eventually* return consistent results;
    - unusable for ordinary information system;
    - required for massive distributed services;
    - somewhat related to NoSQL databases (key-value databases) = associative array, graph, document, …);
- Then there are columnar and key-value databases which may by either ACID or BASE.

</section>

<section markdown='1'>
## Checkpoint
- May one database system contain multiple databases?
- What is direct outcome of redundant data in information system?
- Is is possible to run two transactions at once in ACID database?
- Is information system only software?
- Are data better than information?
- How are information transmitted?
- Does every database system have to use SQL langauge?
- Should accounting use ACID or BASE database ?
- What are differences between object data model and relational data model? 
</section>
