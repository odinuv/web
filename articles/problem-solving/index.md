---
title: Solving a problem
permalink: /articles/problem-solving/
---

* TOC
{:toc}

You have been [told to make a web application](/course/#project-assignment) which stores records about persons,
contacts, meetings etc. and you are absolutely clueless. And yes, it should be a web application with some database
and you should use some framework and templating engine, OMG!

OK, you are not entirely clueless, you probably have seen a lot of web applications already:

- You know that you need the internet to use web application.
- You know that they run in a web browser.
- You even know that there are things called servers (although you might have never seen one) and you guess that they
  are somewhat responsible for running the web application. You know that servers live on the internet (whatever it
  means).
- You know that web applications are used by many other users besides you.
- You have seen a *link* or *URL* and you know that when you type a link into the web browser, it takes you to a
  website.
- You might have noticed that some links are longer and some links are shorter. Those longer ones sometimes contains
  something like parameters (if you are a curious person you already tried to change them a bit).
- You know that there are clickable texts on website that can take you to another website. They are also called links.
- You know some basic user interface elements because you have already seen them on another sites or in standard
  desktop applications (input field, button, drop-down select).
- You also filled many "forms" on the internet. You might not call them "forms" yet, but that login and password fields
  that you use to access your email is a form. And you submit the form with a button usually.
- You might have noticed, that sometimes the web application needs to be reloaded in the browser to update the
  information.
- You even might noticed, that some web applications are somewhat faster and more user-friendly than others, that
  they do not need to reload entirely to display new data and some of them work in real time (e.g. chat applications).
  But you probably do not know why or how to create something like that.
  
Great, you have some preliminary knowledge about web applications, because you live in 21st century and you are reading
an online book.

I expect you to have some small prior programming experience especially with console applications. You should know that
you have to acquire some inputs and process them to make it all work. That database is probably there to store some
data and can be used to retrieve them. I also presume that you know something about object oriented programming.

That is all you know and you have four months to submit the assignment. The equation of your situation can look like
this:

~~~
Some basic knowledge          Basic              A lot of things          Working
   about internet      +   programming     +     you do not know    =       web
  and web browser            skills                   yet...            application
~~~

## Forget the bad stuff! (optional)
You might have encountered PHP at your high school or a friend might have taught you few commands. That is good, you
know what the PHP is good for. But please, try to be open-minded and do not stick to what you know. The quality of your
knowledge might be poor. Many people know, that they can work with PHP like this:

~~~ php
<?php
echo '<html>';
echo '<head>...</head>';
echo '<body><h1>I think that I am a PHP expert!</h1></body>';
echo '</html>';
~~~ 

That is not a way to build more complex application and definitely not a way to build web applications nowadays.

## Start filling the blank spots
You know that you need to study, because you yet do not know the stuff that you need, here are some entry points:

- [Programming](/articles/programming/)
- [Web](/articles/web/)
- [Databases](/articles/database-systems/)

Each entry point is a topic, each topic has related topics and sooner or later, you will find a way which connects
the entry points together via related topics. The important thing is to not lose your way, to keep your direction.
This is why you read this book, it is a guide which helps you to build a web application -- use the [walkthrough](/walkthrough-slim/).

I prepared a small map for you, it might help you to see the main interconnecting topics:

{: .image-popup}
![Knowledge map](/articles/problem-solving/knowledge-map.png)

## Start small, start early, plan ahead
Always start by learning and understanding the technology and by making a prototype or proof of concept. Try to solve
isolated problems and make a "library of examples". You can obviously skip this step once you know your *tools of
trade*. Once you can solve isolated problems, you should be able to decompose the assignment to partial problems
and map it on your library of examples.

{: .note}
That paragraph you just read is **super-important**. Nobody ever wrote a full working application from scratch without
playing with and learning needed technologies. Isolated problem can be e.g. "defining a route in a framework and
responding to it with a simple template", "passing data into templating engine and displaying a static text in
visitor's browser", "storing a record into a database" and "submitting a form and retrieving data using *POST* method".
Those last two examples can be later joined into more complicated example of "storing submitted form data into a
database".

Plan some "custom" deadlines and try to keep them. By gaining experience, you will be more and more accurate in time
estimates. When you miss the deadline, you know, that you have a problem (the best way is to plan work on day-to-day
basis).

Take a look at following image, the bad scenario is a case of many students who do not self-study and do not test and
practice what they are taught during lessons. Once you start programming without any idea of what you are doing and
what tools you are using or how to use them, you will fail to deliver the assignment because you will get stuck many
times and you won't have time to fine-tune the result.

{: .image-popup}
![Good and bad work](/articles/problem-solving/good-bad-work.png)

A more concrete description of how to start working on the project is in [FAQ section](/course/faq/#how-to-start-working-on-the-project).

## Do not reinvent the wheel
Do not write code for everything. There are existing tools and practices that are used in each discipline (you would
not start to build a house by planting a tree). I understand, that it can be overwhelming for beginners to learn about
simple framework and templating engine, but these are tools that are used regularly and you can have them for free.

A lot of people only learn the basics and start programming (including myself). They ignore the ecosystem
(e.g. [Componser](/walkthrough-slim/slim-intro/#composer)) and tools
used in given field. After some time, they spot the patterns and recurring tasks and they start to build "frameworks".
The problem is, that usually others have already made better frameworks and they already have thousands of users.
There are good reasons to use work of others and to learn how to use existing tools:

- Highly productive professionals often benefit from wide variety of tools that they know.
- By using the right tools, you can achieve the result faster, although you will study longer (but you only study
  once, than you can produce many web applications more efficiently).
- You are learning means to work with other programmers -- you will have some common knowledge of tools used in the
  field. 
- You are proving that you can do it -- your future employer might not use Slim framework and Latte templating engine,
  neither PHP, but you proved that you can learn and understand some technology so he can hire you and train you
  in something else. And you also learned a lot about web standards that are universal along the way.

## Development tools
Most people need to use some kind of tools for their work. Better tools means higher productivity. Selecting a
programming language is crucial. I choose PHP for you, but if you are skilled in another modern programming language
suitable for web development, you can use it. Once you start developing in given programming language, you cannot
change it!

It is not difficult to learn a [new programming language](/articles/programming/), more important and difficult is to
learn functions available in the standard library and the [usage context](/walkthrough-slim/backend-intro/) and
[ecosystem](/walkthrough-slim/slim-intro/) of that language.  

The choice of programming language is linked with the choice of editor or [IDE](https://en.wikipedia.org/wiki/Integrated_development_environment).
There are free IDEs like [NetBeans](https://netbeans.org/) or [Eclipse](http://www.eclipse.org/) and there are
paid ones like [PHPStorm](https://www.jetbrains.com/phpstorm/) -- it is free for students. You can use just about
anything from Notepad to PHPStorm, but a good IDE boosts productivity.

Development tools are something, that you directly use almost everyday to produce the result.

## Means to run the application
You will need means to run the application. Each computer has internet browser installed nowadays. But PHP applications
are not executed by "double-clicking the desktop icon". They have to be stored inside configured web server, which uses
PHP interpreter to execute PHP files. It is quite difficult to [install](/course/not-a-student/#installing-your-own-server-on-your-pc)
everything on your own computer. The web server should also be public, so the web application is available for
everybody. Therefore the university provided you with execution environment on university's servers.

Database is a bit special here, it is not needed for every web application and you can definitely store application's
data somewhere else (e.g. filesystem), but it is convenient and safe to use it.

If you continue to study web application development, you will gather knowledge to install your own web-server.
Read more in [technical support section of this book](/course/technical-support/).

## The big picture
See all the tools in their place playing their role. This is difficult and you will have to reshape the model of
things in your head a few times. One example: many students believe, that database is installed *inside* Apache
web server, that is not true. The database is standalone service used by PHP scripts via PHP extension.

You will have to draw a few models and diagrams to understand the whole thing. Go ahead and do it! Each application
has different levels of functionality. There is the high level view and then there are particular use-cases and
processes.

You should train yourself to see the flow of data through variables between modules and levels of your application.
The variables in your source code are like pipes. They are under the ground most of the time, but they surface from
time to time to make their value available or to change it. Variables are the connecting pieces, without them, your
code would not be able to pass information around and it would be impossible to work with user provided data.

You can use UML diagrams described in [FAQ section](/course/faq/#how-to-start-working-on-the-project) to make an
overview of functions needed in your application.

{: .image-popup}
![Data flow](/articles/problem-solving/data-flow.svg)

## Look for help
Read this book, follow the walkthrough but also have always opened the PHP documentation on [php.net site](http://php.net/)
to consult new functions or search for specifications of those you are not so sure about. You should obviously search
for help when you get stuck.

I think that there are two kinds of "getting stuck" that you might encounter during completing this course's assignment:

- Insufficient knowledge -- you absolutely do not know how to do something -- to overcome this, you have to study
  the technology and try to divide the problem into smaller ones and solve them in isolation.
- You are doing it wrong -- this is tricky, you might even come up with working solution of your problem, but
  it does not work every time or does not feel right. As a beginner, you should always look for better solution and
  check how more experienced programmers solved same/similar problem.  

And this is what you should do when you get stuck:

- Search the internet -- try to describe the error or the problem and the search engine will probably find another
  persons request to solve similar problem. You can read the responses and modify them a bit to suit your situation.
  You will find most answers usually on [Stack overflow website](https://stackoverflow.com/).
- Ask real people for help -- your friends, people on internet, me... this step is the last resort, most of the
  beginner's problems have been solved online or in this book. Remember, that your friends are usually similarly
  skilled as you, before you implement some solution, try to ask at least two or three people to confirm the
  solution or start discussion with them to come up with better one.

Take a look in the [FAQ section](/course/faq/) of this book for useful tips.

## Start building (good) habits
Many things can be trained, you will gain experience and you will learn how to use PHP, some IDE, framework, templating
engine etc. The more you use the same tools each day, the better you know them. A good idea is to adopt conventions
for **everything** -- do not invent your own, there are [naming standards recommendations](https://www.php-fig.org/psr/psr-1/),
[coding style standards recommendations](https://www.php-fig.org/psr/psr-2/) and many more.

The goal is to share most common ideas with other developers in your organisation to be able to produce consistent
code (newcomer should not be able to recognize author of the code) and to be replaceable (you will eventually want
to start doing something new and pass your code to somebody else).

## Summary
I tried to describe the process of solving (or starting to solve) the problem of creating web application in this
article. I think that there are two key points that lead to success:

- do not postpone
- study (and practice what you learn)

I know that it is hard to start doing something new and that it is depressing to try again and again until the thing
finally gets working (or fail and start from different end). Everybody who achieved something went through similar
process. This course is about building a working application, it should teach you how to use database and other
application software to deliver usable result. Web technologies are just a tool, but you know that web applications
are popular and it can be useful to know how to create one. If you do not like building any applications, try to use
this assignment as an exercise in problem solving. Because that is what you will do for most of your professional life.

### New Concepts and Terms
- problem solving
