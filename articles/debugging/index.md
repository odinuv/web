---
title: Debugging web applications
permalink: /articles/debugging/
---

* TOC
{:toc}

Your application will definitely have bugs. All applications have bugs. You will encounter most of them during
development and in early days or weeks of deployment. You may encounter a bug which was introduced many months or
even years ago, but these situations are quite rare. Sometimes you immediately know where the bug is -- the interpreter
says that there is an error on line X, in file Y. You open file Y, go to line X and fix that stupid typo.

Sometimes the bugs are less easy to spot, sometimes the reason why the application does not work is even combination
of multiple bugs or mistakes at once. Sometimes, especially for beginners the source of error is confusion or
misunderstanding of the technology. The first problem can be overcome by making only small changes at once in the code
and to test often, the latter by **gaining experience**. The worst thing you can do when you got badly stuck is to
move away from the problem and start working on another part of the application -- you usually end up in similar
situation somewhere else. You will get totally chaotic source code which does not work at all as a result. **The fact
that you got stuck with some problem is a signal to learn more or seek help, not to run away.** The only way to
overcome a problem is to break it into peaces and solve them one by one.

I mixed two different things in the previous paragraph, bugs are **errors in the source code of already written and
running application**. You have to have at least a basic idea of the problem solution and you have to have an
application which somewhat works or should be working by your measures. This article is not about methodology of problem
solving. I just needed to point out, that there are two types of "being stuck".

It is a relief to know that with gaining more experience in programming you will also gain more insight and a certain
ability to feel the right direction where to go and what to do to find a bug and fix it or solve a problem.

{: .note}
This article is meant for beginners. It describes debugging of web application written in PHP with minimal knowledge
of IDEs, debuggers and no capabilities to install a PHP extension.

## Be prepared for bugs
Be prepared that you application will contain bugs. Use try-catch statements around SQL queries, check user inputs. Use
logger to store exception messages or other non-standard situations. You can also [raise exceptions](http://php.net/manual/en/language.exceptions.php)
using `throw` keyword or trigger [user-level errors](http://php.net/manual/en/function.trigger-error.php) when your
code runs into unknown situation.

~~~ php?start_inline=1
function factorial($input) {
    if($input < 0) {
        //forbidden value -> throw an exception to let the code which called this function know
        //this also ends the execution of this function
        throw new Exception('Input out of range');
    }
    if($input > 1) {
        return $input * factorial($input - 1);
    } else {
        return 1;
    }
}
~~~

Small advantage for debugging of PHP applications is that applications is just a bunch of scripts executed
only to handle HTTP request. The application does not have any hidden state between the requests, everything is
stored in the database, session or cookies -- it can be easily inspected.

## Determine where the problem is
The hardest part of fixing a bug is finding it. A web application is a complex system, it can run on multiple machines,
some bugs are only apparent with certain web browsers/servers (or even in certain versions). The problem can be in the
frontend, in the backend, it can be in the interface between these two or in the database. Let me describe the process
from a higher perspective first.

### Replicate
Worst kind of bugs are those that happen randomly. Such bugs unfortunately exist, but they are rare. Most of the bugs
happen in certain situations, it might seem random at first, but there is some parameter or combination of parameters
that reliably trigger the bug.

First thing that you need to do is to be able to replicate the problem. Sometimes you need to go through a quite long
sequence of steps. Once you definitely know, what to do to trigger the bug, you can continue to the next step.

### Isolate
Sometimes it is easy: you fill a form, click submit and there is an error message on your screen. Everything you need
to do to retry is hitting F5 in the browser and the same error appears. You can change the code until the error goes
away. In some situations, you have to write a short script which executes some code to simulate some conditions. 

Your goal in this phase is to minimise the effort to trigger the error so you can efficiently fix the problem. You also
want to minimise the amount of code that gets executed because by doing this, you are targeting potentially problematic
lines of code.

You can change your source code a little to stop the execution at some point or to lock some values.

{: .note}
You can have troubles to determine whether the problem is in the backend or in the frontend code, especially with
JavaScript-heavy applications. Check the interface (HTTP communication) between those two components whether the
expected payload arrived/was dispatched to/from the frontend. Than you should know where to aim your effort.

### Investigate
Now it should be clear where the bug is. At least you have minimised responsible pieces of code to a minimal possible
amount. Dive into your code and find the problem.

You usually need to peek into the variables, the code often does not work because you expect some variable to
contain certain value and the value is actually different. 

There is two possible scenarios:
- The variable is OK, but the code acts differently than you expected -- you found the problem.
- The code is OK, but the content of variable is wrong -- find the source of wrong variable value (the bug is
  actually somewhere else, but you can trace the variable to its source).
  
Another reason is wrong order or missing/needless steps etc.

Sometimes the source of the problem is not inside your code, it can be the settings of PHP, change of behaviour of
a browser, misinterpreted SQL database behaviour, usage of undocumented functions, change of external API...
Keep in mind, that as web developer, you usually build your application on thousands of lines of code from others.
You have to follow the standards and read the documentation to use the functions correctly.

{: .note}
Beginners often create errors because they lack the experience with particular technology as I mentioned in the
introduction of this article.

## Fix the bug
Obviously. Remember to delete all the code that you added to support your process of isolation and investigation of the
bug. You do not want to get reports of mysterious values appearing all around your website from your users.

I will focus on common practices of debugging for different parts of web applications in the following articles:

- [Backend debugging](/articles/debugging/backend/)
- [Frontend debugging](/articles/debugging/frontend/)

## Summary
Read the sub-articles to understand backend and frontend debugging.

### New Concepts and Terms
- debugging
- searching for error
