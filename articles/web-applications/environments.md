---
title: Environments
permalink: /articles/web-applications/environments/
---

* TOC
{:toc}

Any application (not just web application) has to be developed, tested and deployed (when approved by the customer).
All of these steps are usually performed on different computers. You can imagine your application as a guest living
in different hotel rooms all around the world. You want to create a nice compatible application which can easily
live in different hotels without many problems. Because you (or somebody from your team) will be responsible for
configuring and installing the application for each environment. Therefore you need to prepare your application
for this and not hard-code any important setting into your source code.

What can be different:
- database credentials (100% will be different for different machines)
- paths to files
- filesystem (e.g. permissions on Windows VS Linux)
- version and configuration of operating system and/or interpreter
- available libraries and their versions
- network connectivity
- hardware

## Environments

### Development
The environment for developers. Each developer has slightly different one. You should be very careful to design
your application in a way that new developer does not have difficulties setting up the application when he joins
your team. You will be responsible for explaining the setup to him so you will save your own time.

### Testing
Usually one or few machines in your company where the application is installed before planned release and manually
or automatically tested.

### Production
The environment used by your users/customers. You do not want to mess this up. Only tested application can be deployed
here. Design and document the update process. Use automation scripts to avoid errors and mistakes (manual update is
tedious). You should be able to revert to previous version quickly when update goes wrong.

## Difference between out-of-the-box software and custom software
Developing out-of-the-box software (like operating system, office applications package or video player) is much more
difficult because you need to be prepared for thousands and thousands of different configurations. Custom software is
usually controlled by company which created it and is installed only on limited number of machines with much more
controlled configuration (concerning HW and OS).

{: .note}
Web applications are even better, they are installed on very few, usually only one, server.

## The .env file
Modern frameworks often use main configuration file called `.env`. The idea is that you have a text file with
environment related key-value configuration pairs in the root of your project. This file should be ignored by Git to
avoid sharing your settings and passwords with other programmers (or their passwords with you). Anyway, Git repository
should contain an example file, e.g. `.env.example` which you can copy and customize for current machine.

{: .alert}
The `.env` file should be hidden from visitors. You should let Apache web server see only the contents of public folder
to avoid opening URL such as `http://your-site.com/.env`.

Hiding `.env` files in `.htaccess`:

```
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

There are [libraries](https://github.com/vlucas/phpdotenv) which implement parsing `.env` file and reading values
from it. In your code you just use a function (e.g. `env()`) which can read out a value from `.env` file and return
the value.

{: .note}
Always have alternative/default value prepared for given environment variable variable.

The `.env` file does not have to contain only database credentials. You can store many more configuration directives
that can activate or deactivate various functions of your application.

{: .note}
The `.env` file is usually given and user of the application cannot do anything with predefined values.

## Dials and user config
Do you remember those two tables called `contact_type` and `relation_type` from your course project? They are typical
dial tables. They are there to store possible types of something. The reason to use such dials is to allow certain
customisations for different instances of your application. When you install a new instance of your application,
you can add or remove values from these tables according to requirements of particular user. You can also translate
those values.

{: .image-popup}
![Database Schema](/common/schema.svg)

The level of customisation is obviously limited by the design of application. There is a trade off between the level
of customisation and complexity of source code. You should try to allow as much customisation as possible with
relatively small complexity increase of source code to cover most user requirements.

{: .note}
It is a good practice to allow users of the application to modify values in dial tables. The ability to modify
these values can be conditionally dependent on user privileges (e.g. admin user).

## Summary
You are developing an application, it will usually not be used only by you and not run on your computer. Keep this in
mind.

### New Concepts and Terms
- Environments
- Development
- Testing
- Production
- .env
- dials
