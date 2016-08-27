---
title: Array
permalink: /en/apv/walkthrough/dynamic-page/array/
---

* TOC
{:toc}

In many languages, there are different structures for containing collections
of values -- [arrays](todo), [lists](todo), [collections](todo), [hashsets](todo), etc.
In PHP, this is simplified as there are only arrays.

An array is a collection of elements, each element has a value and an **index** (or **key**) through which it
is accessed in the array. This means that **keys must by unique**. Because PHP is dynamically
typed language, each value and key can
be of different type. There are two types of arrays:

- **ordinal** (indexes are e.g. integers)
- non-ordinal -- **associative** (indexes are e.g. strings)

Ordinal array has *only* indexes of [ordinal type](https://en.wikipedia.org/wiki/Ordinal_data_type) --
a type which has a clear sequence of values (e.g integer). `for` loop can be used only with ordinal
arrays. Other types of loops (`foreach`, `while`, `do-while`) can be used with both types of array.
`foreach` loops is especially useful for non-ordinal arrays. There is no other difference in
working with ordinal and associative arrays.

## Creating an Array
There are multiple options how to create an array, the following example show them along with
the `print_r` function which prints out contents of an array (you cannot use normal `echo` with arrays).

### Create an Array With Implicit Indexes
In this case, the indexes are generated automatically starting with zero.

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-1.php %}
{% endhighlight %}

Alternative definition -- item by item:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-1a.php %}
{% endhighlight %}

You can combine both ap[roaches freely. Both of them will print:

    Array ( [0] => Fred [1] => Wilma [2] => Pebbles )

### Create an Array With Explicit Indexes
In this case, element indexes are explicitly stated when the array is created.

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-2.php %}
{% endhighlight %}

Alternative definition -- item by item:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-2a.php %}
{% endhighlight %}

Alternative longer syntax:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-2b.php %}
{% endhighlight %}

All of them will print:

    Array ( [2] => Fred [1] => Wilma [3] => Pebbles )

Example of an associative array:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-2c.php %}
{% endhighlight %}

The above will print:

    Array ( [father] => Fred [mother] => Wilma [child] => Pebbles )

### Multidimensional arrays
Nothing prevents you assigning a whole other array as a value of an array. This way you can create
so called *multidimensional array*s.

Defined by individual values:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-3.php %}
{% endhighlight %}

Defined all in one go:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-3a.php %}
{% endhighlight %}

Both will print:

    Array ( [flintstones] => Array ( [father] => Fred [mother] => Wilma [child] => Pebbles ) [rubbles] => Array ( [father] => Barney [mother] => Betty [child] => Bamm-Bamm ) )

{: .note}
In the above example, I wrote a colon `,` even after the list item of the array, this is
allowed in PHP (as it simplifies adding more items), but not required.

### Accessing elements
Accessing individual elements for reading is done the same way as for writing. E.g.

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-4.php %}
{% endhighlight %}

The above will print:

    FredBettyPebbles

Notice that there is nothing special in accessing elements of multidimensional array. You
simply use the first index `flintstones` to access the value in the array `$allOfThem` and
then use the second index `child` to access the value in the `flintstones` array.

{: .note}
When defining an array, you may use implicit array keys and write `$array[] = 'value'`, but when
reading a value from array, the must **always** be used. Writing `echo $array[]` is not allowed.

### Traversing Arrays
When you need to traverse the entire array, you need a loop. As mentioned above `for` loop can be
used only with ordinal arrays, `foreach` loop can be used with any type of array.

When using a `for` loop, you often use the `count` function to return number of elements of the
array, the below array has implicit indexes which start from 0:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-6.php %}
{% endhighlight %}

The above will print:

    FredWilmaPebbles

When using a `foreach` loop requires you to use two variables. In this case I named them
`$role` and `$name`. In each iteration of the `foreach` loop the element key will be
assigned to the first variable (`$role`) and the value of the element will be assigned
to the second variable `$name`.

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-7.php %}
{% endhighlight %}

The above will print:

    father is Fred mother is Wilma child is Pebbles

Notice that the variables `$name` and `$role` are usable only inside the loop. They do
not need to be defined before, and they should not be used after the loop.
A shorthand form is also available in case you are not interested in the array keys:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-7a.php %}
{% endhighlight %}

The above will print:

    FredWilmaPebbles

You can also traverse multidimensional arrays:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-7b.php %}
{% endhighlight %}

The above will print:

    The father in Flintstones family is Fred The mother in Flintstones family is Wilma The child in Flintstones family is Pebbles The father in rubbles family is Barney The mother in rubbles family is Betty The child in rubbles family is Bamm-Bamm

## Task -- Add HTML
Take the above example and change the output to a valid HTML page so that it looks like this:

![Screenshot -- Array of Flintstones](/en/apv/walkthrough/dynamic-page/array-sol-1.png)

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-sol-1.php %}
{% endhighlight %}

## Task -- Improve contact form
Take the [contact form](todo) from previous chapter and:

- define the `$currentUser` variable as an associative array with keys `firstName`, `lastName`, `email`, `yearOfBirth`
- if the user is not logged in, the array will have all the elements empty
- modify the form to always include the elements `email`, `firstName`, `lastName`, `yearOfBirth`
- if the user is logged in, fill all the form controls his values
- define an array of birth years as a variable and us it when generating the `yearOfBirth` select field
- don't forget to [preselect](todo) the `yearOfBirth` of the logged user (if any)

This is how the form should look like for user John Doe:

![Screenshot -- Form for logged user](/en/apv/walkthrough/dynamic-page/form-5a.png)

This is how the form should look like for unknown user:

![Screenshot -- Form for logged user](/en/apv/walkthrough/dynamic-page/form-5a.png)

{: .solution}
{% highlight php %}
// This is not actually a solution, it's only a hint how the beginning of the script should look like.

// Logged User
$currentUser = [
    'firstName' => 'John',
    'lastName' => 'Doe',
    'email' => 'john.doe@example.com',
    'yearOfBirth' => 1996,
];
/*
// Not Logged User
$currentUser = [
    'firstName' => '',
    'lastName' => '',
    'email' => '',
    'yearOfBirth' => '',
];
*/
{% endhighlight %}

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/form-5.php %}
{% endhighlight %}


## Summary
You should now be able to work with arrays. This means you should be able to define an array ()

### New Concepts and Terms
- Conditionals -- if, else, ifelse, switch, case
- Loops -- for, while, do-while
- Comparison vs. Assignment

