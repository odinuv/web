---
title: Cookies and Sessions
permalink: /en/apv/articles/cookies-sessions/
---

* TOC
{:toc}

HTTP protocol was designed stateless, the cost for this simplicity is inability to maintain any kind
of information between subsequent HTTP requests from particular client on server's side. The server simply does
not know, whether it has talked to certain client before or not. Yet you know, from your own experience,
that this is possible.

You used a server-side storage called *session* in walkthrough article about [authentication](/en/apv/walkthrough/login)
of users. Let's take a step back and think about how to allow server identify its clients.

## Make HTTP stateful
From server point of view, you have thousands of HTTP connections from multiple clients at a time.
What means can be used to connect HTTP requests logically?

{: .note}
What does it even mean to "connect HTTP request logically"? It simply means, that the client itself sends
to the server some information which a server (or your application) **decides to believe**. This information
can be some unique key which is compared to some kind of server storage (database or file with all user keys).

What can you use as unique identifier? You have these options:

- IP address -- problems are non-static IP addresses and firewalls with many clients behind them. This
  means that one IP can represent many actual machines/users.
- a GET and/or POST parameter -- this can be done, but it is a lot of work for web developer.
- a cookie -- this is actually used.

{: .note}
Users with disabled cookies have to rely on GET/POST parameter. You can give your application an ability
to attach client identifier to **all links** and add it as hidden input to **all forms**. This would be used
as first response to all users (everybody will see session ID parameter in all generated URLs of first response
from your server). If a cookie is successfully set (and returned in second HTTP request), backend stops to
attach client identifier parameter to links and forms. This is a **lot** of work (you also have to handle
search engine crawlers -- they do not support cookies and you do not want your page to be indexed with some
cryptic URL parameters).

## Cookies
A cookie is a general purpose **client** side storage. You can store short strings under a named identifier.
You might be asking how a client-side storage is helpful to maintain state on a server? I already told you --
server decides to believe information from a client, that is all you have. The client is used to store its
own state for server.

This is not quiet safe, because anyone (user or software) can access and modify cookie files stored by a
browser. Therefore it is wise to store only a key to identify user data repository on server (read on).

A **bad** usage of cookie is to set ID or login of a user which is logged on. Anybody can change this
information and pretend that he is somebody else.

### Task try to set a cookie and read it
Store some useful information with a cookie.

### Security
Cookies can be stolen or modified.

### Setting up a cookie
HTTP headers.

### Cookie parameters
Duration. Domain.

## Sessions
The session uses client's cookie storage to save a key (*session ID*) which is used to identify one particular
repository of client related data on a server. This is much safer because data in session can only be modified
by application's code. Still you have to believe that session ID which is supplied by a random client belongs
to him.

### Task try to set some session data and read it

### Session cookie parameters
Almost the same as cookie but can be set up by another function.

## What to store in session or cookie?
A visitor can have multiple tabs or windows with your web application opened at once. Therefore it is not a good
idea to store values which can vary between those instances (e.g. search query or page number). You have to
carefully select what to store in session and what to pass as request parameter.

## Summary

### New Concepts and Terms
- cookies
- session
