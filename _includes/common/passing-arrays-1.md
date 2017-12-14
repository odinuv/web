Modification or insertion of records into a database via web user interface (i.e. your application) is usually performed
one by one. User opens the new record form or record details page (user is redirected to some detail page -- ID of record
is passed as URL parameter) and fills up information using generated form. The form is then submitted and backend inserts
or updates related records in a database. Similar process is used to delete records -- user clicks on a delete button
and the backend deletes exactly one record according to passed ID value. Sometimes the designer of user interface wants
to make this process a bit less verbose.

It can be more convenient to create/modify/delete multiple database records at once. To achieve this you can simply
generate a form using `foreach` loop. This will result into a form with many input fields which represent same type
of information for different records. The question is how to pass data back to the backend and maintain information
about which piece of data belongs where.

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

After submission of such form, the backend will have access to `birthday` (not `birthday[]`!) key in POST data which
will hold array of length 3 indexed from zero, i.e. in `$_POST['birthday'][0]` will be content of first input and so on.
There can be more inputs with different name attribute base. If you design your form carefully, you can be sure that the
order of all submitted inputs will match in all arrays.

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

This is useful when you want to modify existing information -- the key may represent ID of record in a database table.

{: .note}
The keys in `name` attribute does not have any quotes around and it can contain a string too.

{: .note.note-cont}
You can use multiple brackets to nest deeper in POST data array, e.g. `name="attr[123][email][]"` will be accessible
as `$_POST[123]['email'][0]`.

### How does browser transfer these information and how does it become a multidimensional array?
The browser does not care very much about contents of `name` attributes -- remember that contents of name attribute
is generated on backend using templating engine. It simply composes a string which consists of name--value pairs
(`name[1]=value1&name[2]=value2&...`) and sends it to the backend either in URL using GET method or in payload of
request using POST. Only inputs which are not disabled and have `name` attribute are considered for this operation.
The browser does it even if some input has exactly same name value as another input (`name=value1&name=value2&...`) --
in this case you will find only the latter value in `$_GET`/`$_POST` because there are no brackets.

The hard work is carried out by PHP interpreter which detects squared brackets in the names of input parameters and
composes a multidimensional array (or rewrites previous value when there are no squared brackets).

{: .note}
It is very important to place squared brackets into `name` attribute when you **want** to pass multiple values.
The browser or PHP interpreter **does not** generate any error or warning when multiple input fields have same
value inside their `name` attribute.