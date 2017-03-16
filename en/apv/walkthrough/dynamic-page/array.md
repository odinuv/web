---
title: Array
permalink: /en/apv/walkthrough/dynamic-page/array/
---

* TOC
{:toc}

In many languages, there are different structures for containing collections
of values -- [arrays](http://php.net/manual/en/book.array.php),
[lists](https://en.wikipedia.org/wiki/List_comprehension),
[collections](https://en.wikipedia.org/wiki/Java_collections_framework),
[hashsets](https://en.wikipedia.org/wiki/Set_(abstract_data_type)), etc.
In PHP, this is simplified as there are only [arrays](http://php.net/manual/en/book.array.php).

An array is a collection of elements, each element has a value and an **index** (or **key**) through which it
is accessed in the array. This means that **keys must by unique**. Because PHP is a dynamically
typed language, each value and each key can
be of a different type. There are two types of arrays in PHP:

- **ordinal** (indexes are e.g. integers)
- non-ordinal -- **associative** (indexes are e.g. strings)

An ordinal array has *only* indexes of an [ordinal type](https://en.wikipedia.org/wiki/Ordinal_data_type) --
a type which has a clear sequence of values (e.g integer). `for` loop can be used only with ordinal
arrays. Other types of loops (`foreach`, `while`, `do-while`) can be used with both types of arrays.
`foreach` loop is especially useful for non-ordinal arrays. There is no other difference in
working with ordinal and associative arrays.

## Creating an Array
There are multiple options how to create an array, the following example shows them along with
the `print_r` function which prints out contents of an array (you cannot use normal `echo` with arrays).

### Create an Array With Implicit Indexes
In this case, the indexes are generated automatically starting with zero.

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-1.php %}
{% endhighlight %}

Sometimes you may encounter an older PHP syntax not using the square brackets ``$flinstones = array("Fred", "...");``.

An alternative definition -- item by item:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-1a.php %}
{% endhighlight %}

Empty square brackets mean that the value will be assigned as the last element of that array.
You can combine both approaches freely. Both of them will print:

    Array ( [0] => Fred [1] => Wilma [2] => Pebbles )

### Create an Array With Explicit Indexes
In this case, the element indexes are explicitly stated when the array is created.

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-2.php %}
{% endhighlight %}

An alternative definition -- item by item:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-2a.php %}
{% endhighlight %}

An alternative longer syntax:

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
Nothing prevents you from assigning a whole array as a value of an array. This way you can create
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

Notice that there is nothing special in accessing elements of a multidimensional array. You
simply use the first index `flintstones` to access the value in the array `$allOfThem` and
then use the second index `child` to access the value in the `flintstones` array.

{: .note}
When defining an array, you may use implicit array keys and write `$array[] = 'value'`, but when
reading a value from the array, the keys must **always** be used. Writing `echo $array[]` is not allowed.

### Removing elements from array
Sometimes you may wish to remove an element. This can be done using the `unset()` function:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-8.php %}
{% endhighlight %}

The above example will print:

    Array ( [father] => Fred [mother] => Wilma )

Removing elements from an array is not very common because PHP scripts are executed for a very short time (just to
produce a HTML page for the browser) and then the memory used by the script is cleared automatically.
Use the `unset` operation only when you truly want to remove something from an array.

### Traversing Arrays
When you need to traverse the entire array, you need a loop. As mentioned above the `for` loop can be
used only with ordinal arrays, the `foreach` loop can be used with any type of an array.

When using a `for` loop, you often use the `count` function to return a number of elements of the
array, the below array has implicit indexes which start from 0:

{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-6.php %}
{% endhighlight %}

The above will print:

    FredWilmaPebbles

When using a `foreach` you are required to use two variables. In this case I named them
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

    The father in the Flintstones family is Fred The mother in the Flintstones family is Wilma The child in the Flintstones family is Pebbles The father in the Rubbles family is Barney The mother in the Rubbles family is Betty The child in the Rubbles family is Bamm-Bamm

## Task -- Add HTML
Take the above example and change the output to a valid HTML page so that it looks like this:

![Screenshot -- Array of Flintstones](/en/apv/walkthrough/dynamic-page/array-sol-1.png)

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/dynamic-page/array-sol-1.php %}
{% endhighlight %}

## Task -- Improve contact form
Take the [contact form](/en/apv/walkthrough/dynamic-page/control/#task) from the previous chapter and:

- define the `$currentUser` variable as an associative array with the keys `firstName`, `lastName`, `email`, `yearOfBirth`
- if the user is not logged in, the array will have all the elements empty
- modify the form so that it always contains the elements `email`, `firstName`, `lastName`, `yearOfBirth`
- if the user is logged in, fill in all the form controls with her values
- define an array of birth years as a variable and use it when generating the `yearOfBirth` select field
- don't forget to [preselect](/en/apv/walkthrough/html-forms/#select) the `yearOfBirth` of the logged user (if any)

This is how the form should look like as viewed by the user John Doe:

![Screenshot -- Form for logged user](/en/apv/walkthrough/dynamic-page/form-5a.png)

This is how the form should look like for an unknown user:

![Screenshot -- Form for logged user](/en/apv/walkthrough/dynamic-page/form-5b.png)

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
You should now be able to work with arrays. This means you should be able to define
an array, add elements to it and print an array. Arrays are very important -- for example the results
of database queries are stored in them. This means that we will work with them a lot.

### New Concepts and Terms
- Conditionals -- if, else, ifelse, switch, case
- Loops -- for, while, do-while
- Comparison vs. Assignment

