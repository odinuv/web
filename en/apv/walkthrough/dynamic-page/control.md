---
title: Control Flow
permalink: /en/apv/walkthrough/dynamic-page/control/
---

* TOC
{:toc}

**Control flow** structures are language constructs which **control** the
**flow** of the program -- i.e. they control, what lines of source source
code get executed. Important control flow constructs:

- conditions -- **if**, **switch** (and **case**)
- loops -- **for**, **foreach**, **while** (and **do-while**)

## Conditions
In PHP conditional statements are written using **if** -- **else** [reserved words](todo).

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/ifelse-1.php %}
{% endhighlight %}

The condition itself must always be in parentheses. Multiple conditions
can be joined using [boolean operators](todo) `&&` and `||` (there are
[other confusing boolean operators](todo) in PHP), negation is
written using `!`.

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/ifelse-2.php %}
{% endhighlight %}

{: .note}
You can write either `elseif` or `else if`, there is no difference.

### Switch - case
The above example can be rewritten using `switch` -- `case` statements:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/ifelse-3.php %}
{% endhighlight %}

Note that it is important to put `break` in each branch, which terminates the
`switch` execution (otherwise all consecutive branches will get executed too).
The `break` at the end of `case 4` is especially tricky.

### Comparison vs. Assignment
When comparing two values, you must use the [comparison operator](todo) `==`.
If you use the assignment operator, you might run into an unexpected behavior.
If you would write:

{% highlight php %}
if ($numberOfWheels = 4) {
    echo "It's a car.";
}
{% endhighlight %}

The condition will **always be true** (regardless of the actual value of $numberOfWheels).
This is because the value of assignment is the assigned value, so the condition
(after evaluating the part in parentheses) will be `if (4) {`. Now the [boolean type conversion](todo)
kicks in and converts `4` to boolean, and according to the [rules](todo) `4` is not false, so it is true.
That's unexpected and somewhat dangerous, good [development tools](todo) will warn you about this.

Sometimes this is prevented by writing conditions in reverse order `if (4 == $numberOfWheels)`. Because in
this case, using a single `=` -- `if (4 = $numberOfWheels)` will cause compilation error (you cannot assign
anything to constant number 4). Personally I find this way of writing weird.

## Loops
A loop executes a piece of code multiple times in so called **iterations**. An iteration
is one single execution of the loop body. There are three basic loops in PHP as in C:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/loop-1.php %}
{% endhighlight %}

All three loops are equivalent, so the above will output '012345678901234567890123456789'.
`for` is used when the number of iterations is know beforehand (like in the above example),
as it is the simplest of the three. `while` is used when the terminating condition must be
evaluated before the iteration is executed. `do-while` is used when the termination condition
can be evaluated only after the loop has executed. PHP also has a special `foreach` loop
which we'll [attend to later](todo).

## Task
Take the [contact form from the previous chapter](todo) and:

- Assume that you have variable `$currentUser` with name of the currently logged user or empty string in case no one is logged.
- If the user is logged in, display a greeting for him and hide the email input.
- If the user is not logged in, show the email input and year of birth select box.
- Fill year of birth select box with year from 1916 up to current year (use [`date('Y')`](todo) to obtain current year)

You will need to define the variable `$currentUser` and test it with different values. So with `$currentUser = 'John Doe';`
the form should look like this:

![Screenshot -- Introduction page](/en/apv/walkthrough/dynamic-page/form-4a.png)

And with `$currentUser = '';` the form should look like this:

![Screenshot -- Introduction page](/en/apv/walkthrough/dynamic-page/form-4b.png)

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/form-4.php %}
{% endhighlight %}

As you can see, the script is getting rather complicated -- especially the concatenation of
strings. From now on, we will be working on simplifying the code. Again, there are
many different solutions.

## Summary
You should now be able to control the flow of your application. This means using conditional
branching and loops.

### New Concepts and Terms
- Conditionals -- if, else, ifelse, switch, case
- Loops -- for, while, do-while
- Comparison vs. Assignment
