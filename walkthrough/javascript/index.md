---
title: JavaScript
permalink: /walkthrough/javascript/
redirect_from: /en/apv/walkthrough/javascript/
---

<div class='common-part-info' title='This part is common to all walkthroughs'>&nbsp;</div>

* TOC
{:toc}

{% include /common/javascript-1.md %}

### Task -- Confirm Person Deletion
Now enhance the [script for deleting persons](/walkthrough/backend-delete). Insert a piece of
Javascript code which will prompt the user for confirmation before deleting the person.
Feel free to to insert the JavaScript code directly into the template, but be careful
where you insert the `<script>` tag -- remember that `{foreach ...}` duplicates all source inside
and you do not want multiple `<script>` tags with same function declaration in your markup.
Try to pass the person name into the confirmation message.

{: .solution}
{% highlight html %}
{% include /walkthrough/javascript/delete.latte %}
{% endhighlight %}

{: .note}
Remember that the actions representing modifications of the database records should be transmitted to
the server using the [*POST* method](todo).

{% include /common/javascript-2.md %}