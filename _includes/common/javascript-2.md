## Form validation
Nowadays you can use much more types of [input elements](../html-forms/#advanced-text-input)
than a few years ago. This means that many validations can be carried out by the browser.
You can adjust CSS styles using `:valid`, `:invalid` or `:required` [pseudo-classes](../css/#pseudoclasses)
to visually differentiate input states. You should use these capabilities as much as possible. Nevertheless
you may sometimes need to implement some custom logic. For example switch `required` state or
`enable`/`disable` some input in dependence of another input's value or dynamically
calculate some additional value such as price.

Here is an example with dynamic form which simulates a flight reservation. I used a `<fieldset>` element
which is capable of disabling or enabling multiple inputs within it. These inputs represent optional
baggage section of a flight reservation form. Based on the selected options, the price of flight is
adjusted immediatelly:

![Form validation](/common/javascript/form-validation.png)

{: .solution}
{% highlight html %}
{% include /common/javascript/form-validation.html %}
{% endhighlight %}

I used `document.forms` which contains object with keys defined by the form `name` attribute.
Each form is again an object with keys defined by inputs' `name` attribute. Attributes of
JavaScript objects can be accessed using square brackets (where you can also use a variable)
or you can just use the dot notation `.key`. There is no functional difference between
`document.forms.formName` and `document["forms"]["formName"]`
or `document.forms["formName"]`. I prefer latter variant because attribute values can
contain characters like `-` which are reserved in JavaScript and cannot be used in the former variant.

{: .note}
This approach is ideal for manipulating form elements (such as enabling/disabling the fieldset as
in the above example). Computing the final price this way is not ideal, because it
means duplicated logic in the server and the client scripts (the price computed by the client
must be considered unreliable). A better solution in such case is to use
[AJAX](/articles/javascript/#ajax).

### Task -- Add `required` attribute to Person & Address form inputs dynamically
Do you remember when I was talking about inserting [multiple records at once](../backend-insert/advanced/).
You should have already created a form where you can insert a person and a place where he lives.
Try to extend this form with JavaScript and add `required` attribute to `city` only when a user enters a `street_name`.

{: .solution}
{% highlight html %}
{% include /common/javascript/form-validation-address.html %}
{% endhighlight %}

## Summary
This brief chapter about JavaScript programming language should help you to improve your project with instant popup
dialogs and a bit of client-side form validation. You can find more in [articles](/articles/javascript/)
section of this book.

### New Concepts and Terms
- JavaScript
- Event
- Event Handler
- Callback
- Anonymous function
- Dynamic HTML
