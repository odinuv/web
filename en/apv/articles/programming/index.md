---
title: Programming
permalink: /en/apv/articles/programming/
---

* TOC
{:toc}

## What Is ...
It is important to distinguish between
[**programming**](https://en.wikipedia.org/wiki/Computer_programming),
[**software engineering**](https://en.wikipedia.org/wiki/Software_engineering) (**software development**)
and [**computer science**](https://en.wikipedia.org/wiki/Outline_of_computer_science).
Although it is difficult to agree on brief universal definitions, I would say that the difference
between them is comparable to difference between **masonry**, **architecture** (**house building**) and **physics**.
Although software is very much different from houses.

### Programming
*Programming* involves mainly *writing an actual programming code*, it is more of a craft. Programming is something you can
learn best by exercise and practice and by reading other peoples' code. Programing skills are often tied to
a single programming language -- i.e. an excellent programmer in one language may be really poor in another language.
The asset of a good programmer is speed and code quality -- made possible by deep understanding of the
technology she uses. Anyone (with a little effort) can learn to write
computer programs. The skill is in being able to do it efficiently and with reasonable quality -- the same
way anyone (with a little effort) can build a brick wall.

### Software Engineering
*Software Engineering* (as any other engineering) deals with the question how the **programming code should be organized** and
what development processes should be applied. Software development includes a great deal of
[Project management](https://en.wikipedia.org/wiki/Project_management) and it is something you learn best by studying
rules and standards and by learning from (preferably other peoples') failed projects. Software engineering guides
programmers in writing their code in a similar manner in which architectural plans guide masons. Software
engineering requires a broad understanding of many technologies and approaches so that you can choose
the most suitable ones for the assignment.

### Computer Science
*Computer Science* is the theoretical foundation of it all. It defines how each of the used technologies behaves, and why it behaves that way. Learning
computer science involves the study of various fields of mathematics (set theory, graph theory, etc.) and logic.
Knowing parts of Computer Science is very useful for a Software Engineer as she then knows what are the basic
inherent properties of technologies she is using.

## Programming for Dummies
If you haven't done any programming yet, this part is for you, otherwise skip for
the [next part](/en/apv/articles/web/). This is not an introduction to computer science or
theory of formal languages. It is an introduction for beginner programmers, so that they
know about all the crucial concepts.

Computers are in a way very stupid. The core of a computer is a
[*processor* (CPU)](https://en.wikipedia.org/wiki/Central_processing_unit) and a *memory*. The processor
is capable of carrying out simple instructions (e.g. "add these two numbers together"). The *memory*
can be either *volatile* (typically [RAM](https://en.wikipedia.org/wiki/Random-access_memory)) or
*permanent* (typically hard drive). Then there is a bunch of [Input/Output](https://en.wikipedia.org/wiki/Input/output)
devices such as a graphic card and display, keyboard, mouse, etc.

To make the processor do something, you need to provide it with a (computer) program. The program is executed
on the processor by following the *instructions* written in the program. A program is created by
writing a *source code* in some *programming language*. Since the processor understands only
[low-level instructions](https://en.wikipedia.org/wiki/Low-level_programming_language),
the programming language also has to be low-level (such as the [Assembly language](https://en.wikipedia.org/wiki/Assembly_language)).

Using a low-level programming language is a very tedious task, so the computer is equipped with an
[Operating system](https://en.wikipedia.org/wiki/Operating_system) (OS), which provides much broader functionality
and takes care of a lot of the dirty work for us. The operating system understands higher level commands
such as 'save a file' or 'show this text on the screen', etc. and makes it possible to use a
[high-level programming language](https://en.wikipedia.org/wiki/High-level_programming_language).

### Source Code
Source code is a simple text document, which contains the instruction for the operating system (and
subsequently the processor) to perform.
In a high-level language, the source code must be translated into more low-level instructions the OS and the processor
understands. This is done usually either by *compiling* or *interpreting*. In a *compiled language*
(e.g. [C++](https://en.wikipedia.org/wiki/C%2B%2B)), the
source code is translated to an [*executable file*](https://en.wikipedia.org/wiki/Executable).
An Executable file is simply a file you can execute, e.g. on Windows, everything with `.exe` extension.
In an *interpreted language*, you need to run another program -- the *Interpreter* -- which reads
the your source code from text, *interprets* what it's supposed to do, and instructs the OS or processor to do that.
There are a lot of exceptions to the above, including languages like
[Java](https://en.wikipedia.org/wiki/Java_(programming_language)) or
[C#](https://en.wikipedia.org/wiki/C_Sharp_(programming_language)) which are somewhat partially compiled.
However most of the languages widely used in Web application development are interpreted.

A Source code is a [*plain-text*](https://en.wikipedia.org/wiki/Plain_text) document which is written
using the chosen programming language. A *programming language* is an artificial language
([formal language](https://en.wikipedia.org/wiki/Formal_language). The rules by which the language is
defined are called [*syntax*](https://en.wikipedia.org/wiki/Syntax_(programming_languages)).
In natural languages (such as English), such rules do not have to be followed strictly
(and you can still be understood). However in programming languages, the *syntax* must be followed
strictly and precisely, otherwise the *interpreter* or *compiler* is not able to process
([parse](https://en.wikipedia.org/wiki/Parsing)) the source code. Strictly speaking, the
*interpreter* first *parses* the source code, to try to understand what you have written, and
then *evaluates* that by making the operating system and processor do something.

There are big differences between different programming languages, but there are also some
things which are common for all languages -- *language elements*, *type system* and *standard library*.

### Language Elements
The syntax of each programming language is different. The syntax rules define where
and how various special characters (which denote the language elements) should be written.
I will give the following examples in PHP, because you will use it later anyway.
Most languages have the following language elements:

- comments
- literals
- constants
- variables
- operators
- expressions and statements
- control flow constructs
 - conditions
 - loops
- functions, classes & objects
- keywords

#### Comment
Comments are part a of the programming language, but they are not interpreted in
any way. They serve the purpose of writing your comments to the source code.

{% highlight php %}
// this is a comment, and does nothing
{% endhighlight %}

Comments are either *single-line* or *multi-line*. A single-line comment (the above example) runs until the
end of the line. Multi-line comment must be terminated by a sequence of characters.

{% highlight php %}
/* this is a comment, that
does nothing and spans over more lines.
*/
{% endhighlight %}

#### Literal
These are values written directly in the code. For example, when you write in PHP:

{% highlight php %}
<?php
echo "Hello World!";
{% endhighlight %}

The text `Hello World!` is a text *literal*. The `echo` part is command which makes sure, that the
text is printed.

#### Constant
These are values also written in the code, but they are assigned a name. For example:

{% highlight php %}
<?php
define('MONTHS_IN_YEAR', 12);
echo MONTHS_IN_YEAR;
{% endhighlight %}

The `MONTHS_IN_YEAR` is a constant (value that does not change) and has a name `MONTHS_IN_YEAR`.
In this case, the constant value was defined using a [`define()`](http://php.net/manual/en/function.define.php) function.

#### Variables
Variables are one of the most important parts of a programming language. For example in PHP:

{% highlight php %}
<?php
$name = 'Jane';
echo $name;
$name = 'John';
echo $name;
{% endhighlight %}

The above will first print `Jane` and then `John`. Variables in PHP are marked with `$` sign,
so `$name` is a variable. Technically, a variable is actually a space in computer memory.
The variable can contain different values in time.

#### Operators
Each language has operators for working with values. For example:

{% highlight php %}
<?php
echo 4 + 5;
{% endhighlight %}

The above will print 9. `+` is an arithmetic operator. Each language has standard arithmetic
operators such as `-`, `+`, `*`, `/`. Then there are other operators -- for example boolean operators for
working with [boolean values](/en/apv/articles/programming/#type-system). By the way, 4 and 5 are *literals*.

#### Expressions and Statements
Expressions are language constructs which yield a value (can be **evaluated**). For example, in the above
case `4 + 5` is and expression, which yields a value `9`. Expressions can be
*simple* or *compound*. Compound expressions should use parentheses to determine explicitly
the order of evaluation. E.g.

{% highlight php %}
<?php
echo (4 + 5) * 10;
{% endhighlight %}

The above will print `90`. The order of expression evaluation is particularly
important for [boolean expressions](todo). Also note that `echo` is not part of the expression,
it is a command which prints a value to the screen. The value is obtained by evaluating the expression.

#### Control Flow
**Control flow** structures are language constructs which **control** the
**flow** of the program -- i.e. they control, what lines of source
code get executed:

{% highlight php %}
<?php
$what = 5
if ($what > 0) {
    echo "5 is bigger than 0";
}
{% endhighlight %}

An `if` condition can have multiple **branches**:

{% highlight php %}
<?php
$what = 5
if ($what > 0) {
    echo "5 is bigger than 0";
} else {
    echo "5 is smaller than 0";
}
{% endhighlight %}


#### Functions, classes and objects
Functions and Classes are language tools which help you organize the source
code more efficiently, reduce repetition and generally make things
less tangled and confusing. Each language has many built in functions.

#### Keywords
Keywords are *reserved words* of the language. They have some special meaning in the
language itself and do something special. E.g. in the above examples, the keyword
`if` marks the beginning of a conditional statement. The keyword `echo` prints
a text on the screen.

### Type System
The source code must strictly conform to the defined syntax of the chosen language.
Apart from the syntax, there are other rules, very important one is *Type System*.
The values used in a programming language can have different **data types**. Types are specific
to each language, but there are some commonly used:

- **boolean** -- A value which is either [*true* or *false*](#boolean-type).
- **integer** -- Whole number.
- **string** -- String of characters -- i.e. a text.
- **float**, **real** -- Decimal number
- **array** -- list of values (each value can be of the above type)

Depending on how the language handles types, there are [**strongly typed languages**](https://en.wikipedia.org/wiki/Strong_and_weak_typing)
and **weakly (loosely) typed languages**. Because this is quite a complicated area, I will simplify it
to just that in a weakly typed language, the values of different types are converted automatically.
In a strongly typed language, the values must be explicitly converted. Most languages used in
web application development are weakly typed which means that you can write e.g.:

{% highlight php %}
<?php
echo 5 + '4';
{% endhighlight %}

In the above example, the `'4'` gets automatically converted to integer, so that
it can be added to integer `5`. Then the output `9` is converted to string `'9'` which
is printed to the screen. The following code will fail:

{% highlight php %}
<?php
echo 5 + 'four';
{% endhighlight %}

The above would yield an error, because the language interpreter is stupid and does not know that
string `four` can be converted to number 4.

#### Boolean Type
[Boolean data type](https://en.wikipedia.org/wiki/Boolean_data_type) has only two values: **true** and **false**.
Boolean type has a great significance in programming. Boolean values (true, false) are also called **logical values**.
They can be manipulated using [**logical operators**](https://en.wikipedia.org/wiki/Boolean_algebra#Basic_operations)
(part of *boolean logic* or *boolean algebra*). The most important logical operators are:

- logical **and** (conjunction) -- the result value is true if both operands are true, otherwise it is false.
- logical **or** (disjunction) -- the result value is true if either operand is true, otherwise it is false
(i.e. if both operands are false)
- logical **not** (negation) -- the result is negation of the value (if operand is true, result is false and vice versa).

The **and** and **or** operators are **binary** which means that they have two **operands**. While it may sound alien,
you are already familiar with binary operators. E.g. if you write `4 + 3`. The plus `+` is a binary
operator (arithmetic, not boolean though), `4` and `3` are its *operands*. The result is `7`.
Similarly you can write `true and false`. The `and` is a binary boolean operator, `true` and `false` are
its operands. The result is `false`. The `not` operator is **unary** which means that it has only one operand.
For example the expression `not true`, negates the value `true` and results `false`. This is sort of logical, isn't it?
That's why it's called boolean logic :). In PHP, the not operator is written using exclamation mark `!`:

Some examples:
{% highlight php %}
<?php
!true; // -> yields false
(true and true) or false; // -> yields true
((true or false) and true) and (!true); // -> yields false
(!((!true) or false)) or false; // -> yields true
{% endhighlight %}

Knowing how boolean operators work is essential for writing [conditional statements](/en/apv/articles/programming/#control-flow).

### Standard Library
Part of each high-level language is a *function library* (*library* or *standard library*).
Library is a collection of generally
usable functions and blocks which you can use in the source code of that language. The
library provides even higher level functions than what the language itself has. E.g. it could be
functions for ciphering, sending data over network,
[user interface](https://en.wikipedia.org/wiki/User_interface) controls, etc.
The problem is that each programming language has its own library, and each library
contains thousands of functions. Therefore it is very time consuming to get yourself
acquainted with the language library. Contrary to popular belief, a programmer spends
most of his time reading manuals for the libraries.

Apart from standard library which comes bundled with every language interpreter (or compiler), there
are also many 3rd party libraries. In general, the term **library** represents an external set of functions
which we (as a programmers) include in our application without modification. There are also other terms describing
a set of functions like *packages*, *modules*, *extensions*, *plugins*. In principle, all these represent the same
thing.

## Summary
In this article, you learned the basic programming jargon. If you do not feel confident
having intuitive understanding of the below terms, try to take a
course at [Codecademy](https://www.codecademy.com/) which should help you digest them better.

It is very important to understand that the source code is executed so that each
statement is executed sequentially -- usually only one statement is written per line (for readability),
therefore, the source code is executed line-by-line (unless control-flow structures change the
program flow). This in essence describes how computer programs are made to run.
Perhaps you wonder what is the difference between a *program* and an *application*. Well the
best I'm aware of is that an application is a program, which has a
[*user interface*](https://en.wikipedia.org/wiki/User_interface). So unless you are working
on some low level programs (e.g. [device drivers](https://en.wikipedia.org/wiki/Device_driver)), you're
making an application.

### New Concepts and Terms
- programming
- software development, software engineering
- computer science
- developer
- source code
- volatile/permanent memory
- programming language / formal language
- compiler
- interpreter
- parser
- execution
- expression
- statement
- code evaluation
- type system
- standard library
- strong type system
- weak type system
- comments
- literals
- constants
- variables
- operators
- operand
- binary operator
- unary operator
- control flow constructs - conditions, loops
- integer
- string
- float / real
- arrays
