---
title: Working with Database and HTML
permalink: /walkthrough/database-using/html/
---

* TOC
{:toc}

In the [previous part](/walkthrough/database-using/) you have learned how to send 
commands (SQL queries) to a database from within a PHP script. This is a very important
step because now you know all the core pieces needed to build a web application.

In the previous exercises, you have made a script which prints various lists of 
persons using the `print_r` function. Although functional, this is plain ugly. 
To create a reasonably formtted list, you need to modify your script to output 
a HTML page. Although you should already know everything necessary, I feel that
you might appreciate a little guidance.

## Task -- Print Data in HTML
A big task lies ahead of you. Print `first_name`, `last_name`, `nickname` and
`age` rounded to years of all persons ordered by `last_name` and `first_name` (ascending).
Print the persons in a HTML table, one row each. Use a
[layout template](/walkthrough/templates-layout/) for the HTML page.
Again, approach the task in steps, e.g.:

1. Make a static HTML page with some sample data (skip this if you are confident with templates).
2. Make a PHP script to print the page using templates.
3. Make the data in the script dynamic -- load it from a variable, make sure the variable has the same
format as obtained from the database.
4. Write the SQL query to obtain the data you want.
5. Hook the SQL query into the PHP script.

### Step 1
Consult the [HTML guide](/walkthrough/html/) if you are not sure.

{: .solution}
{% highlight html %}
{% include /walkthrough/database-using/persons-static.html %}
{% endhighlight %}

### Step 2
Create a PHP script, a template and a layout template.

{: .solution}
{% highlight php %}
{% include /walkthrough/database-using/persons-dynamic-1.php %}
{% endhighlight %}

{: .solution}
{% highlight html %}
{% include /walkthrough/database-using/persons-dynamic-1.latte %}
{% endhighlight %}

{: .solution}
{% highlight html %}
{% include /walkthrough/database-using/layout.latte %}
{% endhighlight %}

### Step 3
Define the persons to be displayed as an array in the PHP script, make
sure the array has the same form as the one
[returned from the database functions](#selecting-data).

{: .solution}
{% highlight php %}
{% include /walkthrough/database-using/persons-dynamic-2.php %}
{% endhighlight %}

{: .solution}
{% highlight html %}
{% include /walkthrough/database-using/persons-dynamic-2.latte %}
{% endhighlight %}

### Step 4
Write the SQL query and test that it works.

{: .solution}
{% highlight sql %}
SELECT first_name, last_name, nickname, date_part('years', AGE(birth_day)) AS age
FROM person
ORDER BY last_name ASC, first_name ASC
{% endhighlight %}

### Step 5
Modify the PHP script to load the variable from the database.

{: .solution}
{% highlight php %}
{% include /walkthrough/database-using/persons-list.php %}
{% endhighlight %}

No one is forcing you to take all the above steps separately or in the shown order.
But **you must always be able to divide a complex task into simpler steps**. This
is really important -- the scripts will become only more and more complicated and there is really
only one way to be oriented in all the code and debug it. You have to split it into smaller pieces,
write and test the pieces individually. Notice how -- in the above steps -- I have changed only one thing
at a time. Some parts (like the template layout) don't need to be changed at all. However splitting
the code requires you to understand the connections between all the code parts:

{: .image-popup}
![Schema of variables](code-schematic.png)

## Summary
In this chapter, you have learned how to use SQL queries from within a PHP script and
output the result into a HTML page.
Because the entire application code is now becoming a bit complex, it is really important that
you are able to separate the code into individual parts and test each part individually.

### New Concepts and Terms
- Step by Step development