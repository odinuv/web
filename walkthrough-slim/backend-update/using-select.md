---
title: Using select element
permalink: /walkthrough-slim/backend-update/using-select/
---

* TOC
{:toc}

{% include /common/using-select-1.md %}

## Task -- use select element to update or erase person's address.

### Step 1
Load all locations from database into `select` element options and use the value attribute for `id_location`.

`routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/backend-update/person-address-1.php %}
{% endhighlight %}

`person-address.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/backend-update/person-address-1.latte %}
{% endhighlight %}

### Step 2
Now prepare your script to receive `id` parameter which will represent ID of a person. Find one person in
database and print his name. Remember to pass ID of person along with new ID of his new address -- you will need both
in `UPDATE` query.

`routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/backend-update/person-address-2.php %}
{% endhighlight %}

`person-address.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/backend-update/person-address-2.latte %}
{% endhighlight %}

{: .note}
To test your page, find some person in a database and type URL like `set-address?id=XXX`
into browser's address bar. Or you can prepare a link to this form from list of persons.

### Step 3
Almost there -- preselect address of a person if he has one and tell the form where to send data:

`routes.php`: (no change here):

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/backend-update/person-address-3.php %}
{% endhighlight %}

`person-address.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/backend-update/person-address-3.latte %}
{% endhighlight %}

{: .note}
You can also use Latte's [n:attr](https://latte.nette.org/en/macros#toc-n-attr) [macro](/walkthrough/templates/#macros).

{% highlight html %}
<option value="..." n:attr="selected => $person['id_location'] == $loc['id_location']">
  ...
</option>
{% endhighlight %}

### Step 4
Now create the update script which will handle form submission -- it will receive ID of person and ID of his new
address (or empty string if you choose *Unknown address* option). Redirect back to person address selection form
after update:

`routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/backend-update/store-address.php %}
{% endhighlight %}

{% include /common/using-select-2.md %}