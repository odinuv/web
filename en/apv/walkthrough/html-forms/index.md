---
title: Forms
permalink: /en/apv/walkthrough/html-forms/
---

* TOC
{:toc}

Apart from [describing structure](/en/apv/walkthrough/html/) of text documents, the HTML language can
be used to create forms. However, HTML is not capable of processing those forms, so
another [part of the technology stack](/en/apv/walkthrough/dynamic-page/) must be 
used for that. So again, this
will be slightly boring, because you can't do much with HTML forms alone.

Form elements must be contained in `form` element, otherwise they won't work. This
is particularly nasty because the `form` element is not rendered (which means it is
invisible) and therefore it is hard to detect that you forgot to use the
`form` element.

## Form controls
There are many form control types and there are some differences in support among
various browsers (Firefox is a bit behind in this). See [CanIUse](http://caniuse.com/#feat=forms) for
current information about the feature support.

The following list shows the most common (and useful) form controls and some
very useful attributes of those controls.

Many form inputs are created using the `input` element. The input element has no content, so
it's written in using shorthand tags `<input ... />`. The type of the input is determined by the
value of the `type` attribute. Therefore to create a text form input, use:

{% highlight html %}
<input type='text' />
{% endhighlight %}

### Labels
[Good accessibility practice](https://www.w3.org/WAI/tutorials/forms/labels/) recommends that all HTML inputs have
labels. This is not always honored, but unless you have some really strong reasons, you should always use `labels`.
Labels are particularly useful for `checkbox` and `radio` input types, where they ease
selecting the options as the user can click the text (and does not need to aim for the check-mark itself).

There are two methods to associate a label with an input. Either the `input` element must be contained in the
`label` element or they are linked using `for` and `id` attributes.

#### Method 1
{% highlight html %}
<label>Enter your name:
    <input type='text' />
</label>
{% endhighlight %}

#### Method 2
{% highlight html %}
<label for='firstName'>Enter your name:</label>
<input id='firstName' type='text' />
{% endhighlight %}

### Name and Value
When [processing HTML forms](/en/apv/walkthrough/dynamic-page/), the browser only 
sends the server **name** and **value** pairs for
each form control. This means that is quite important to know what is the `name` and `value` of each
element and how they produce the **name** -- **value** pairs. To test what is received on a server for each
form, you can submit any of the below forms and a [simple script](http://odinuv.cz/en/form_test.php) 
will print to you what the server sees. In your own script, you can achieve that by 
setting `action=http://odinuv.cz/en/form_test.php` attribute.

For most form controls, the `name` of the control must be unique within the `form` element. This means that
across different forms, the form elements may be same, but inside a single form you must not use same name twice,
because the value of one form control would overwrite the value from the other form control. A notable
exception to this are [buttons](/en/apv/walkthrough/html-forms/#button) 
and [radio-buttons](/en/apv/walkthrough/html-forms/#radio-button), where name does not need to be unique.

### Common attributes
Apart from `name` and `value`, most controls have attributes:

- `required` -- When used, the end-user must enter a value in the control.
- `readonly` -- When used, the end-user cannot change the value of the control, he can
    however focus the control (enter cursor into it) and e.g. copy text from the control.
- `disabled` -- When used, the end-user cannot interact with the control in way.
- `id` -- A unique identifier of the HTML element, used for 
linking [labels](/en/apv/walkthrough/html-forms/#labels).

### Button
Button is an important part of the form, as it allows the end user to actually send a form.
Button is best created with `button` element. Button should have a `type` attribute with value:

- `submit` -- Standard button for submitting a form
- `reset` -- Button for resetting the form to default state (and make end-user angry)
- `button` -- Button which does nothing (button must be [handled by Javascript](todo))

Button has `name` and `value` attributes. However, if a form has multiple buttons, only the button which has been
actually clicked will be send by the browser. Buttons are used without the `label` element.

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/button.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/button.html %}

### Basic Text Input
As shown above, the text input is created by specifying `type='text'` attribute. Use the
text input for input of an arbitrary text. Name of the
form control is defined by the `name` attribute. The input element has no content, so there
is no end tag for `input` element. Other useful attributes are:

- `value` -- for providing default value of the input
- `placeholder` -- for providing a placeholder (e.g. sample value)
- `required` -- to trigger validation that a value must be entered

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/text-input.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/text-input.html %}

You can create a password input (input is hidden by asterisks) by specifying
`type='password'`. Apart from blocking the visible input, it behaves the same
as the text input. Note that the contents of the password input are visible
in the source of the HTML page though.  

### Number Input
The input for entering a number is created by specifying `type='number'` or `type='range'` attribute.
Name of the form control is defined by the `name` attribute. Other useful attributes are:

- `value` -- for providing default value of the input
- `required` -- to trigger validation that a value must be entered
- `min` -- minimum value of the number
- `max` -- maximum value of the number
- `step` -- step by which the number can be increased

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/number-input.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/number-input.html %}

### Date input
There is a number of predefined input for entering date and time values. Some of
those are not supported among all web browsers yet (e.g. Firefox).
Predefined date input types are:

- `date` -- for entering just date
- `datetime-local` -- for entering date with time (including current timezone)
- `time` -- for entering just time (no timezone, because there is not date)
- `week` -- for entering just week of year
- `month` -- for entering just month of year

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/date-input.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/date-input.html %}

### Advanced Text Input
If you need the end user to enter a value, but it fits into none of the above
input types (number and date), you can use more specialized inputs such as
`type='email'` or `type='url'` which validate the end-user input. If you
need something even more custom, you can build your own validation use a
combination of attributes:

- `minlength` for providing default value of the input
- `maxlength` for providing a placeholder (e.g. sample value)
- `pattern` to trigger validation that a value must be entered

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/text-input.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/text-input.html %}

### Checkbox
Checkbox is suitable for getting a boolean value from the end-user. As all
the above controls, checkbox is also identified by `name` attribute. The
`value` attribute is usually set to `1`. When the checkbox is ticked, the
web browser send the value (`1`), when the checkbox is not ticked, the
web browser does not send anything (act as if there wasn't a checkbox in
the form). To make the checkbox checked by default, use the
`checked='checked'` [boolean attribute](/en/apv/articles/html/#html-elements----tags). 
Try it in the following example:

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/checkbox.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/checkbox.html %}

{: .note}
When using checkbox, it is important to use `label` element, so that the
label text is clickable.

### Radio Button
Radiobutton is suitable for choosing between few mutually exclusive values.
For few values, it is better than [Select box](/en/apv/walkthrough/html-forms/#select) because it saves the
end-user a click. There are a couple of exceptions to the radiobutton behavior.
First, the `name` attribute of the radio button is used to define a **radio group**.
Radio-buttons within the same *radio group* are mutually exclusive -- this means that
`name` should not be strictly unique. Each button in the *radio group* must have
a unique value within that group, because the web browser will send name of the
*radio group* with the `value` of the selected radio button. As with checkbox, to
have a radiobutton pre-selected, use the [boolean attribute](/en/apv/articles/html/#html-elements----tags) 
`checked='checked'`. You can test it in the following examples:

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/radiobutton.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/radiobutton.html %}

{: .note}
When using radio button, it is important to use `label` element, so that the
label text is clickable.

### Select
Select element allows the user to choose from multiple options. To create a select element,
there are actually two HTML elements used `select` for the select itself and `option` for
individual options. The `select` element has the `name` attribute and, the `option` element
has the `value` attribute. The content of the `select` element are `option` elements and
the content of `option` element is the actual text of the option.
To have an option pre-selected, you can use the `selected` attribute
(yes, that is different to the `checked` used 
in [checkbox and radiobutton](/en/apv/walkthrough/html-forms/#checkbox)).
The feel and look of the select element can be controlled by attributes:

- `size` -- number of visible items. When size is equal to 1 (default), the select is displayed
as a drop-down select.
- `multiple` -- [boolean attribute](/en/apv/articles/html/#html-elements----tags) 
to allow selecting of multiple elements.

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/select.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/select.html %}

{: .note}
When using `multiple` make sure to append `[]` to the element name, so that the value of the
element is sent as an array. Otherwise, only the first value would be sent.

### Textarea
Textarea allows the end-user to enter a multi-line text. Textarea has the attribute `name`, the
value of the element is actual element content, so there is no `value` attribute. The textarea
requires `rows` and `cols` attributes which define the number of rows and characters in each
row allowed in the textarea. Default value for `textarea` is entered simply as the element content.
The content of the `textarea` element is one of the few places in HTML, where whitespace is important.

{% highlight html %}
{% include /en/apv/walkthrough/html-forms/textarea.html %}
{% endhighlight %}

{% include /en/apv/walkthrough/html-forms/textarea.html %}

{: .note}
Inside `textarea` whitespace matters, therefore the line `You certainly want to buy it` must not be indented.

### Task -- Form in a list
Now try to create the following form. I used a [list](/en/apv/walkthrough/html/#task----lists) for arranging the
form controls in rows. Also make sure to verify the form by using
`<form method='post' action='http://odinuv.cz/en/form_test.php'>` and submitting the form.

![Screenshot - Form](/en/apv/walkthrough/html-forms/form-2.png)

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html-forms/form-sol-1.html %}
{% endhighlight %}

### Task -- Form in a table
Now try to create the following form. Here I used a [table](/en/apv/walkthrough/html/#task----tables) 
for arranging the
form controls in rows. Also make sure to verify the form by using
`<form method='post' action='http://odinuv.cz/en/form_test.php'>` and submitting the form.

![Screenshot - Form](/en/apv/walkthrough/html-forms/form-1.png)

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html-forms/form-sol-2.html %}
{% endhighlight %}


### Summary
You should now be able to create HTML forms with many different controls. Keep
in mind that forms cannot be processed by HTML language, so so far none of the
forms can actually do anything. When creating HTML forms it is important to
know what a name and value of each control is, and how they behave when
the form is actually submitted (because there are some differences between the
controls). Also keep in mind that if you have form elements outside `form` tag,
they will be displayed as usually, but they will not be working
(the control will not be sent to server).

You can also look at full list of [HTML elements](https://developer.mozilla.org/en/docs/Web/HTML/Element) 
to see what else HTML can offer to you.

### New Concepts and Terms
- Form
- Control
- Name & Value
- Control Label
- Control Validation
