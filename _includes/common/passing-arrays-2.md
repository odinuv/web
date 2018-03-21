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

Introduced approach may be widely extended with [JavaScript](/articles/javascript/) and/or [AJAX](/articles/javascript/#ajax).
We can easily generate form input fields on demand and even prefill some values from backend.

A useful improvement in your project may be a form which will allow to add or modify multiple contact information of
a person at once (remember to include dropdown with contact type selection). This is also a small challenge because it
involves [cloning of HTML elements](https://developer.mozilla.org/en-US/docs/Web/API/Node/cloneNode) using JavaScript.

### New Concepts and Terms
- passing arrays