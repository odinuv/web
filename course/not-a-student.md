---
title: I am not a student - a guide for external readers
permalink: /course/not-a-student/
redirect_from: /en/apv/course/not-a-student/
---

* TOC
{:toc}

This book is available online and is suitable for everybody, who is interested in web-site development with
minimal prior knowledge in this field. You should have basic understanding of programming, willpower and some
spare time to read this book and complete the assignments.

If you are not a student of [Mendel University](http://www.mendelu.cz) you will need some means to execute
your programs:

- web server with PHP 5.6 or higher
- database server (PostgreSQL or MySQL/MariaDB)
- web browser
- text editor or IDE

Most of tools I am going to recommend to you here are platform independent and free of charge.

## Web server with PHP and a database
This is the most complicated part for external readers -- I cannot provide you an execution environment for
PHP and you cannot execute your scripts without one. You have to obtain PHP interpreter and web server somehow.

Easiest way for a beginner is to register a free web hosting service. You can search online for phrase
[PHP free hosting](https://www.google.com/search?q=php+free+hosting). These services are usually not very
reliable but it is OK for start. These free hostings usually provide a third level domain name for free
(something like *yourname*.server.com). Sometimes they will place ads into your website which can scramble
your scripts a bit. You will get access codes to shared hosting server -- usually an FTP account. You can use
free FTP client like [FileZilla](https://filezilla-project.org/) to transfer your PHP script to a server.
They will also provide you a limited database account (one database, limited amount of space), usually MySQL
with [phpMyAdmin](https://www.phpmyadmin.net/) as control interface.

Better way is to rent a PHP hosting. These services are cheap -- not much more than a few dollars per month.
But you will have to purchase also a second level domain (*yourname*.com). Prices of domains are different
according to the top level domain (a domain with TLD .info is cheaper than .com). Domain price is also quite
low -- few dollars per a year. This environment is much more stable and obviously ad-free. You can also get
support from your service provider.

### Installing your own server on your PC
You can use [PHP development server](http://php.net/manual/en/features.commandline.webserver.php). This means that
you install PHP interpreter on your system, call `php -S localhost:8000` command in a terminal which opens specified
port (8000) and you can run your application directly from this small development server -- [http://localhost:8000](http://localhost:8000).
You will still need to install database server to work with a database.

#### Apache based stack and a database (advanced)
You can try to install [WAMP Server](http://www.wampserver.com) package or [XAMPP](https://www.apachefriends.org)
on Windows. PHP is configured as Apache module in this case and you do not have to execute it separately.

These packages contain [MySQL](https://www.mysql.com/) database instead of [PostgreSQL](https://www.postgresql.org/)
which is used in my examples. Most SQL queries is same in both systems and I tried to provide alternatives
and comments on MySQL in cases of difference. Another database system which you can encounter is
[MariaDB](https://mariadb.org/). This an open source variant of MySQL.

{: .note}
To install all these programs and make it work together at your own is **definitely a lot of work and effort**.
If you are absolutely lost and do not know where to start, try to register a free PHP hosting. You will get
better understanding of these programs and their roles in web application development after you read this book.

On Linux based systems use your package manager to download Apache, PHP and PostgreSQL. Your website should be
usually placed into `/var/www/html` directory. Installation of SQL server is a bit trickier because it
involves setting of user accounts -- consult manual.

After you install your own Apache+PHP+DB or PHP-dev-sever+DB stack, you should be able to execute your PHP script
from any internet browser by typing an address of your own computer: [http://localhost](http://localhost).
Default HTTP port is 80, if you use another, type e.g. [http://localhost:8080](http://localhost:8080).

To create a database or modify tables use a tool called [Adminer](https://www.adminer.org/). It is a single PHP
script placed anywhere in your web directory -- you can access it by typing e.g. [http://localhost/adminer.php](http://localhost/adminer.php).
I also use it in this book.

{: .note}
Another option is to use embedded database system like [SQLite](https://sqlite.org/). PHP has a plugin to work
with this type of database (just install it and/or enable it in PHP config file php.ini -- found in PHP's home directory).
You can then use PDO interface to communicate with it in your scripts and Adminer supports it too (you
just type path to datafile instead of hostname and port). This kind of database can be used with pure PHP
development server.

## Web browser
Any modern web-browser is suitable. I recommend [Mozilla Firefox](https://www.mozilla.org/en-US/firefox/new/) or
[Google Chrome](https://www.google.com/chrome/). Important feature which your browser should have is some kind of
developer tools with network console and DOM inspector. This feature is usually under F12 key or in application's
menu.

{: .image-popup}
![Opening developer tools](/course/developer-tools-open.png)

{: .image-popup}
![Developer tools - network console](/course/developer-tools.png)

## Text editor or IDE
You should at least install a text editor which is suitable for developers - important features are
[UTF8](https://en.wikipedia.org/wiki/UTF-8) support and syntax highlighting for PHP/HTML/CSS scripts.
Good choices are [Notepad++](https://notepad-plus-plus.org/) for Windows or [Geany](https://www.geany.org/)
for Linux. Another choice can be [Atom](https://atom.io/) editor which is multi-platform.

{: .image-popup}
![Geany](/course/geany.png)

I recommend to install full *IDE* (Integrated Development Environment) -- a free IDE called
[NetBeans](https://netbeans.org/) can be downloaded -- select PHP stack on download page.
[Eclipse](http://www.eclipse.org) IDE is also free but not much popular for PHP development
nowadays. There are also commercial IDEs like [PHP storm](https://www.jetbrains.com/phpstorm/).
In NetBeans you also get support for [Latte templates](/walkthrough/templates/).

If you had never worked with an IDE, do not bother yourself with this for now and just download a
good text editor. You can always switch to an IDE later.

{: .image-popup}
![NetBeans](/course/netbeans.png)
