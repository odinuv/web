---
title: Database Systems
permalink: /articles/database-systems/
redirect_from: /en/apv/articles/database-systems/
---

* TOC
{:toc}

In this article I will try to describe the field of database systems generally.
What they are, what they are good for, etc. This article does not have
practical examples inside, because it is supposed to give you general overview of
the domain. There is a followup article
[about relational databases](/articles/relational-database/) and a
hands-on [article about SQL](/articles/sql-join/).

## Introduction
Before you start working with database systems (DBS), you should be aware of what **data** is.
A piece of **Data** is simply a value obtained by observation (measurement) of something.
An example of piece of data is e.g. **42**. This demonstrates that data without context
are meaningless. Data without context cannot be interpreted anyhow and therefore they
cary no **information**.

Consider these statements:

- 42
- The profit is 42
- The profit of our company was $42K.
- The profit of our company over past 20 years was $42K.
- The minimum monthly profit of our company over past 20 years was $42K.

See how, by adding more and more context, I add more information which you can get from
the data *42*. (I also secretly added another piece of data -- *20*). Notice that the added
context can also radically change the **presumed** meaning of the statement! Now consider
this statement:

- The minimum monthly profit of our company over past 20 years was $42K.

What information you obtain now? None (unless you are very forgetful). This demonstrates
that repeated data carry no information. It also demonstrates why the phrase *new information*
is a [pleonasm](https://en.wikipedia.org/wiki/Pleonasm).

There are more stances to what information is, but a pretty good one is
**Information is data which reduces uncertainty (entropy) of a system**. I.e.
by saying *"The minimum monthly profit of our company over past 20 years was $42K"* I
reduced your uncertainty about the profits of our company (there is still a lot of
uncertainty left, but it is reduced). Thus, repeated data cary no information (they
don't reduce anything).

The concept of [information](https://en.wikipedia.org/wiki/Information) is related
to [**knowledge**](https://en.wikipedia.org/wiki/Knowledge) in that *knowledge* is
*generalized information*. E.g. with the above example, you can say that having a minimum monthly profit of $42 000
does not look bad (depends on the size of the company of course). This is because you
have (at least vague) knowledge of what dollar is and what value it has. There is a whole
computer science field dealing with these
concepts -- [Information theory](https://en.wikipedia.org/wiki/Information_theory).

For now it is necessary for you to understand the difference between *data* and
*information*. Keep in mind that there is no clear line between them. Also notice
that in essence there is really no way to store or transmit
information. Because it is what you make of the data in your head.

### Database
A **Database** is a structure for storing data. The word *structure* is important, because
database must be organized. A litter bin contains a lot of data pieces, but they are not organized
and it is very hard to obtain any information from them. Files on your computer
can be considered as a database. A paper file may be a database too. The structure level can vary, e.g. consider the sentence:

    The minimum monthly profit of our company over past 20 years was $42K.

Can be structured into this:

| What                   | Company     | Time     | Amount  |
|------------------------|-------------|----------|---------|
| minimum monthly profit | our company | 20 years | $42 000 |

Or into this:

| Indicator | Indicator Span | Indicator Function | Company     | Time | Time Unit | Amount | Amount Unit |
|-----------|----------------|--------------------|-------------|------|-----------|--------|-------------|
| profit    | month          | minimum            | our company | 20   | year      | 42000  | $           |

There are unlimited options of how data can be structured and therefore unlimited
options of how a database can look and what tools it uses.

An [**interface**](https://en.wikipedia.org/wiki/Interface_(computing)) is a collection of means for
connecting different systems together. Or I can say that an interface is a *well defined* boundary
of a [system](https://en.wikipedia.org/wiki/System). An example of an interface is a wall socket. It
provides an interface between a distribution network (and ultimately a power plant) and your
chosen appliance. Generally an interface is used when two complicated things are supposed to be connected
together. This may look slightly counter-intuitive -- adding another complicated thing, but an
interface allows to consider each of the connected systems as a
[black-box](https://en.wikipedia.org/wiki/Black_box), so it ultimately hides their complexity.
In application development, interfaces are used for exactly the same reasons as wall sockets are used.

A **database system** is an application which manages data in a database. The primary
responsibility of the database system is to maintain the defined structure of the data.
Therefore a file system is not a database system, because nothing prevents you from storing a file
where it does not belong, similarly a paper is not a database system.
A **database system** is an interface to the actual database.

## Bulk Data-Processing
The goal of Bulk Data-Processing is to obtain information from data (pedantically: present
data pieces in such a form that the end-user can interpret them and therefore obtain information).
A typical example of a bulk data-processing application is an **information system**. There are
other applications doing it, but it is the essence of information systems to process data.
Other kinds of applications (such as games) may also be processing data and using databases, but
it is not the reason for their existence.

*Information systems* can be divided into two vague groups (the terminology here is very incoherent
and often spoiled by marketing): *Company Information Systems* (*Integrated Information Systems*) and
*Specialized Information Systems*. The latter usually represents only a single agenda (e.g. inventory or facility)
while the former *should* integrate all agendas of the company into one system.
Strictly speaking, an information system is not only a piece of software. As I have shown with the database, it is
irrelevant what tools are used. Therefore an integrated information system should include
processing of all data in a company regardless of the tools used for the processing. The point of information
system is to organize all data a company has. In some situations a computer is a suitable tool (e.g. finance agenda),
in others situations a sticker with a form may be a more suitable tool (e.g. repairs agenda).

### Integrated Information System
Why do I distinguish and emphasize *integrated* information system? Because it is an ultimate
and mostly unreachable goal of data processing. In practice, every company has information systems
with various degrees of integration.

Usually the company information system is composed of unrelated sub-systems (specialized IS). Each of them
has its own application code and each of them has its own database. This means that the
structure of the data is tied to each sub-system requirements. And because there are unlimited ways how a piece
of data can be structured, it usually means that they are **incompatible**. And when data is
stored in incompatible structures, it leads to **isolation**. When data is isolated, it means it
must be stored in multiple copies (each in a different format) which means **redundancy**. When there
is redundant data, it sooner or later leads to data **inconsistency**. Inconsistency means that part of the
company information system says A, and another part says B. No one wants that.

Assume that you have a company and hire a new employee. You need her to come to the office, so you give her
an access card and enter her into the *access system*. When the payday comes, the accountant realizes that in the
*accounting system*, the card number is associated with a previous employee and does not
know on what days the new employee went to work. No one wants that.

### Redundancy et. al
*Isolation* and *Incompatibility* means that data can be *reliably* used only by the 'owning' application. This
is because the data is either unreadable (unknown, proprietary or encrypted format) or that the
data is unintelligible (an unknown structure and no documentation). *Redundancy* means that one piece of
data is stored in multiple locations. This should be not confused with backups, because backups:

- maintain the structure of the original data,
- have a clear master-slave (origin-copy) relationship.

This is ensured by a very simple rule -- you don't write a piece of data directly to the backup. In case
of two information systems, the origin of the piece of data can be anywhere. This means that in case of
redundant data, it is incompletely updated (only in one system) which leads to *inconsistent* information
in the whole system. It also means that [ad-hoc](https://en.wikipedia.org/wiki/Ad_hoc) queries are really
complicated (and therefore expensive) if they need data from two systems.

Another issue related with separate information systems is that it is hard to ensure consistent data
integrity and security. Let's say that you would like to solve the above problem by giving the
accountant write permission to the *access system* so that he can enter a new employee consistently in all places.
But in that case, the accountant would be e.g. allowed to set specific *access points* allowed for each employee, which you don't want. A similar situation is with data integrity.

### Data Integrity
**Integrity** is the *state* of data (database) when all data is complete and correct. What
*correct* means is determined by **integrity constraints**, e.g:

- Age is a positive integer.
- Every person is of some age (age cannot be empty).
- Every person has an address (the address cannot be empty).

However integrity constraints are not easy! E.g. what is the maximum correct age? 100? 140? It is certainly
possible for someone to be over 100, but if 50% of your users are of age over 100, it is probably not correct.
Similarly, what is the minimum age? 0? 1? Is it correct if all your users are of age 1? Defining hard
integrity constraints is very difficult and sometimes right impossible. **Integrity violation** occurs
usually by bad or missing *integrity constraints* and therefore by bad **data sanitization**.

### Information Systems Integration
Why would anyone use separate information systems then? It happens automatically by the
development of a company. As soon as new agenda emerges, or an application is implemented for
that agenda, something is left by. Leftover legacy systems which do not integrate with anything tend
to accumulate. Another common reason is a company merger in which it is difficult to integrate
existing information systems together. And finally a common reason is pure laziness.

To avoid having isolated systems there are two main options:

- a centralized data storage
- a network of distributed systems with defined interfaces

I will concentrate on the first approach as it is much simpler. I will get into more details
about the [second approach later](todo). A centralized data storage ensures that data has
one true master version. All applications then connect to a single database. This does not need
to be physically a single machine, but logically it must be one point of (write) access.

A centralized Database system ensures that all data is stored and managed in one place. The
physical data files have a set structure, hidden to the outside world. The database system ensures
that data may be accessed only using the database system interface and that the structure of the
database is maintained. Apart from that, the database system takes care of
[concurrent access](https://en.wikipedia.org/wiki/Concurrency_(computer_science)) of multiple users,
permissions and data integrity. It is also important to note that database system operations are
optimized and have lower [**time complexity**](https://en.wikipedia.org/wiki/Time_complexity).

Database System is therefore the best tool to build a centralized information system. It is also
a great tool to build any kind of an information system or any other kind of an application which
deals with bulk data processing.

## Database Systems
A database systems in general are very versatile tools and there are many different types of them.
A single database system may serve for different purposes depending on its design and configuration.
There are no clear boundaries or definitions, however there are some basic categories:

1. OLTP systems -- [Online Transaction Processing](https://en.wikipedia.org/wiki/Online_transaction_processing).
These are databases which power core of every integrated information system. OLTP databases concentrate
on collecting data. Utilization of OLTP databases is characterized by frequent writes and updates. Select queries
are fast and not too complex (not joining more than a couple of tables).
2. DWH -- [Data Warehouse](https://en.wikipedia.org/wiki/Data_warehouse). Data warehouses serve as the
backend for analytical (management) information systems
([OLAP](https://en.wikipedia.org/wiki/Online_analytical_processing)). Typical utilization of DWH databases are
very complex read queries (with possibly hundreds of joined tables) and no
or very few data updates. DWH databases retrieve data from OLTP databases.
3. Other -- Fallback category for all other databases for text processing, image processing, predictions, etc.

Each database type may use different technologies, but the [SQL language](/articles/sql-join/) or something similar to it is used
in most of them. SQL is a standardized programming language which is used as
an interface to many database systems. Applications communicate with the database system
by sending *queries* -- pieces of an SQL code. Basic operations with data and database queries are
`INSERT`, `SELECT`, `UPDATE`, `DELETE`. These four operations are so common that they have
their own acronym -- [CRUD](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete)
(Create, Read, Update, Delete). Every database used in an OLTP system allows CRUD, also every
OLTP system allows CRUD. However, Data Warehouses are usually non-CRUD databases.

## Data Model
I started this article by stating that database contains *structured* data. To define
*structure* of data a **data model** is used. A data model is set of resources to model
and describe data. Output of a data model is *database schema* -- declaration of
the **database structure** (database template).

To avoid confusion, keep in mind that:

- *Database* is something which can hold data.
- *Database schema* is description of database structure.

Data models may be created with various tools. You may have encountered
[Object data modeling](https://en.wikipedia.org/wiki/Object-oriented_programming).
*Object data model*, *hierarchical data model*, *relation data model* and others are all different
approaches to the same problem.

### Hierarchical Model
The [*hierarchical data model*](https://en.wikipedia.org/wiki/Hierarchical_database_model) is probably
the oldest approach to data modelling. Data is organized in [tree structures](https://en.wikipedia.org/wiki/Tree_structure).
The relation between records is parent-child where a child has one parent and one parent can have more children.
This model is not very suitable for general use databases, but it is still widely used in special applications:

- DNS, LDAP,
- file systems (with links ignored),
- XML (sometimes HTML is considered hierarchical too -- as a text it is,
but [HTML DOM](https://en.wikipedia.org/wiki/Document_Object_Model) isn't)

### Network Model
The [*network data model*](https://en.wikipedia.org/wiki/Network_model) is an extended hierarchical model. Each
record (vertex) can be connected to any number of different vertices. It handles relations 1:N, M:N and
cyclic relations nicely. It is very universal and flexible, but it has hardly an usable implementations. Considered as a network model with limitations:

- file system (links not ignored)
- [HTML DOM](https://en.wikipedia.org/wiki/Document_Object_Model) (Document Object Model)

The network model is probably superseded by [Graph databases](https://en.wikipedia.org/wiki/Graph_database) which
are based on [Graph Theory](https://en.wikipedia.org/wiki/Graph_(abstract_data_type)) (not to be confused with charts).
Graph databases are being actively developed and are very suitable for some special databases -- e.g timetables
and connections.

### Relational Model
The [*relational data model*](https://en.wikipedia.org/wiki/Relational_model) describes data with
[relations](/articles/relational-database/#relational-algebra). It gave birth to the
relational algebra and the SQL language. As is it still
the most versatile database model, I will concentrate on it in a [separate article](/articles/relational-database/).
Relational Database Systems (RDBS) are the most commonly used database type in information systems.

### Object (Object-Relation) Model
The [*object oriented data model*](https://en.wikipedia.org/wiki/Object_database) seeks to
fill the gap between an object oriented application code and relational database storage.
It retrieves data from a database in form of objects. Some databases are using a relational
database underneath, some are using proprietary object storage.
Object databases support object oriented features such as class hierarchy, inheritance
and encapsulation. They should be faster than converting from RDBS.
While there are some object oriented databases actively developed, it is hard to see any
rapid boom or expansion.

## ACID
[ACID](https://en.wikipedia.org/wiki/ACID) is a principle on which most 'normal'
databases operate. It is represented by the following properties:

- **Transaction** -- one action, optionally composed of multiple operations
(e.g. insert a person together with contact information and meetings, …).
- **Atomicity** -- either all operations in a transaction must be performed,
or none of them (*rollback*).
- **Consistency** -- before and after the transaction, the database is in
a consistent state, during the transaction it may not be.
- **Isolation** -- concurrently running transactions behave **as if** they
are running sequentially.
- **Durability** -- a finished transaction is permanent.

### Transaction
ACID represents what common sense expects from a *reliable* database. Imagine that there is
a customer in a shop buying a mobile phone. The whole purchase process is a *transaction*. The
transaction includes operations:

- the customer pays the money
- the shopkeeper receives the money
- the shopkeeper gives the customer a receipt
- the shopkeeper removes the mobile phone from his stock
- the shopkeeper gives the mobile to the customer
- the customer receives the mobile phone
- the customer receives a receipt

Notice that the order of operations is more or less arbitrary -- i.e. it does not
matter whether the customer pays first or receives the mobile first. The *atomicity* property
means that to the outside world the entire transaction looks as if it was a single
indivisible (hence *atomic*) operation. The customer goes to a shop and either *buys* a mobile phone, or
*does not buy* a mobile phone.

*Consistency* supports this in that respect that after the transaction the customer
is without the money but with a mobile phone and the shopkeeper is without a mobile phone but has
the money. After the transaction, both of them have their integrity. During the transaction, the
integrity may be violated at some time as the customer or the shopkeeper may have both the money
and the mobile phone.

*Durability* supports this by requiring that once the transaction is complete,
there is no way back. The customer can change his mind and return the mobile, but that would be another
transaction and it is recorded forever that he *bought* the phone and *then returned* it.
It would be dangerously confusing if the customer was allowed to scratch the entire transaction without
trace. For example, what would happen if someone else wanted to buy the phone before the first customer returned it?
The shop records would state that the mobile was on stock, yet it actually was not.

Speaking of multiple customers, what happens if two customers come into the shop at the same time?
The shopkeeper obviously serves one first and lets the other one wait. He serves them in *sequence*.
What if there are two shopkeepers and two customers at the same time wanting the same mobile phone?
Well, one of the shopkeepers will grab the box with the mobile phone first. The other one will have
to turn his customer down. Therefore to the outside world, it would again seem that the customers
were served in *sequence*. This is what the *Isolation* property means.

In database systems, there are three basic commands associated with *Transaction*:

- START / BEGIN -- initiate a transaction
- COMMIT -- finish transaction in a successful manner
- ROLLBACK -- cancel the transaction (restore the state as it was before the transaction)

### BASE
The alternative to an ACID database is a **BASE** database:
**B**asically **A**vailable, **S**oft state, **E**ventual consistency.
It does not have the properties of the ACID database, instead it requires only that once a
record is not being updated any more, then all queries to that record will **eventually** return
consistent results. BASE databases are used only when ACID databases cannot be used for
some reason. That reason usually is very high concurrency and very high concurrency
in database systems means *millions* of simultaneous (concurrent) users. Typical examples
of such applications are massive services provided by Facebook or Google.
The high concurrency causes a bottleneck together with the Isolation principle. But without the
isolation principle, concurrent transactions cannot be executed reliably, so that
knocks down the entire ACID approach for highly concurrent environments.

## Query Language
I have already mentioned, that applications communicate with their databases
using the [SQL language](https://en.wikipedia.org/wiki/SQL). You may have also spotted that the SQL language is connected with
the relational database model.
In an SQL database server, the database server processes each query (a piece of the SQL code) received
from an application and either modifies the data or returns some data to the application.
Although the SQL language was indeed designed for the relational
database model, over the years it has found its way to other types of databases as well.
The relational database model and the SQL language naturally expect an ACID database, but the
SQL language may be used in a BASE database as well.
Similarly, the SQL language was designed for CRUD databases, but it is used in non-CRUD
databases as well.

On the other hand, there are [NoSQL](https://en.wikipedia.org/wiki/NoSQL) databases which
for many different reasons do not use SQL. At some recent point there was
a hype about that SQL is full of flaws, or just plain wrong and it should be abandoned.
This gave birth to NoSQL databases which did not use SQL for rebellious reasons. Then there are
databases which do not use SQL because it is not suitable for them. These are mostly BASE
databases, graph databases and some object databases. Although most of them try to use
some sort of a query language. However, none of the alternative languages is as widespread as SQL.
Then there are some databases which try to workaround limitations of the SQL language by
allowing other methods to access the data and in that case they are NOSQL meaning *Not Only SQL*.
Yes, it is quite confusing.

## Storage
To further add to the confusion, database systems may use different approaches to storing data. The
basic approaches are:

- [Row (record) storage](https://en.wikipedia.org/wiki/Relational_database_management_system) is used mainly by
relational database systems. Typically the record to be stored (e.g. information about a person) is stored as
a row in a database table. Row Storage is typically used in OLTP systems.
- [Columnar storage](https://en.wikipedia.org/wiki/Column-oriented_DBMS) is also used by relational database
systems. Columnar storage was designed to avoid performance issues with OLTP databases with complex computations.
A record in columnar storage is first split into individual values and each value is stored in its own column. Usually,
columnar databases have very high compression ratios, excellent performance for complex SELECT queries and poor
performance for data modification queries. They are suitable for data warehouses.
- [Key-value storage](https://en.wikipedia.org/wiki/Key-value_database) is used by non-relational database
systems and usually by NoSQL database systems. Records are stored simply as key-value pairs in a form similar to
[associative arrays](/walkthrough-slim/backend-intro/array/). Key-value databases
are used mainly when the structure of the data cannot be fixed. An
example is [Windows Registry](https://en.wikipedia.org/wiki/Windows_Registry) which contains configurations for
different applications (which are obviously different). By the way, Windows registry is also a hierarchical database.
- [Document storage](https://en.wikipedia.org/wiki/Document-oriented_database) is a variant of a key-value database in
which the value itself is a structured document (usually in [JSON](https://en.wikipedia.org/wiki/JSON)
or [XML](https://en.wikipedia.org/wiki/XML) format). Document storage can be seen as a transition between relational
databases and key-value databases. It is often used as an extension of relational databases which then allow storing
so called [semi-structured](https://en.wikipedia.org/wiki/Semi-structured_model) data.

## Summary
In this article, you have learned the basic concepts required for working with data. Also you should
know why databases are being used and what information systems are. I have presented multiple points of
view on looking at database systems. According to the *utilization* DBS are divided into OLTP and DWH. According to
the *data model* they can be split into Relational DBS, Graph DBS, etc. According to the *principle* they can be divided into ACID and BASE.
According to the *query language* they can be split into SQL and NoSQL (and perhaps NOSQL). According to the *storage* they
may be divided into Row databases, Key-Value databases, etc. A single database system may sometimes fall into multiple
categories. Therefore do not look for any definitive list of what database system belongs to what category.

To simplify things, I will focus only on **SQL ACID relational OLTP row-storage** databases in the rest of this book.
because that is the starting point of many applications and it is also the easiest and most proven concept.
Even if you later switch into other technologies you should have notion about this basic database type.
I will deal with the SQL language in more detail in the [next article](/articles/sql-join/).

### New Concepts and Terms
- data
- information
- database
- interface
- information system
- integration
- isolation
- incompatibility
- inconsistency
- integrity
- redundancy
- integrity constraint
- OLTP
- DWH
- CRUD
- data model
- relational model
- transaction
- atomicity
- consistency
- isolation
- durability
- commit
- rollback
- SQL
- columnar database
- key-value database
