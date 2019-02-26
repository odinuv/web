
**Control flow** structures are language constructs which **control** the
**flow** of the program -- i.e. they control what lines of the source
code get executed. Important control flow constructs:

- conditions -- **if**, **switch** (and **case**)
- loops -- **for**, **foreach**, **while** (and **do-while**)

## Conditions
In PHP conditional statements are written using **if** -- **else**
[reserved words](/articles/programming/#keywords).

~~~ php
{% include /common/backend-intro/ifelse-1.php %}
~~~

The condition itself must be always in parentheses. Multiple conditions
can be joined using [boolean](/articles/programming/#type-system) operators `&&` (and)
and `||` (or) (there are [other confusing boolean operators](http://php.net/manual/en/language.operators.logical.php) in PHP), negation is
written using `!`. Do not confuse boolean logical operators with [bitwise operators](http://php.net/manual/en/language.operators.bitwise.php).

~~~ php
{% include /common/backend-intro/ifelse-2.php %}
~~~

{: .note}
You can write either `elseif` or `else if`, there is no difference.

### Switch -- Case
The above example can be rewritten using `switch` -- `case` statements:

~~~ php
{% include /common/backend-intro/ifelse-3.php %}
~~~

Note that it is important to put `break` in each branch, which terminates the
`switch` execution (otherwise all consecutive branches will get executed too).
The `break` at the end of the `case 4` statement is especially tricky.

### Comparison vs. Assignment
When comparing two values, you must use the comparison operator `==`.
If you use the assignment operator, you might run into an unexpected behavior.
If you write:

~~~ php?start_inline=1
if ($numberOfWheels = 4) {  //assigns 4 into variable and evaluates the variable as truthy
    echo "It's a car.";
}
~~~

The above condition is **always true** (regardless of the actual value of $numberOfWheels).
This is because the value of assignment is the assigned value, so the condition
(after evaluating the part in parentheses) will be `if (4) {`. Now
the [boolean type conversion](../#boolean-conversions)
kicks in and converts `4` to boolean, and according to
the [rules](../#boolean-conversions) `4` is not false, so it is true.
That's unexpected and somewhat dangerous, good [development tools](/course/not-a-student/#text-editor-or-ide) will warn you about this.

Sometimes this is prevented by writing conditions in reverse order `if (4 == $numberOfWheels)`. Because in
this case, using a single `=` -- i.e. `if (4 = $numberOfWheels)` will cause a compilation error (you cannot assign
anything to the constant number 4). Personally I find this way of writing weird.

## Loops
A loop executes a piece of a code multiple times in so called **iterations**. An iteration
is one single execution of the loop body. There are three basic loops in PHP as in C:

~~~ php
{% include /common/backend-intro/loop-1.php %}
~~~

All three loops are equivalent, so the above will output '012345678901234567890123456789'.
`for` is used when the number of iterations is known beforehand (like in the above example),
as it is the simplest of the three. `while` is used when the terminating condition must be
evaluated before the iteration is executed. `do-while` is used when the termination condition
can be evaluated only after the iteration is executed. PHP also has a special `foreach` loop
which we'll [attend to later](../array/#traversing-arrays).

### Using `break` and `continue`
You can *break* the loop using `break` keyword. Once used, the iteration is stopped and code execution skips
to the next line after the loop:

~~~ php?start_inline=1
//this code will print 012345end of script
for($i = 0; $i < 10; $i++) {
    if($i == 6) {
        break;
    }
    echo $i;
}
echo 'end of script';
~~~

There is also `continue` keyword which skips just one iteration of the loop:

~~~ php?start_inline=1
//this code will print 012345789end of script
for($i = 0; $i < 10; $i++) {
    if($i == 6) {
        continue;
    }
    echo $i;
}
echo 'end of script';
~~~

## Task
Take the [contact form from the previous chapter](../#task-1----contact-form) and:

- Assume that you have the variable `$currentUser` with the name of the currently logged user or an empty string in case no one is logged.
- If the user is logged in, display a greeting for him and hide the email input.
- If the user is not logged in, show the email input and year of birth select box.
- Fill the year of birth select box with the year from 1916 up to the current year
(use [`date('Y')`](http://php.net/manual/en/function.date.php) to obtain the current year)

You will need to define the variable `$currentUser` and test it with different values. So with `$currentUser = 'John Doe';`
the form should look like this:

![Screenshot -- Introduction page](/common/backend-intro/form-4a.png)

And with `$currentUser = '';` the form should look like this:

![Screenshot -- Introduction page](/common/backend-intro/form-4b.png)

{: .solution}
~~~ php
{% include /common/backend-intro/form-4.php %}
~~~

As you can see, the script is getting rather complicated -- especially the concatenation of
the strings. From now on, we will be working on simplifying the code. Again, there are
many different solutions.

## Summary
Now you should be able to control the flow of your application. This means using conditional
branching and loops.

### New Concepts and Terms
- Conditionals -- if, else, ifelse, switch, case
- Loops -- for, while, do-while
- Comparison vs. Assignment

### Control question
- Is it possible to use assignment operator inside control structure (e.g. `if($a = 5) {}`)?
- Does every `if` has to have `else`?
- What is considered to be non-true value?