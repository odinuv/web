---
title: Updating data
permalink: /walkthrough/backend-update/
redirect_from: /en/apv/walkthrough/backend-update/
---

* TOC
{:toc}

In the [previous chapter](/walkthrough/backend-insert/), you have learned how to insert data into
a database table. The important part is to handle optional values properly and implement sound form validation.
Updating a record in a database is quite similar. The only
challenge is to provide the user with the initial values of the edited record. Again, no new technologies are needed, it is just another combination of what you have learned already.

## Getting Started
We'll start by modifying the script for inserting a new person from the previous chapter.
PHP Script `person-update-1.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/backend-update/person-update-1.php %}
{% endhighlight %}

Template `person-update-1.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough/backend-update/templates/person-update-1.latte %}
{% endhighlight %}

The only thing changed in the template so far is the button description (seeing an opportunity?).
The PHP script is changed slightly more -- I have changed `INSERT` to `UPDATE` and added the `WHERE`
condition and therefore also another `id_person` parameter to identify what person should be updated.

## Supply Values
First we need to obtain the values of the selected person from a database. Then we
need to supply the existing values into the form -- put them in the `value` attribute of each of the form
controls. Lets' still assume that we have the ID of the selected person in the `$idPerson` variable.
We'll get back to that later.

File `person-update-2.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/backend-update/person-update-2.php %}
{% endhighlight %}

Note the use of the condition:

{% highlight php %}
if (!$tplVars['person']) {
    exit("Cannot find person with ID: $personId");
}
{% endhighlight %}

This is necessary, in case the person with the given ID would not exist. In that case
the `fetch()` method returns false. Which means that querying for `$person['first_name']`
would produce a warning about an undefined index. To simplify the whole thing, we just terminate
the entire script with `exit`. This is a bit harsh, but effective.
In the template, we need to use the values of the `$person` variable to pre-fill the form.
Note that on the radiobutton (or `<select>`), you have to use the `selected` attribute.

File `person-update-2.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough/backend-update/templates/person-update-2.latte %}
{% endhighlight %}

Now the script works and updates the person with the ID in the `$personId` variable. All
we need now is to obtain the `personId` value from somewhere.

## Obtaining Person ID
This is a question of the entire application design. How will the end user get to the
page for updating a person? There are many possible solutions, but one of the easiest
and still well usable is to **link it** from a list of persons.

Let's update a list of persons to link each person to the update form, all we need is to
add another field to the table in `person-list.latte` file:

{: .solution}
{% highlight html %}
{% include /walkthrough/backend-update/templates/person-list.latte %}
{% endhighlight %}

Don't forget to add a `<th>` too, if you have added a new table column. Also verify that
you have `id_person` among the list of selected columns from the database in `person-list.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/backend-update/person-list.php %}
{% endhighlight %}

Now the table with persons contains a link next to each person and the link points to
`person-update.php?id=XXX` where `XXX` is the ID of the corresponding person. Now all you need is to
pickup the ID passed in the URL address in the `person-update.php` script.

File `person-update-3.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/backend-update/person-update-3.php %}
{% endhighlight %}

You need to check whether the parameter `id` has been provided to the script, because nothing prevents anyone from
manually visiting the script URL without the parameter. Otherwise there are no changes to the script or
the template. The parameter `id` must be obtained from the `$_GET` variable, because it is passed
in URL (not through form).

Notice again, how I get the solution in gradual steps. First I modify the existing script to
update a person hardcoded in the script. When this works, I add a SELECT statement and
update the template to pre-fill the form. Last I solve the problem of selecting the right person
by modifying the person list template.

## Task -- Reuse the template
You have probably noticed that the templates for adding and updating a person are almost the same. They
probably will be so similar, because even if we add other properties (database columns) for persons,
it is very likely that they will have to be added to both forms. Hint: you will need an
[`include`](https://latte.nette.org/en/macros#toc-file-including) command in template.

PHP script for inserting a person:

{: .solution}
{% highlight php %}
{% include /walkthrough/backend-update/person-insert-4.php %}
{% endhighlight %}

PHP script for updating a person:

{: .solution}
{% highlight php %}
{% include /walkthrough/backend-update/person-insert-4.php %}
{% endhighlight %}

Latte template script for inserting a person (`person-insert-4.latte`):

{: .solution}
{% highlight html %}
{% include /walkthrough/backend-update/templates/person-insert-4.latte %}
{% endhighlight %}

Latte template script for updating a person (`person-update-4.latte`):

{: .solution}
{% highlight html %}
{% include /walkthrough/backend-update/templates/person-update-4.latte %}
{% endhighlight %}

And a `person-form.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough/backend-update/templates/person-update-4.latte %}
{% endhighlight %}

As you can see, templates allow you to reuse common blocks of HTML code (using the `include` statement)
and remove repeating code.

## Summary
In this chapter you have learned how to update data in the database. This is technically no different to
selecting or inserting data, it is just a combination of all the approaches you have learned in
previous chapters. I have also demonstrated how to reuse code using templates.

### New Concepts and Terms
- supply values to form controls
- pass values between scripts
- include templates
