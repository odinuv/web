---
title: Deleting data
permalink: /en/apv/walkthrough/backend-delete/
---

* TOC
{:toc}

This section is dedicated to teach you how to delete database records.
Deleting something from a database is permanent and cannot be undone unless you have a database
backup. Be careful about what you delete, though do not be afraid to experiment with
your project since [you do have a backup for it](todo).

## Uniquness
The [SQL `DELETE`](/en/apv/walkthrough/database/#delete) command is already familiar to you.
One thing you should think of is how to determine which rows to delete. The most common action
is deletion of a single row. Each table should have a 
[primary key](/en/apv/articles/relational-database/#key) which identifies
each row with a unique value or a set of values. Therefore, you should use it to delete rows.

Be especially careful about compound keys. For example, you cannot delete a single person record by entering
its `first_name` and `last_name`. There is unique key on `first_name`,`lastname` and `nickname` 
columns. This means that the combination of `first_name`,`lastname` and `nickname` are guaranteed to be unique, 
but `first_name` and `last_name` are **not guaranteed to be unique**. These two attributes
of a person **can be shared** among many records in database. Notice the use of words "guaranteed" and 
"can be". It may well happen that your database contains only a single person with a particular 
`first_name` and `last_name`. But you cannot rely on such assumptions in your application code, because you don't
know what data will be in the database in future. To create a **reliable application**, you must 
use the database keys correctly!

It is also worth noting that before you allow users of your application to modify or even 
delete information, you should first
take steps to [authenticate](/en/apv/walkthrough/login) and authorize them.

## Getting started
Deleting data from database is technically very similar to [inserting](/en/apv/walkthrough/backend-insert/) or
[updating](/en/apv/walkthrough/backend-update/) data. You need to create a script which will
take some parameter with a value to identify the record (e.g. a person). The script will then
execute a SQL `DELETE` query to remove that record from database.

Lets create a PHP script which will handle the deletion of a person when a suitable
parameter is supplied. This parameter should be the primary key of the row you want to delete -- only 
one number. PHP script with `DELETE` SQL command:

{% highlight php %}
{% include /en/apv/walkthrough/backend-delete/delete.php %}
{% endhighlight %}

That's pretty much all. To test this, you can create a simple form with `<input type="number">`. 
Latte template with form:

{% highlight html %}
{% include /en/apv/walkthrough/backend-delete/templates/delete.latte %}
{% endhighlight %}

{: .note}
The above shows an important development practice. If you are working on a new feature, you don't have to
start with modifying exiting code and produce a muddle of experiments and working code. You should
always try the feature stand-alone. Only when it works and you know how it works, integrate it into the
application. Possibly throwing parts of it along the way (the above Latte template won't make it into 
the application). 

### Redirect After POST
If you submit the above form and reload the page in the browser (hit F5), you will receive a message from web browser
similar to this:

![Screenshot - Browser Reload](reload.png)

In the form, I have used `method="post"` which means that the form is submitted using [HTTP POST method](todo).
The HTTP POST method should be used to represent user actions (e.g. deleting a person). Reloading the 
page will send the same HTTP request -- i.e. it will repeat the action (delete the person again), which is what the browser
is asking about. To avoid this annoyance, you have to **redirect after POST**: 

{% highlight php %}
{% include /en/apv/walkthrough/backend-delete/delete-2.php %}
{% endhighlight %}

In the above script, I added the line `header("Location: delete.php");`. This calls the PHP
[`header()` function](http://php.net/manual/en/function.header.php) which sends a [HTTP header](todo).
The [`Location` header](https://en.wikipedia.org/wiki/HTTP_location) is used to inform the browser
that the page has moved (redirected) to a new location. In this case, the new location is the same as the old location
(`delete.php`), but the browser still moves to the new address. During this the POST data from the 
form is lost, because the HTTP GET method is used. This means that when the user actually sees the page, 
the browser will be looking at the second load of that page and it will know nothing about the submitted form.

The schematic below illustrates this in a sequence of steps:

{: .image-popup}
![Graph -- Redirect after POST](/en/apv/walkthrough/backend-delete/redirect.svg)

This 'trick' should be used for all forms representing actions (submitted with the POST method), including
insert and update forms.

{: .note}
Here you can see an important "feature" of web applications. The end user sees deleting of a person as 
a single action. From the application point of view, it involves **three executions** of a 
script to fulfill this action. 

### Task -- Make a delete button
The above script works but it is not very useful. Users of your application do not understand primary keys
and they do not want to remember some ID value which they have to type into a form. They want to see
a list of persons and a nice delete button which they just click.

Extend your script which [lists all persons](/en/apv/walkthrough/backend-select/) with a delete button. 
Take the HTML form you have used in the previous example, and change the `<input type="number" ...>`
`type="hidden"`. Then put that form in each row of the users list.
Pass the value of `id_person` column as a value of the hidden form field. Remember to 
extend the `SELECT` SQL command to retrieve the `id_person` column.

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend-delete/templates/person-list.latte %}
{% endhighlight %}

## Next Steps
Take a look at the [JavaScript](/en/apv/walkthrough/javascript#using-javascript-to-confirm-user-actions)
article to extend your form with a confirmation popup. It is a good idea to let the user confirm 
important information deletion because this action cannot be undone.

### Deleting Referenced Records
There are [foreign keys](/en/apv/articles/database-tech/#foreign-key-constraint) between the `person` table
and other tables (the `person` table is referenced from the records in the `relation` or the `contact` table). 
When you take a look at the *Foreign keys* section of the `contact` table details in the Adminer, you can see 
that there is `NO ACTION` defined under the `ON DELETE` event:

![Screenshot - Foreign Key No Action](fk1.png)
 
This means that if you try to delete a person record, the database server has no defined action to do with contacts
related to it -- the database does not know what to do with person's contacts when that person record ceases to exist.
Because of the foreign key constraint, the `id_person` column in the `contact` table cannot store anything else 
than values from the `id_person` column in the `person` table. As a result, the database has to reject 
your `DELETE` command.

Of course, it is not meaningful to keep contact entries which do not belong to anyone. We should therefore set
that `ON DELETE` behavior to `CASCADE` (use "Alter" button on right side):

![Screenshot - Foreign Key Cascade](fk2.png)

The `CASCADE` ensures that the `DELETE` command will delete the record 
with [**all records depending on it**](/en/apv/article/database-tech/#integrity-constraints). 
You should change this in every table which references `person` table, otherwise you won't be able
to delete persons with entries in those tables.

In other cases you might prefer to break the reference instead of deleting related entries. It is the case 
of the [`location` -- `person` relationship](/en/apv/articles/database-tech/#foreign-key----set-nul-example). 
When you want to delete an address which is referenced by a person record, you would rather set the 
foreign key deletion behavior for the `id_location` column
in the `person` table to `SET NULL` instead of `CASCADE`. This setting would preserve
a person record and set its `id_location` column to NULL (from now on, you will not know where she lives anymore).
To be able to do this, the `id_location` column must support storing a NULL value.

### Task -- Configure Foreign Keys
Now configure the foreign keys in your database so that you can delete records as needed.

{: .solution}
<div markdown='1'>
If you are stuck, I suggest you configure the following tables and keys:

- table `contact`, key `contact_id_person_fkey` set to `CASCADE`,
- table `meeting`, key `meeting_id_location_fkey` set to `SET NULL`,
- table `person`, key `person_id_location_fkey` set to `SET NULL`,
- table `person_meeting`, key `person_meeting_id_meeting_fkey` set to `CASCADE`,
- table `person_meeting`, key `person_meeting_id_person_fkey` set to `CASCADE`,
- table `relation`, key `relation_id_person1_fkey` set to `CASCADE`,
- table `relation`, key `relation_id_person2_fkey` set to `CASCADE`.
</div>

## Summary
Now you now how to delete records from a database. I have also showed you how to redirect after `POST` 
to avoid action confirmation. You should also understand how the foreign keys guard the
consistency of the data and that you need to think what to do with the dependent records -- whether to delete them along
or leave them in the database while removing the link to the deleted record. For a deeper explanation see
the [corresponding article](/en/apv/article/database-tech/#integrity-constraints). You can also
take a look at the chapter about [login](/en/apv/walkthrough/login) to limit access to this functionality.

### New Concepts and Terms
- Delete
- Hidden input
- Foreign keys
- Redirect
- CASCADE
- SET NULL
