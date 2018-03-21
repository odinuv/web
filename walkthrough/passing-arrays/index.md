---
title: Passing arrays
permalink: /walkthrough/passing-arrays/
redirect_from: /en/apv/walkthrough/passing-arrays/
---

* TOC
{:toc}

{% include /common/passing-arrays-1.md %}

## Task -- make your own form with multiple fields
Let's say that you want to modify height of multiple persons at once (suppose that the user of your application can
keep records about some kids which have grown up since last update). The form has to contain input fields for each
person and those fields should be prefilled with known values.

Prepare a template which generates a large form based on selection of all persons from a database. Remember to set
`name` attribute of input and pass ID of person into squared brackets without quotes. This is a bit tricky because
PHP uses squared brackets to access array elements -- `name="height[{$person['id_person']}]"`.

Template `height-form.latte`:

{: .solution}
{% highlight php %}
{% include /walkthrough/passing-arrays/templates/height-form-1.latte %}
{% endhighlight %}

Create also a PHP script which loads all young persons or persons with unknown height.

File `height-form.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/passing-arrays/height-form-1.php %}
{% endhighlight %}

Now you should be able to see all submitted values and keys representing IDs of persons using `print_r($_POST)` or
similar command. Then you can update person records in the database using `UPDATE` SQL statement. The ID of a person
should be accessible as the key of array. Use `foreach($array as $key => $value) { ... }` to get the ID.

File `height-form.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough/passing-arrays/height-form-2.php %}
{% endhighlight %}

After you finish reading of [JavaScript](/articles/javascript/) article, return here and try to create a simple
reset button next to each input field which will simply return original value into the field.

Template `height-form.latte`:

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
and it is not common among templating engines.

{% include /common/passing-arrays-2.md %}