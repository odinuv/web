---
title: Debugging web applications - frontend
permalink: /articles/debugging/frontend/
---

* TOC
{:toc}

Frontend is always a problem: many types of devices with different browsers and also the network quality. You will
probably never achieve 100% user experience for everybody. It is impossible. But you can greatly improve the quality
of your application by following rules and recommendations.

Errors on frontend depend on the usage of frontend technologies. If you use just HTML and CSS, you will probably be
OK once you learn and get used to HTML and CSS standards. Most of the browsers today support even new features of CSS3.

## HTML
One of the beginners greatest issue is the inexperience or ignorance of the HTML standards. I have seen block elements
inside block elements, forms inside forms, non-terminated forms rendered in a table, `<a>` tag inside `<button>`,
multiple `<html>` or `<body>` tags per page, mess inside `<tr>` element and many other HTML horrors.

Yes, the browsers are permissive and they forgive you a lot, but: the only way to ensure the highest level of
compatibility among browsers is to obey HTML standard as much as possible. Use [HTML validator](https://validator.w3.org/)
-- *validate by direct input* tab can be used for pages that are not publicly accessible.

Take a look at the source in your browser (in context menu or Ctrl+U shortcut), Firefox has a basic validator.

A great visual aid is code indentation, use functions of your IDE to format the source automatically. Compare following
pieces of the same source code. Many HTML tags are *pair tags* always use closing tag when appropriate.

~~~ html
{extends layout.latte}
{block title}Set person's address{/block}
{block body}
<form method="post" action="{link store-address}">
<input type="hidden" name="id" value="{$person['id_person']}"/>
<label>
Select new address for person {$person['first_name']} {$person['last_name']}:
</label>
<select name="location_id">
<option value="">Unknown address</option>
{foreach $locations as $loc}
<option value="{$loc['id_location']}">
{$loc['city']} {$loc['street_name']} {$loc['street_number']}
</option>
{/foreach}
</select>
<button type="submit">Set</button>
</form>
{/block}
~~~

~~~ html
{extends layout.latte}
{block title}Set person's address{/block}
{block body}
    <form method="post" action="{link store-address}">
        <input type="hidden" name="id" value="{$person['id_person']}"/>
        <label>
            Select new address for person {$person['first_name']} {$person['last_name']}:
        </label>
        <select name="location_id">
            <option value="">Unknown address</option>
            {foreach $locations as $loc}
                <option value="{$loc['id_location']}">
                    {$loc['city']} {$loc['street_name']} {$loc['street_number']}
                </option>
            {/foreach}
        </select>
        <button type="submit">Set</button>
    </form>
{/block}
~~~

![Format code function in PhpStorm](/articles/debugging/format-code.png)

You can modify HTML structure directly in the browser's developer tools (F12) to test the outcome. The browser
obviously does cannot save the file as it displays the result of template rendering made by PHP. You can use
double-click or F2 key to modify the HTML in the editor. You can locate an HTML element in the source quickly With the
selection tool (screenshot).
 
{: .image-popup}
![Inspector](/articles/debugging/inspector.png)

### Forms inside forms
This problem is usually most visible when you need to render multiple forms on one page. You click the second submit
button but the application deletes the last item (or does something else, or nothing). The problem is, that the forms
are not delimited and they all compose one large mega-form with many inputs and many submits. Usually the last value
is valid and therefore something happens with the last listed value.

~~~ html
<table>
  <tr>
    <td>Item 1</td>
    <td>
      <form action="/delete-item" method="post">
        <input type="hidden" id="1">
        <input type="submit" value="Delete">
      <!-- closing tag missing -->
    </td>
  </tr>
  <tr>
    <td>Item 2</td>
    <td>
      <form action="/delete-item" method="post">
        <input type="hidden" id="2">
        <input type="submit" value="Delete">
      <!-- closing tag missing -->
    </td>
  </tr>
  <tr>
    <td>Item 3</td>
    <td>
      <form action="/delete-item?id=3" method="post">
        <input type="hidden" id="3">
        <input type="submit" value="Delete">
      <!-- closing tag missing -->
    </td>
  </tr>
  ...
</table>
~~~

### Buttons around links or vice versa
I know what you are trying to do. You want to have a hyperlink which looks like a button. Than use those
[Bootstrap](/walkthrough-slim/css/bootstrap/) classes directly on that `<a>` element. Same problem as with the forms,
the browser does not know how to react, it registers a click, but button and `<a>` element are both clickable.

~~~ html
<button class="btn btn-primary">
  <a href="/somewhere">A link which looks like a button, button does not work</a>
</button>
~~~

This is the correct way:

~~~ html
<a class="btn btn-primary" href="/somewhere">A link which looks like a button and works in all browsers</a>
~~~

### Multiple buttons inside forms (accidental submit)
The default behaviour of `<button>` element placed inside the form is to submit it. Set the `type` attribute to
`button` and attach some JavaScript functionality.

### Mixed icons and labels
It just looks ugly.

~~~ html
<button class="btn btn-danger">
  <span class="glyphicon glyphicon-thrash">Do not put text here</span> Put the text here
</button>
~~~

## CSS
CSS debugging has much common with HTML debugging. Use developer tools to inspect and modify CSS attributes and values.
CSS syntax is much simpler but still try to avoid syntax errors.

## JavaScript
You can use built-in debugger of your browser to set up breakpoints for JavaScript debugging. You can also use
`console.log()` command to display contents of variables (do not use `alert()`) in the *Console* tab. Always disable
cache for frontend debugging, this option is usually located on the *Network* tab of developer tools.

{: .image-popup}
![Inspector](/articles/debugging/js-debugger.png)

![Inspector](/articles/debugging/cache.png)

## Summary
You will probably not achieve perfect results of rendering in all browsers and perfect behaviour. Nevertheless,
sticking  with web standards will bring the best results in most situations.

### New Concepts and Terms
- developer tools
- live HTML modification
- live CSS modification
- JavaScript debugger