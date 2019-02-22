---
title: APV Course
permalink: /course/
redirect_from: /en/apv/course/
---

* TOC
{:toc}

## Course information
The aim of the course is to teach students basic categories of application software. Emphasis is given on
the development of web applications and database applications (relational database systems).
[Official course information](http://ects-prog.mendelu.cz/en/plan8905/predmet1099?lang=en)

## Requirements
To pass the course you have to:

- get at least 90 points on [Codecademy](https://www.codecademy.com/) -- [**Verify**](http://odinuv.cz/course/codecademy.php)
- finish the [course project](#project-assignment)
  <!--
  -- [**First evaluation**](https://akela.mendelu.cz/~lysek/apv/vysledky.txt)
  -->
- pass the final exam (minimum 50% points)
  - you have to answer at least 2 of 3 SQL queries somewhat correctly

The grade from the final exam and the project evaluation make up for the final course grade.

## Course outline

- Week 1
    - Articles: [Web](/articles/web/)
    - Exercises: [HTML](/walkthrough-slim/html/) and [HTML Forms](/walkthrough-slim/html-forms/)
    - [Presentation slides](/slides/web/)
    - [Presentation slides](/slides/html/)
- Week 2
    - Articles: [HTML](/articles/html/)
    - Exercises: [PHP](/walkthrough-slim/backend-intro/)
    - [Presentation slides](/slides/web-technologies/)
- Week 3
    - Exercises: [Latte](/walkthrough-slim/templates/) and [Latte Templates](/walkthrough-slim/templates-layout/)
    - [Presentation slides](/slides/database-systems/)
- Week 4
    - Articles: [Relational Database Systems](/articles/database-systems/)
    - Exercises: [SQL](/walkthrough-slim/database-intro/) and [Working with database](/walkthrough-slim/database-using/)
    - [Presentation slides](/slides/relational-database/)
- Week 5
    - Articles: [Database Systems](/articles/database-systems/)
    - Exercises: [Slim introduction](/walkthrough-slim/slim-intro/) and [Selecting data](/walkthrough-slim/backend-select/)
    - [Presentation slides](/slides/sql-join/)
- Week 6
    - Articles: [SQL Language](/articles/sql-join/)
    - Exercises: [Inserting data](/walkthrough-slim/backend-insert/)
    - [Presentation slides](/slides/sql-aggregation/)
- Week 7
    - Articles: [Database Design](/articles/database-design/)
    - Exercises: [Application Layout](/walkthrough-slim/css/bootstrap/) and [Bootstrap](/walkthrough-slim/css/bootstrap/)
    - [Presentation slides](/slides/database-design/)
- Week 8
    - Articles: [SQL Aggregation](/articles/sql-aggregation/)
    - Exercises: Advanced SQL querries (see article)
    - [Presentation slides](/slides/database-tech/)
- Week 9
    - Articles: [Database Systems -- Sequences, Constraints, Keys](/articles/database-tech/)
    - Exercises: [Deleting Data](/walkthrough-slim/backend-delete/) and [Updating data](/walkthrough-slim/backend-update/)
    - [Presentation slides](/slides/web-security/)
- Week 10
    - Articles: [Cascading Style Sheets](/articles/css/)
    - Exercises: [Advanced inserts](/walkthrough-slim/backend-insert/advanced/)
    - [Presentation slides](/slides/web-apps/)
- Week 11
    - Articles: [Security](/articles/security/)
    - Exercises: [Login](/walkthrough-slim/login/) 
    - [Presentation slides](/slides/application-development/)
- Week 12
    - Articles: [Web applications](/articles/web-applications/)
    - Exercises: [Pagination](/walkthrough-slim/pagination/)
    - [Presentation slides](/slides/finale/)
- Week 13
    - Work on Project

## Project Assignment
To pass the course you need to create a project. The project assignment is
described below:

> Create a web application for recording persons and contacts. The main goal of the application is
> to record persons (friend, acquaintances), their addresses, relationships and meetings.
> Each person can have a name, nickname, age, location and contacts. Each person can have any
> number of contacts (mobile, Skype, Jabber, ....). A person can have more contacts of the
> same type (e.g. two emails). Each person can have any number of relationships
> with other persons in the database. Each relationship should be of a type (friend, fiend, acquaintance, spouse, ...)
> and description. The contact and relationship types are recorded in the database and can be modified by
> the end-user. The application also records meetings between persons. Each meeting can be joined by any number of persons.
> Each meeting should have a place and date.
> The application must allow user friendly entering and modifying the data. Take advantage of the proposed schema,
> create a database and implement the entire application.

The assignment is intentionally very loosely defined. It is up to you to come up with the
application design, functionality and user interface. It is not an easy task, so I have designed a
[database schema](/walkthrough-slim/database-intro/#database-schema) for you.

{: .image-popup}
![Database Schema](/common/schema.svg)

The database schema defines what kind of data your application should store. You can change it
if you want to do so, but please do so only after you understand
the [database design process](/articles/database-design/).

### Custom assignment
It is possible to have a different assignment, but it has to be equally (or more) challenging as the default one.
It has to use some database with more than one table and it should feature different types of cardinality.

### Technologies
You are free to choose what technologies you want to use to complete the project assignment, I will
teach you how to use [PHP](/walkthrough-slim/backend-intro/) and [Slim framework](/walkthrough-slim/slim-intro/).
The only condition is that you have to use up-to-date methods to build the project.

Check the [FAQ section](/course/faq/) for more information.