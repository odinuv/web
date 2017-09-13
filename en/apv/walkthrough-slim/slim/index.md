---
title: Slim Backend
permalink: /en/apv/walkthrough-slim/slim/
---

* TOC
{:toc}

In the previous parts, you have learned how to work with [HTML forms](../html-forms/) and the [basics of PHP language](../dynamic-page/).
Using plain to create an entire application is somewhat tedious and requires that you take care in organizing your source code.
Otherwise it can easily become an unmaintainable mess which no one can understand.

A common solution to this is to use a framework. A framework serves two purposes, first it takes care of some common (and repetitive) tasks
and second it guides the organization of the application code. This has both advantages and disadvantages. The main disadvantage is that you
have to learn yet another thing to work with (because you need to know both plain PHP and also some PHP framework). A minor disadvantage is that
every framework is somehow limiting the possibilities of plain PHP, so when you try to do something very special it might prove difficult to do.
The main advantage of framework is that they lead you in doing things *The Correct Way (TM)*. There is usually a much smaller margin for
errors and once you get used to the framework, the development of the application is much faster. That means that you can create the
final application in shorter time and in better quality (but if you still want to do it the hard way, that is a
[walkthrough for that too](/en/apv/walkthrough/).

For this book I choose the [Slim framework](https://www.slimframework.com/). That choice is rather arbitrary, because there are plenty of
other good frameworks ([Laravel](https://laravel.com/), [Symfony](https://symfony.com/), [Nette](https://nette.org/en/), [Yii](http://www.yiiframework.com/), ...).
The main reason is that it is very small and therefore it is easy to learn and start with. Although it does not offer as many features as
other frameworks. The framework can easily be extended and even though it is small, you can do great stuff with it.


