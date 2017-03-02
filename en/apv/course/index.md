---
title: APV Course
permalink: /en/apv/course/
---

* TOC
{:toc}

## Course information
The aim of the course is to teach student basic categories of application software. Emphasis is given on
development of web applications and database applications (relational database systems).
[Official course information](http://ects-prog.mendelu.cz/en/plan6937/predmet88060)

## Course outline

- Week 1
    - Articles: [Web](/en/apv/articles/web/)
    - Exercises: [HTML](/en/apv/walkthrough/html/), [HTML Forms](/en/apv/walkthrough/html-forms/)
    - [Presentation slides](/en/apv/slides/web-internet/)
- Week 2
    - Articles: [HTML](/en/apv/articles/html/)
    - Exercises: [PHP](/en/apv/walkthrough/dynamic-page/)
    - [Presentation slides](/en/apv/slides/html/)
- Week 3
    - Articles: [Database Systems](/en/apv/articles/database-systems/)
    - Exercises: [SQL](/en/apv/walkthrough/database/)
    - [Presentation slides](/en/apv/slides/database-systems/)
- Week 4
    - Articles: [Relational Database Systems](/en/apv/articles/database-systems/)
    - Exercises: [Latte](/en/apv/walkthrough/templates/) and [Latte Templates](/en/apv/walkthrough/templates-layout/)
    - [Presentation slides](/en/apv/slides/relational-database/)
- Week 5
    - Articles: [SQL Language](/en/apv/articles/sql-join/)
    - Exercises: [Connecting to database](/en/apv/walkthrough/backend/), [Selecting data](/en/apv/walkthrough/backend-select/)
    - [Presentation slides](/en/apv/slides/sql-join/)
- Week 6
    - Articles: [SQL Aggregation](/en/apv/articles/sql-aggregation/)
    - Exercises: [Inserting data](/en/apv/walkthrough/backend-insert/)
    - [Presentation slides](/en/apv/slides/sql-aggregation/)
- Week 7
    - Articles: [Database Design](/en/apv/articles/database-design/)
    - Exercises: [Updating data](/en/apv/walkthrough/backend-update/)
    - [Presentation slides](/en/apv/slides/database-design/)
- Week 8
    - Articles: [Database Systems -- Sequences, Constraints, Keys](/en/apv/articles/database-tech/)
    - Exercises: [Application Layout and Templates](/en/apv/walkthrough/css/bootstrap/)
    - [Presentation slides](/en/apv/slides/database-tech/)
- Week 9
    - Articles: [Cascading Style Sheets](/en/apv/articles/html/css/)
    - Exercises: [Advanced Inserts](/en/apv/walkthrough/backend-insert/advanced/todo)
- Week 10
    - Exercises: [Deleting Data](/en/apv/walkthrough/backend-delete)
- Week 11
    - Exercises: [Login](/en/apv/walkthrough/login/)
- Week 12 & Week 13
    - Work on Project

## Project Assignment
To pass the course you need to create a project. The project assignment is
described below:

> Create a web application for recording persons and contacts. The main goal of the application is
> to record persons (friend, acquaintances), their addresses, relationships and meetings.
> Every person can have a name, nickname, age, location and contacts. Each person can have any
> number of contacts (mobile, Skype, Jabber, ....). A person can have more contacts of the
> same type (e.g. two emails). Each person can have any number of relationships
> with other persons in the database. Each relationship should have type (friend, fiend, acquaintance, spouse, ...)
> and description. Contact and relationship types are recorded in database and can be modified by
> the end-user. The application also records meetings between persons. Each meeting can be joined by any number of persons.
> Each meeting should have a place and date.
> The application must allow user friendly of entering and modifying the data. Take advantage of the proposed schema,
> create a database and implement the entire application.

The assignment is intentionally every loosely defined. It is up to you to come up with the
application design, functionality and user interface. It is not an easy task, so I have designed a
[database schema](/en/apv/walkthrough/database/#database-schema) for you.

{: .image-popup}
![Database Schema](/en/apv/schema.svg)

The database schema defines what kind of data your application should store. You can change it
if you want to, but please do so only after you understand the [database design process](todo).
