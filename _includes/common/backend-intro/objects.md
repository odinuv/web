
Functions and Classes are language tools which help you organize the
source code more efficiently, reduce repetition and generally make things
less tangled and confusing.

These are language tools which are not necessary to complete your application,
but you should really know that they exist and how to use them.

## Functions
You have already met some functions in the previous examples -- e.g.:

- `print_r` -- function to print an array
- `count` -- function to return the number of elements in an array

These are built-in [PHP functions](http://php.net/manual/en/funcref.php). PHP has many built-in functions, I will
show some of the very useful ones along the way. Apart from those
you can define your own functions. Here I define a function `makeMoo`,
which -- well -- makes Moo!:

{% highlight php %}
{% include /common/backend-intro/functions-1.php %}
{% endhighlight %}

Once the function is **defined** in the script, you can **call** it anywhere by writing:

{% highlight php %}
makeMoo();
{% endhighlight %}

We can define (and immediately call) a more complicated function
with the **parameter** `$count`:

{% highlight php %}
{% include /common/backend-intro/functions-2.php %}
{% endhighlight %}

The above script will print:

    Moo! Moo! Moo! Moo! Moo! Moo! Moo! Moo! Moo! Moo!

Functions can `return` values:

{% highlight php %}
{% include /common/backend-intro/functions-3.php %}
{% endhighlight %}

In the above example, the function `makeMoo` now creates a string by
concatenating (with the `.` operator) the individual *Moo*s and returns
that string. The result string is printed when the function is called `echo makeMoo(10);`

### Function parameters
There is a bit more you can do with function's parameters. For example you can have a default
values for them when you know that some function will be frequently called with particular values:

{% highlight php %}
{% include /common/backend-intro/functions-4.php %}
{% endhighlight %}

Or you can set a mandatory data-type for a function parameter -- this functionality was extended in PHP7
to support scalar data-types too. Previous PHP versions could watch for classes and arrays only.
This is useful when you write some code which is used by other programmers -- you do not have to write that many lines of
code to check what your function got from the outside world. A good [IDE](/course/not-a-student/#text-editor-or-ide) can also take advantage of the
supplied information.

{% highlight php %}
{% include /common/backend-intro/functions-5.php %}
{% endhighlight %}

## Classes
**Classes** are templates for **Objects**. Objects are structures which can contain
**fields** (also called properties or attributes) with values (similar to associative
[arrays](../array/)) and functions. In other words we
say that Objects are **instances** of
classes. Functions in classes and objects are called **methods**.
*Fields* and *methods* are Class and Object **members**. Let's see an example:

{% highlight php %}
{% include /common/backend-intro/classes-1.php %}
{% endhighlight %}

I defined a class named `Cow` (it's a nice convention to capitalize class names). The
class has one class member -- the method **makeMoo**. Then I created an instance of
the Cow class -- a cow `$betty`. Once I have the cow object, I can call the `makeMoo`
method to make Betty do *Moo*.

Notice, that you need to use the `->` operator to access object members. Each class member
has **visibility** -- which can be either: *public*, *protected*, *private*:

- *Private* members are accessible only from within the object itself.
- *Protected* members are also accessible from
[*derived classes*](https://en.wikipedia.org/wiki/Inheritance_(object-oriented_programming)).
- *Public* members are also accessible from outside of the object.

Let's make a more complicated class:

{% highlight php %}
{% include /common/backend-intro/classes-2.php %}
{% endhighlight %}

The above class, has three members -- field `$name` and methods
`__construct` and `makeMoo`. The method `__construct` is a special method --
**constructor** and is called automatically when you create an instance of the
class. I've added a parameter `$name` to the constructor so when I create an
instance of the class, I must pass a name of the cow `new Cow('Betty')`.

The field `$name` is marked as private, which means that it can be accessed only from
within the class itself. This is done using the statement `$this->name`.
The special variable `$this` refers to the current object and can be used only
inside object methods. The point of using private members is that their values
cannot be changed inadvertently.

## Namespaces
If you have looked at the list of built-in [PHP functions and classes](http://php.net/manual/en/funcref.php)
you may have wondered
what happens when you define a function or class which already exists. Well, a
conflict happens and it becomes unclear what function you're calling. To solve this problem, PHP has
**namespaces**. Referring to classes in namespaces is done using the backslash `\` character, e.g:

{% highlight php %}
$object = new \MyNameSpace\MyClass();
{% endhighlight %}

Built-in classes are in the root namespace:

~~~ php?start_inline=1
$object = new \PDO();
~~~

Working with namespaces is a bit tricky, because it depends on whether and how your script
uses them. At least you should be aware that namespaces exist and recognize namespaced classes.

## Task -- User class
Create the class `User`, with the private fields `$email`, `$firstName`, and `$lastName`. The
fields should be set through the constructor. The class should have the method `printName()` to
print the full user name. Create two users: `John Doe` with email `john.doe@example.com` and
`Jane Dona` with email `jane.dona@example.com`. Print names of both users.

{% highlight php %}
{% include /common/backend-intro/classes-3.php %}
{% endhighlight %}

## Summary
Now you should have basic understanding of what functions, classes and objects are.
You should be able to call your own functions and built-in PHP functions. You should be able
to define simple functions with parameters and return values. You should be able
to create instances of classes and call methods.

### New Concepts and Terms
- Functions
- Classes
- Objects
- Methods
- Fields
- Constructor
- Visibility
- Namespaces
