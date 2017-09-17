---
title: Security of web applications
permalink: /articles/security/
redirect_from: /en/apv/articles/sql-aggregation/
---

* TOC
{:toc}

Security is an important issue on web, applications are publicly available and literally anyone can open your website
and try to gain access to restricted functions or exploit some known vulnerability. The web application has a very
limited means to defend itself - HTTP protocol is stateless, IP addresses are dynamically allocated and can be
obfuscated easily, the communication between clients and web server is transmitted over wires and devices which are
controlled by various entities...

Moreover, most web applications are not continuously maintained -- it means that a contractor made the application,
deployed it, and the owner (usually not technically skilled person) does not want to invest any more money to fix
eventual bugs which does not affect him directly. The price which a client is willing to pay affects also the quality
of a hired contractor -- a good web developer is more expensive than inexperienced one. The fact that web applications
are also seemingly easy to produce makes it even worse.

Another issue with web applications is that they run on top of a stack build with many different technologies (various
operating system, various web servers, various execution environments -- e.g. PHP interpreters of various versions,
various database systems...). All of these components are vulnerable and the Internet is full of people or bots who
are trying to gain access into computers and applications and take them over with all kinds of motivations (from
general curiosity over financial motives to envy or even revenge).

There are many kind of security issues, some of them are less dangerous, some of them are very serious.

Read about web application security and risks:

- [SQL injection](/articles/security/sql-injection/)
- [Storing passwords and user authentication](/walkthrough/login/) - walkthrough article