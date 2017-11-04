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
[Official course information](http://ects-prog.mendelu.cz/en/plan6937/predmet88060)

## Requirements
To pass the course you have to:

- pass the midterm test (minimum 50% points)
- get at least 90 points on [Codecademy](https://www.codecademy.com/) --- [**Verify**](codecademy.php)
- finish the [course project](#project-assignment)
- pass the final exam (minimum 50% points)

The grade from the final exam and the project evaluation make up for the final course grade.

## Course outline

- Week 1
    - Articles: [Web](/articles/web/)
    - Exercises: [HTML](/walkthrough/html/), [HTML Forms](/walkthrough/html-forms/)
    - [Presentation slides](/slides/web/)
- Week 2
    - Articles: [HTML](/articles/html/)
    - Exercises: [PHP](/walkthrough/backend-intro/)
    - [Presentation slides](/slides/html/)
- Week 3
    - Articles: [Database Systems](/articles/database-systems/)
    - Exercises: [SQL](/walkthrough/database/)
    - [Presentation slides](/slides/database-systems/)
- Week 4
    - Articles: [Relational Database Systems](/articles/database-systems/)
    - Exercises: [Latte](/walkthrough/templates/) and [Latte Templates](/walkthrough/templates-layout/)
    - [Presentation slides](/slides/relational-database/)
- Week 5
    - Articles: [SQL Language](/articles/sql-join/)
    - Exercises: [Connecting to database](/walkthrough/backend/), [Selecting data](/walkthrough/backend-select/)
    - [Presentation slides](/slides/sql-join/)
- Week 6
    - Articles: [SQL Aggregation](/articles/sql-aggregation/)
    - Exercises: [Inserting data](/walkthrough/backend-insert/)
    - [Presentation slides](/slides/sql-aggregation/)
- Week 7
    - Articles: [Database Design](/articles/database-design/)
    - Exercises: [Updating data](/walkthrough/backend-update/)
    - [Presentation slides](/slides/database-design/)
- Week 8
    - Articles: [Database Systems -- Sequences, Constraints, Keys](/articles/database-tech/)
    - Exercises: [Application Layout and Templates](/walkthrough/css/bootstrap/)
    - [Presentation slides](/slides/database-tech/)
- Week 9
    - Articles: [Cascading Style Sheets](/articles/css/)
    - Exercises: [Advanced Inserts](/walkthrough/backend-insert/advanced/todo)
- Week 10
    - Exercises: [Deleting Data](/walkthrough/backend-delete)
- Week 11
    - Exercises: [Login](/walkthrough/login/)
- Week 12 & Week 13
    - Work on Project

## APVA Class

- Week 2:
    - [Basic HTML](\course\apva\basic-html.html)
    - [Form Elements](\course\apva\form-elements.html)
    - [Example Form](\course\apva\example-form.html)
- Week 4:
    - [Slim Framework](\course\apva\slim-framework.zip)
    - [Updated routes.php](\course\apva\routes-1.phps)
- Week 5:
    - [Updated routes.php](\course\apva\routes-2.phps)
    - [People list template](\course\apva\people.latte)

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
[database schema](/walkthrough/database/#database-schema) for you.

{: .image-popup}
![Database Schema](/common/schema.svg)

The database schema defines what kind of data your application should store. You can change it
if you want to do so, but please do so only after you understand
the [database design process](/articles/database-design/).
