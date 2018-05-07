---
title: Deleting data
permalink: /walkthrough-slim/backend-delete/
---

* TOC
{:toc}

{% include /common/backend-delete-1.md %}

## Getting started
Deleting data from database is technically very similar to [inserting](/walkthrough-slim/backend-insert/) or
[updating](/walkthrough-slim/backend-update/) data. You need to create a script which will
take some parameter with a value to identify the record (e.g. a person). The script will then
execute a SQL `DELETE` query to remove that record from database.

Lets create a PHP script which will handle the deletion of a person when a suitable
parameter is supplied. This parameter should be the primary key of the row you want to delete -- only
one number. PHP script with `DELETE` SQL command:

{% highlight php %}
{% include /walkthrough-slim/backend-delete/delete-1.php %}
{% endhighlight %}

That's pretty much all. To test this, you can create a simple form with `<input type="number">` and
a GET method route. Latte template with form:

{% highlight html %}
{% include /walkthrough-slim/backend-delete/delete.latte %}
{% endhighlight %}

The route to render the template:

{% highlight php %}
{% include /walkthrough-slim/backend-delete/delete-2.php %}
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

![Screenshot - Browser Reload](/common/backend-delete/reload.png)

In the form, I have used `method="post"` which means that the form is submitted using [HTTP POST method](/articles/http/).
The HTTP POST method should be used to represent user actions (e.g. deleting a person). Reloading the
page will send the same HTTP request -- i.e. it will repeat the action (delete the person again), which is what the browser
is asking about. To avoid this annoyance, you have to **redirect after POST**:

{% highlight php %}
{% include /walkthrough-slim/backend-delete/delete-3.php %}
{% endhighlight %}

In the above script, I added the line `return $response->withHeader(...);`. This calls the internal PHP
[`header()` function](http://php.net/manual/en/function.header.php) which sends a [HTTP header](/articles/http/).
The [`Location` header](https://en.wikipedia.org/wiki/HTTP_location) is used to inform the browser
that the page has moved (redirected) to a new location. In this case, the new location is the same as the old location
(GET route called `deleteForm`), but the browser still moves to the new address. During this the POST data from the
form is lost, because the HTTP GET method is used. This means that when the user actually sees the page,
the browser will be looking at the second load of that page and it will know nothing about the submitted form.

The schematic below illustrates this in a sequence of steps:

{: .image-popup}
![Graph -- Redirect after POST](/common/backend-delete/redirect.svg)

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

Extend your script which [lists all persons](/walkthrough-slim/backend-select/) with a delete button.
Take the HTML form you have used in the previous example, and change the `<input type="number" ...>`
`type="hidden"`. Then put that form in each row of the users list. Pass the value of `id_person` column
as a value of the hidden form field. Remember to extend the `SELECT` SQL command to retrieve the
`id_person` column. Also remember to redirect back to list of persons after deletion.

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/backend-delete/person-list.latte %}
{% endhighlight %}

{% include /common/backend-delete-2.md %}