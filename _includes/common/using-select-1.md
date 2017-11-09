This small chapter is about using HTML [select element](../html-forms/#select). This element has
three faces in HTML. You often encounter it as simple drop-down list and less often as select list and rarely
as select list with multiple options:

Select element is used often to pick values of entity in [many-to-one](/articles/database-design/#relationship-cardinality)
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

Groups of [`radio` buttons](../html-forms/#radio-button) and [`checkbox`es](../html-forms/#checkbox)
work similarly, except that you have to give each of them **same** `name` attribute and textual representation is
carried out by `label` element.

{: .note}
See those squared brackets in third example? They tell the backend to interpret incoming data as array (you can even
specify keys for that array in template's code). Always pass values from multiple selects/checkboxes as array.
You can read more about this approach in another [walkthrough article](../passing-arrays/).

{: .note.note-cont}
Radio buttons are like drop-down lists, they allow only one checked value -- no need for squared brackets.