---
title: HTML 
permalink: /en/apv/walkthrough/html/
---

* TOC
{:toc}

A static [web page](/en/apv/articles/web/#www-service) is a page which must be modified by the 
page developer. For example, this site 
is a static page. Static pages are generally boring, but they are a necessary step to get into the fun
stuff -- [dynamic pages](http://odinuv.cz/en/apv/walkthrough/dynamic-page/). In this chapter, you will learn to write 
[HTML documents](/en/apv/articles/html/).

## Getting started
Open you [favorite editor](todo) and create a new HTML file. If the editor is nice to you, it will
automatically create a template for you. If not, here is one:

{% highlight html %}
{% include /en/apv/walkthrough/html/1-bare.html %}
{% endhighlight %}

This is a minimal valid HTML document. Notice that the elements are hierarchically organized. The
element `title` is contained **inside** the element `head`, which is contained **inside** element
`html`. The whitespace is mostly ignored in HTML, so the elements can be indented as they are nested
(the indentation is not required, it just improves readability).

### Task -- Basics
Add a paragraph inside the `body` element. The paragraph text should be "Kill a lot of time", the word "Kill" should
be a link to `https://www.youtube.com`.

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html/2-task-basics.html %}
{% endhighlight %}

Open the page in your editor preview or in your favorite web browser and you should see an output similar to this.
Note: there is no need to upload the page to a web site, since the page is static (static pages are boring, but easy)

{: .image-popup}
![Screenshot -- Page sample](/en/apv/walkthrough/html/static-1.png)

### Task -- Examine HTML
Open web browser [Developer Tools](todo) and examine the structure of the HTML page. Can you see that
elements are organized hierarchically? Can you spot attributes?

{: .solution}
{: .image-popup}
![Screenshot -- HTML structure](/en/apv/walkthrough/html/static-dev.png)

{: .solution}
    There is attribute `charset` in element `meta`, the attribute has value `utf8`. Then there
    is attribute `href` which you have written yourselves.

### Task -- Tables
The following additional rules apply to creating tables:
- everything in a table must be in a table cell
- a table cell must be in a table row
- a table row must be in a table

Create a table like this in HTML:

| First | Second | Third |
|-------|--------|-------|
| a     | b      | c     |
| quick | brown  | fox   |

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html/3-table-intro.html %}
{% endhighlight %}

### Task -- Playing with task cells 1
It is sometimes necessary to have tables with joined cells. To join table cells, use
attributes `colspan` (span a cell over columns) and `rowspan` (span a cell over rows).
The value of the attribute is the number of cells the joined cells should occupy.
Tip: use attribute `border` on `table` to get a clear view of table cells. Allowed attribute values are
0 (no borders), 1 (borders).

Given this table:
{% highlight html %}
{% include /en/apv/walkthrough/html/4-table-merge-task.html %}
{% endhighlight %}

Join the two cells **12** and **13**. Then join the cells **23** and **33**. To achieve a
table like this:

![Table Screenshot](/en/apv/walkthrough/html/table-merged-1.png)

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html/5-table-merge-sol-1.html %}
{% endhighlight %}

Notice that you have to *delete* the appropriate cells, because the table now
contains less cells than before. This might become very confusing when looking on a large HTML table, because
it may be missing some columns -- in the example above, the third row seems to have only three columns.

### Task -- Playing with table cells 2
Now as an exercise, create a table like this:

![Table Screenshot](/en/apv/walkthrough/html/table-merged-2.png)

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html/6-table-merge-sol-2.html %}
{% endhighlight %}


### Task -- Lists
There are two types of lists -- ordered lists (numbered) and
un-ordered lists (enumerations). They behave the same and they can be mixed together. The
basic rule, that applies for lists is that, everything contained in a list must be inside
in `li` elements.

Create a ordered list with 3 items:

1. Good
2. Bad
3. Ugly

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html/7-lists-sol-1.html %}
{% endhighlight %}

### Task -- Lists 2
Now try to create a nested list like this (remember that everything in a list must
be inside an `li` element):

1. Good
    - empire
    - magazine
    - time
2. Bad
    - day
    - ice cream
    - Schandau
3. Ugly
    - gifs

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html/8-lists-sol-2.html %}
{% endhighlight %}

## Putting it all together
HTML elements may be nested and combined. Now try to create an entire page like this:

We used:

- The text from Wikipedia article at [https://en.wikipedia.org/wiki/John_Doe](https://en.wikipedia.org/wiki/John_Doe)
- Image from [http://www.johndoe.pro/img/John_Doe.jpg](http://www.johndoe.pro/img/John_Doe.jpg)
- HTML elements: `h1`, `h2`, `table`, `ul`, `src`, `a`, `nav` (as a container for navigation)

{: .solution}
{% highlight html %}
{% include /en/apv/walkthrough/html/9-all.html %}
{% endhighlight %}

Note that the `img` element does not have any content (content is defined by the `src` attribute)
so instead of writing start and end tags `<img src='...'></img>`, it is written with
just the start tag `<img src='...' />`. This can get a 
[lot more complicated](http://odinuv.cz/en/apv/articles/html/#html-elements----tags).

The page does not look like the nice best page in the world, but it will get much better, once you
get to [layout and styles](todo) because HTML language does not have the means to format and
style a document. Do not attempt to style a web page using the HTML language.
E.g. never use a second `h2` or third level `h3` heading instead of first level heading
`h`` just to get smaller font size. The structure of the document must be used irrespective of
the looks of the document. Adjusting font size and many other things is done through
[Style Sheets](todo), which we will get to later.

### Publishing your page
A webpage needs to be placed on a webserver. That is a computer which is constantly connected to the Internet.
This computer has usually a hostname (something like www.myawesomepage.com) so you and others do not have to
remember the IP address of that machine. Other people (visitors) can connect co that computer and download your page and
referenced files (images and other stuff) when you upload it - remember to upload new versions.
You can usually upload your page by using an [FTP](todo) client or [SSH](todo) client.

You definitely noticed that web servers open some default page when you visit them (you do not have to write filename into
your browser's address bar - www.myawesomepage.com/file.html). Such behavior is achieved by naming convention - that default
file is usually named ``index.html`` or ``index.php``.

Important note is that server is another computer which usually runs some Linux OS. This means that absolute paths are
different and case sensitive - when creating a web page locally on your PC, use **relative paths** and be precise with **case of letters**.

## Summary
You should now be able to describe structure of any text document using HTML language. The document is
still formatted poorly, we will get to that later. The documents you produce now are formated with some
default formats build into your web browser. Do not worry, that you might not be able to create complex
pages right now, you need to know the principles and be able to create simple pages.

### New Concepts and Terms
- HTML tables
- HTML lists
