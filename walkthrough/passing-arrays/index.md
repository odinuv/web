---
title: Passing arrays
permalink: /walkthrough/passing-arrays/
redirect_from: /en/apv/walkthrough/passing-arrays/
---

* TOC
{:toc}

Modification of records in database via web user interface is usually performed one by one. User opens record details
(user is redirected to some detail page -- ID of record is passed as URL parameter) and performs changes in data using
generated form. The form is then submitted and backend updates one record in a database. Sometimes the designer of user
interface wants to make this process a bit less verbose.

It can be more convenient to modify multiple database records at once. To achieve this you can simply generate a form
using `{foreach $rows as $record}{/foreach}` loop. This will result into a form with many input fields which represent
same type of information for different records. The question is how to pass modified data back to the backend and
maintain information about which piece of data belongs where.

The key lies in form inputs' `name` attribute. We can pass arrays instead of scalar values using a specific notation
in `name` attribute value:

{% highlight html %}
<form action="..." method="post">
    <label>Person 1</label>
    <input name="birthday[]">
    <label>Person 2</label>
    <input name="birthday[]">
    <label>Person 3</label>
    <input name="birthday[]">
    <input type="submit">
</form>
{% endhighlight %}

After submission of such form, the backend will have access to `$_POST['birthday']` value which will hold array of length 3
indexed from zero, i.e. in `$_POST['birthday'][0]` will be content of first input and so on.

You can also set a concrete key in `name` attribute:

{% highlight html %}
<form action="..." method="post">
    <label>Person 1</label>
    <input name="birthday[59]">
    <label>Person 2</label>
    <input name="birthday[12]">
    <label>Person 3</label>
    <input name="birthday[80]">
    <input type="submit">
</form>
{% endhighlight %}

This is useful when you want to modify existing information -- the key may represent ID of record in a table.

{: .note}
The keys in `name` attribute does not have any quotes around and it can contain a string too.

{: .note.note-cont}
You can use multiple brackets to nest deeper in `$_POST` array, e.g. `name="attr[123][email][]"` will be accessible
as `$_POST[123]['email'][0]`.

### How does browser transfer these information and how does it become multidimensional array?
The browser does not care very much about contents of `name` attributes -- remember that contents of name attribute
is generated on backend using templating engine. It simply composes a string which consists of name--value pairs
(`name[1]=value&name[1]=value1&...`) and sends it to the backend either in URL using GET method or in payload of
request using POST. Only inputs which are not disabled and have `name` attribute are considered for this operation.
The browser does it even if some input has exactly same name value as another input (`name=value1&name=value2&...`) --
in this case you will find only the latter value in `$_GET`/`$_POST`.

The hard work is carried out by PHP interpreter which detects squared brackets in the names of input parameters and
composes a multidimensional array (or rewrites previous value when there are no squared brackets).

{: .note}
It is very important to place squared brackets into `name` attribute when you **want** to pass multiple values.
The browser or PHP interpreter **does not** generate any error or warning when multiple input fields have same
value inside their `name` attribute.

## Task -- make your own form with multiple fields
Let's say that you want to modify height of multiple persons at once (suppose that the user of your application can
keep records about some kids which have grown up since last update). The form has to contain input fields for each
person and those fields should be prefilled with known values.

Prepare a template which generates a large form based on selection of all persons from a database. Remember to set
`name` attribute of input and pass ID of person into squared brackets without quotes. This is a bit tricky because
PHP uses squared brackets to access array elements -- `name="height[{$person['id_person']}]"`.

`height-form.latte`:

{: .solution}
{% highlight php %}
{% include /walkthrough/passing-arrays/templates/height-form-1.latte %}
{% endhighlight %}

Create also a PHP script which loads all young persons or persons with unknown height.

`height-form.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/passing-arrays/height-form-1.php %}
{% endhighlight %}

Now you should be able to see all submitted values and keys representing IDs of persons using `print_r($_POST)` or
similar command. Then you can update person records in the database using `UPDATE` SQL statement.

`height-form.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/passing-arrays/height-form-2.php %}
{% endhighlight %}

After you finish reading of [JavaScript](/articles/javascript) article, return here and try to create a simple
reset button next to each input field which will simply return original value into the field.

`height-form.latte`:

{: .solution}
{% highlight php %}
{% include /walkthrough/passing-arrays/templates/height-form-2.latte %}
{% endhighlight %}

{: .note}
Did you notice that for persons with unknown height (NULL value in database) the Latte engine produces different output
in JavaScript and HTML context? Compare this: `onclick="resetHeight(47, null)"` and `<input type="number" name="height[47]" value="">`.
In JavaScript context (`onclick`) the `{$person['height']}` Latte command produces `null` and for HTML context
(`value="..."`) it produces just empty string. This cool feature is called "context aware escaping".

{: .note.note-cont}
In JavaScript, a call to function `onclick="resetHeight(47, )"` would obviously cause a syntax error. Therefore the
Latte templating engine handles the output of a special NULL value differently - this is a **feature** of Latte
and it not common among templating engines.

## Multiple values from single input
I demonstrated this functionality so far using a single input for each value. There is an exception: `<select>`
element with `multiple` attribute needs to have squared brackets too because it generates a query parameter for
each selected option:

{% highlight html %}
<form action="..." method="post">
    <select name="multi[]" multiple="multiple">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
    <input type="submit">
</form>
{% endhighlight %}

It works exactly the same as with multiple input fields -- imagine multi-select as a set of checkboxes and each of
them having same `name` attribute value.

In this case you cannot specify a key inside the squared brackets. Use another dimension of array to overcome this
restriction `name="multi[123][]"`.

## Summary
You probably see that you can create useful web applications even without such complicated gadgets. On the other hand,
useful and easy to use user interface can make difference and give you a competitive advantage. The decision is up to you.

Introduced approach may be widely extended with [JavaScript](/articles/javascript) and/or [AJAX](/articles/javascript/#ajax).
We can easily generate form input fields on demand and even prefill some values from backend.

A useful improvement in your project may be a form which will allow to add or modify multiple contact information of
a person at once (remember to include dropdown with contact type selection). This is also a small challenge because it
involves [cloning of HTML elements](https://developer.mozilla.org/en-US/docs/Web/API/Node/cloneNode) using JavaScript.

### New Concepts and Terms
- passing arrays
