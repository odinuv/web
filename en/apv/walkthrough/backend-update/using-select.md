---
title: Using select element
permalink: /en/apv/walkthrough/backend-update/using-select/
---

* TOC
{:toc}

This small chapter is about using HTML [select element](/en/apv/walkthrough/html-forms/#select). This element has
three faces in HTML. You often encounter it as simple drop-down list and less often as select list and rarely
as select list with multiple options:

Select element is used often to pick values of entity in [many-to-one](/en/apv/articles/database-design/#relationship-cardinality)
relation to entity of record which is being edited (e.g. person's address, type of contact, type of relationship, ...).

Here is a list of possible `select` element variants:

<table>
    <tr>
        <th>Classic select - drop down</th>
        <td>
            <select name="spoken_languages">
                <option value="cze">Czech</option>
                <option value="svk">Slovak</option>
                <option value="eng">English</option>
                <option value="ger">German</option>
            </select>
        </td>
        <td>
{% highlight html %}
<select name="spoken_languages">
    <option value="cze">Czech</option>
    ...
</select>
{% endhighlight %}
        </td>
    </tr>
    <tr>
        <th>Select list</th>
        <td>
            <select name="spoken_languages" size="6">
                <option value="cze">Czech</option>
                <option value="svk">Slovak</option>
                <option value="eng">English</option>
                <option value="ger">German</option>
            </select>
        </td>
        <td>
{% highlight html %}
<select name="spoken_languages" size="6">
    <option value="cze">Czech</option>
    ...
</select>
{% endhighlight %}
        </td>
    </tr>
    <tr>
        <th markdown="1">Select list -- multiple</th>
        <td>
            <select name="spoken_languages[]" multiple="multiple" size="6">
                <option value="cze">Czech</option>
                <option value="svk">Slovak</option>
                <option value="eng">English</option>
                <option value="ger">German</option>
            </select>
        </td>
        <td>
{% highlight html %}
<select name="spoken_languages[]" multiple="multiple" size="6">
    <option value="cze">Czech</option>
    ...
</select>
{% endhighlight %}
        </td>
    </tr>
</table>

The concept behind this type of form input is that you select one (or more) `option`s and their `value` attribute is
transmitted to server's backend named according to value of `name` attribute attached to parent `select`. If the
`option` element lacks `value` attribute, the browser simply sends its contents (visible text).

That hidden `value` is very important because you can have different representation of entry for the user (e.g. textual)
and for your code (e.g. ID of some database entry).

Groups of [`radio` buttons](/en/apv/walkthrough/html-forms/#radio-button) and [`checkbox`es](/en/apv/walkthrough/html-forms/#checkbox)
work similarly, except that you have to give each of them **same** `name` attribute and textual representation is
carried out by `label` element.

{: .note}
See those squared brackets in third example? They tell the backend to interpret incoming data as array (you can even
specify keys for that array in template's code). Always pass values from multiple selects/checkboxes as array.
You can read more about this approach in another [walkthrough article](/en/apv/walkthrough/passing-arrays/).

{: .note.note-cont}
Radio buttons are like drop-down lists, they allow only one checked value -- no need for squared brackets.

## Task -- use select element to update or erase person's address.

### Step 1
Load all locations from database into `select` element options and use the value attribute for `id_location`.

`person-address-1.php`:

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend-update/person-address-1.php %}
{% endhighlight %}

`person-address-1.latte`:

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend-update/templates/person-address-1.latte %}
{% endhighlight %}

### Step 2
Now prepare your script to receive `id` parameter which will represent ID of a person. Find one person in
database and print his name. Remember to pass ID of person along with new ID of his new address -- you will need both
in `UPDATE` query.

`person-address-2.php`:

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend-update/person-address-2.php %}
{% endhighlight %}

`person-address-2.latte`:

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend-update/templates/person-address-2.latte %}
{% endhighlight %}

{: .note}
To test your page, find some person in a database and type URL like `person-address-2.php?id=XXX`
into browser's address bar. Or you can prepare a link to this form from list of persons.

### Step 3
Almost there -- preselect address of a person if he has one and tell the form where to send data:

`person-address-3.php` (no change here):

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend-update/person-address-3.php %}
{% endhighlight %}

`person-address-3.latte`:

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/backend-update/templates/person-address-3.latte %}
{% endhighlight %}

{: .note}
You can also use Latte's [n:attr](https://latte.nette.org/en/macros#toc-n-attr) [macro](/en/apv/walkthrough/templates/#macros).

{% highlight html %}
<option value="..." n:attr="selected => $person['id_location'] == $loc['id_location']">
  ...
</option>
{% endhighlight %}

### Step 4
Now create the update script which will handle form submission -- it will receive ID of person and ID of his new
address (or empty string if you choose *Unknown address option*). Redirect back to person address selection form
after update:

`store-address.php`:

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/backend-update/store-address.php %}
{% endhighlight %}

Finally done. Take a look into your browser's developer tools (F12) and observe what the browser sends when you
select different location IDs. Also note HTTP methods and [immediate redirection](/en/apv/walkthrough/backend-delete/#redirect-after-post)
after update script:

{: .image-popup}
![Schema of variables](/en/apv/walkthrough/backend-update/select-values.png)

{: .note}
Because this is quiet small functionality, try to incorporate this script into person update module.

## Optgroups
Just to be complete: to group `select` element `option`s use `optgroup` tag:

{% highlight html %}
{% include /en/apv/walkthrough/backend-update/optgroup.html %}
{% endhighlight %}

## Summary
This walkthrough chapter should help you to understand name-value concept of `select` element which is not that clear
at first sight as with simple text inputs. You can try to use multiple select element and update some M:N cardinality
relationship like persons attending a meeting.

### New Concepts and Terms
- optgroup