---
title: HTML
permalink: /en/apv/articles/html/
---

* TOC
{:toc}

If you read the [previous article](/en/apv/articles/web/), you should know, what web applications
are and they are created using HTML language. In this article I'm going to 
concentrate more on what HTML is and what is important in it. 

## HTML essentials
A web page must be created using HTML (Hyper Text Markup Language) as that is the language which is understood by
[Web Browsers](todo).
**HyperText** is document which has links to other parts of the same document or 
other documents. Although this may seem normal now, it is quite a revolutionary idea,
because until HyperText was invented, text documents were read in a linear fashion. 

HTML is the most used format of Web pages (documents provided by the WWW service).
It is standardized by [W3C -- WWW Consortium](https://www.w3.org/), latest
HTML version is [HTML5](https://www.w3.org/TR/html5/) finally standardized in 2014.

HTML is not a [programming language](todo), there are no variables, conditions, assignments, 
etc. This makes learning HTML much easier than learning a programming language 
(although it may look cryptic from the beginning). 
HTML language is designed to describe structure of a 
text (or mostly text) document. HTML language is not designed to describe how a text 
document will look, it only describes
structural elements of the document, such as:

- heading
- paragraphs
- links
- images
- tables
- lists
- navigation
- forms

The HTML document is [parsed](todo) (together with [styles](todo)) by an interpreter build in the web browser.
Then it is **rendered** by the browser [rendering engine](todo) on the users' screen. During rendering, the
browser figures out where each part of the document should be displayed, how big it should be
and how it should look and then draws some lines and points on the screen.  

## HTML Language Structure
HTML consists of the following parts:

- [**elements**](https://www.w3.org/TR/html5/dom.html#elements)
- [**attributes**](http://www.w3.org/TR/html5/index.html#attributes-1)
- *entities*
- comments

**Comments** are part of HTML code which is not interpreted (rendered):

{% highlight html %}
<!-- comment may not contain two dashes -->
{% endhighlight %}

Comments can be used to take notes or mark spots in the HTML document. Note
however that they are still visible in the page source code in Web Browser
(use the *View source* function), so do not put any secrets in comments.

### HTML Elements
HTML elements represent parts of the text document. A `p` element
represents a paragraph in text, a `table` elements represents a table, etc.  
HTML elements are organized into a hierarchial structure. A HTML
document is a text document in which this structure is recorded. 
Elements are written down using **tags**:

{% highlight html %}
<p id='intro'>This is an introduction</p>
{% endhighlight %}

The above contains:
 - Element name (enclosed in angle brackets) -- `p`
 - Start tag -- `<p>`
 - End tag -- `</p>`
 - Body -- `This is an introduction`
 - Attribute - `id='intro'`

Each HTML element can have attributes, which describe additional properties of the 
element. Attributes are entered in the start tag in arbitrary order, delimited by space.
The above example contains attribute with:

 - Name -- `id`
 - Value -- `intro`

### Entities 
Apart from elements, HTML can also contain **entities** which are placeholders for 
special characters -- for example `&gt;` (greater than), they begin with ampersand `&`, end with semicolon `;`.
Entities may be encoded as either:

  - Symbolic [character name](http://www.w3.org/TR/html5/named-character-references.html) -- `&gt;` (greater)
  - Numeric Unicode character code references -- `&#62;` or `&#x3E;`

There are two primary reasons for using entities. Either you need to write a character,
which has special meaning in HTML. e.g writing this is incorrect: 

{% highlight html %}
<p>Three is smaller than five: 3 < 5</p>
{% endhighlight %}

Because the `<` character denotes start of tag in HTML, you should write:

{% highlight html %}
<p>Three is smaller than five: 3 &lt; 5</p>
{% endhighlight %}

Other reason for using entities is that you need to write a
[Unicode character](http://unicode-table.com/en/) which you cannot type on keyboard. 
For example `&#10084;` will give you a heart.

### HTML example
A HTML document should begin with `<!DOCTYPE html>` header. This denotes that
it is HTML5 version document. White-space is mostly ignored (there are 
few exceptions like `pre` and `textarea` elements). Which means that HTML
documents are usually formatted to underline the hierarchy of elements: 

{% highlight html %}
<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
        <meta charset="utf-8">
    </head>
    <body id='main'>
        <p>Hello World!</p>
        <ul>
            <li class='first'><p>first item of the list</p></li>
            <li><p>second item of the list</p></li>
        </ul>
    </body>
</html>
{% endhighlight %}

Note that the formatting is fully optional, so the above document is equal to the 
below one: 

{% highlight html %}
<!DOCTYPE html><html><head><title>Page Title</title><meta charset="utf-8">
</head><body id='main'><p>Hello World!</p><ul><li class='first'><p>
first item of the list</p></li><li><p>second item of the list</p></li>
</ul></body></html>
{% endhighlight %}

In the beginning I said, that a HTML document is hierarchial structure of 
HTML elements (tree structure). In the above example, you can see that `<html>` is
**root** element, other elements `<body>` and `<head>` are its **children**.
The element `<head>` is a **sibling** to `<body>`. The `<body>` element
has children `<p>` and `<ul>`. It is very important to recognize this 
hierarchical structure in a HTML document. Also notice that this means, that
the following is not a valid HTML document: 

{% highlight html %}
<p>Text<strong>in Bold</p></strong>
{% endhighlight %}

## HTML Element Properties
There are two basic types of HTML elements:

- **block-level elements** elements -- p, h1, div, …
- **inline elements** -- a, img, span, …

[*Block elements*](https://developer.mozilla.org/en-US/docs/Web/HTML/Block-level_elements) 
represent generic paragraphs, i.e they are blocks 
of text which span the entire line of document. For example a table
cannot be inserted in the middle of a line. *Inline elements* 
are parts of line. Inline elements may be inserted in inline elements 
or block elements. Block elements may be inserted only inside block elements
The exception to this rule is the `a` (link) element, which is 
line element, but block elements may be inserted into it (be careful not to insert any
other active element e.g. ``input`` into ``a``).

All HTML elements have the following 
[common attributes](http://www.w3.org/TR/html5/elements.html#global-attributes):

 - id, class -- used for styling and scripting on client side
 - style -- definition of inline style 
 - title -- hint which is shown on mouse-over
 - data attributes -- arbitrary attributes without semantics. 

## HTML Elements -- Tags
There are some oddities when writing down HTML elements:

- **Empty elements** that have no body -- for example `img` element has no body, because its
content is defined by the image source:

 - `<img src='http://example.com/image.png'>` (valid)
 - `<img src='http://example.com/image.png' />` (also valid)
 - `<img src='http://example.com/image.png'></img>` (also valid but not recommended)

- **Boolean** (true/false) attributes are true when they are present in the tag, they
either have no value at all, or they must have the values equal to their name. If 
you want to set a boolean attribute to false, simple remove it:

 - `<input type='text' required>` (valid, true)
 - `<input type='text' required='required'>` (valid, true)
 - `<input type='text' required='1'>` (invalid, still true)
 - `<input type='text' required='0'>` (completely wrong)
 - `<input type='text' required='false'>` (completely wrong)
 - `<input type='text'>` (valid, false)

### Data attributes 
Data attributes start with the prefix `data-`. Otherwise the name of the attribute
is arbitrary. For example you may write:

{% highlight html %}
<p data-myAttribute='someValue'></p> 
{% endhighlight %}
 
Data attributes are useful for passing arbitrary values to Javascript. However their use
would fall into the advanced category, so you probably won't use them soon. 

## HTML Header
The `head` element contains various information about the page itself, these are commonly 
called **metadata** (data about data in the page). The `head` section is not part of the 
page itself, so do not confuse this with actual page header (with logo, menu, etc.) --
that goes to the `body` element. The `head` element usually contains the following 
children:  
 - `title` -- set page title, used for example in title of the browser window (required)
 - `meta` -- set actual page **metadata** (e.g page description, author, keywords). It is 
 highly recommended to set page encoding with `<meta charset='utf-8' />`. Although web
 browsers mostly default to utf-8 encoding, you want to make sure that the page
 is displayed correctly (even if the user e.g. saves the page to his local drive).  
 - `style` -- [CSS styles](todo) in page
 - `link` -- definition of related files (external style, fonts, etc.)
 - `script` -- Javascript code or link to Javascript code 

### Encoding
It is important to save the page in correct encoding during creation, it has to be the
same encoding which you declare in ``<head>`` section. It is not enough to
put ``<meta charset='utf-8' />`` into ``<head>`` and store the page in ASCII format (or
any other format which your editor is currently set to). The web brorser will display some
characters in a wrong way unless you tell your editor or IDE to save the file in correct
encoding. It is the responsibility of the page's author to make his text editor store
files in correct encoding.

## HTML Standards
The standardization organization for all web related standards is [W3C -- WWW Consortium](https://www.w3.org/)
Current HTML version is [HTML5](https://www.w3.org/TR/html5/) finally standardized in 2014.
Before HTML5, HTML 4.01 was used (and still heavily is), you can recognize HTML4 document by the following
(or similar) beginning:

{% highlight html %}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">   
{% endhighlight %}

HTML4 is a subset of (sometimes called 'an application of') 
[SGML language](https://en.wikipedia.org/wiki/Standard_Generalized_Markup_Language). 
The subset (application) is outlined in a [DTD (Document Type Definition)](https://en.wikipedia.org/wiki/Document_type_definition)
(can you spot it above?). HTML is in fact quite complicated
language, because there is great freedom how things can be written, for example the two documents 
below are equivalent and valid:  
 
{% highlight html %}
<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
        <meta charset="utf-8">
    </head>
    <body id='main'>
        <p>Hello World!</p>
        <ul>
            <li class='first'><p>first item of the list</p></li>
            <li><p>second item of the list</p></li>
        </ul>
    </body>
</html>
{% endhighlight %}

{% highlight html %}
<!DOCTYPE HTML>
<HTML>
    <head>
        <TITLE>Page Title</TITLE>
    </head>
    <BODY ID=main>
        <p>Hello World!
        <UL>
            <LI class=first><P>first item of the list
            <li><P>second item of the list
        </UL>
{% endhighlight %}

As you can see, in HTML lots of code is optional, this was intentional so that 
the language behave *smartly* (e.g. when you end a list, it's clear that the 
list item also ended). 
But this variability made implementations of web browsers quite complicated and in the end also
proved to be somewhat confusing for HTML developers as well and ultimately lead to
development of *XHTML* language, but before I get to that, I need to tell you about XML. 

### XML
Parallel to HTML a [XML (Extensible Markup Language)](https://en.wikipedia.org/wiki/XML) was
born. XML language is a generic language for data description, so its companions are 
e.g. [CSV -- Comma-Separated Values](https://en.wikipedia.org/wiki/Comma-separated_values) for
tabular data or [JSON -- Javascript Object Notation](https://en.wikipedia.org/wiki/JSON) for
any structured data. XML has nothing to do with HTML or structure of text documents.
It does not define any interpretation nor any rendering of the data.

However XML looks similar to HTML because they have the same ancestor (SGML). It 
contains *elements*, *attributes*, *entities* and *comments* just like HTML does.
But it has simplified writing rules: 


 - required header: <?xml version="1.0"?>
 - tag names are lower-case
 - attribute values must be in quotes, value is required
 - start tag and end tag is always required
 - empty tags may be shortened to <element />

XML is a widely used language with many **XML Applications** (interpretation of a XML document, 
not a program), which are again defined using DTD (Document Type Definition). Example of a 
random XML document:

{% highlight xml %}
<?xml version='1.0' encoding='utf-8' ?>
<menu-item>
    <name>category1</name>
    <caption last_modified='1.2.2007'>First category</caption>
    <description />
    <subitems>
        <menu-item>
            <name>category2</name>
            <caption>First Sub-category</caption>
        </menu-item>
        <menu-item>
            <name>category3</name>
            <caption>Next Sub-category</caption>
        </menu-item>
    </subitems>
</menu-item>
{% endhighlight %}

## HTML × XML × XHTML
HTML (at version 4) was complex to write and even more complex to
process by web browsers. To some extend it felt like it was blocking 
further development of the web, because each browser implementation was 
complicated and different. Therefore people made efforts to simplify it.
And one of them was XHTML language. XHTML langauge is an XML application 
of HTML langauge. Which means that it has simple parser (as XML does) 
is faster and contains the same elements as HTML.

Unfortunately a [number of errors arisen with this concept](todo). E.g the 
elements were not exactly the same; the existing pages were broken 
in XML parser (because it is not able to recover in case of error
and simply fails to process the page). Therefore the agile browsers
started to interpret XHTML documents with HTML parser (to which they
seemed malformed as well). An even greater confusion 
occurred, because it was unclear how the browsers interpret different 
documents. To end it all, W3C finally agreed to start all over
with HTML5.

### HTML5
HTML5 is a brand new language which looks like HTML (yes, 3rd one).
It has no relation to SGML, so the `<!DOCTYPE html>` was shortened and
no longer references a DTD. It is a brand new langauge without lot of the 
historic burden (but some if still there) with complicated implementation of 
interpreter in web browser. But it is also backward compatible (allows both HTML and 
XHTML syntax) and finally it is current - developed from 2007, standardized in 2014.
W3C is now working on minor revision.
XHTML is now dead last standard 1.0 from 2000, version 1.1 and 2.0 never completed)

![Various HTML related Standards](/en/apv/slides/html/html-standards.svg)

[//]: <> (TODO obrazek neni, nekde sem ho tusim videl, ale ted nevim)

HTML5 also brought in new features:

- extend semantic elements (`article`, `nav`, `footer`, `menu`, `figure`, …)
- improved user interaction
 - inserting objects into page (video, audio, vector graphics, math)
 - improved form elements (date input, number input, …)
 - validation of forms (different data types, regular expressions, …)
 - spread forms (form elements without containment)
 - data attributes
- removed all visual elements ('font', 'center', 'big', …)
- accessibility improvements -- see [WCAG](https://en.wikipedia.org/wiki/Web_Content_Accessibility_Guidelines)
- extensible with other markup ([MathML](https://en.wikipedia.org/wiki/MathML), 
[SVG](https://en.wikipedia.org/wiki/Scalable_Vector_Graphics))

### Rendering Engines
There are dozens (maybe hundreds) of web browsers available for browsing the web. 
Although there are some clearly major browsers, it would still be very difficult
test your page against all available browsers to verify that the page
is rendered correctly.

![Graph -- Browser Share](/en/apv/slides/html/browsers.png)

[//]: <> (TODO obrazek neni, nedat radsi odkaz na nejakou zivou statisktiku? at to stale neni potreba aktualizovat napr. gs.statcounter.com)
 
Luckily there are in fact not so many browsers as it seems. The important (from HTML point
of view) part of web browser is its rendering (layout) engine and there are only few of those
(sorted by current market-share):

- [Blink](https://en.wikipedia.org/wiki/Blink_(web_engine)) - used in 
[Google Chrome](https://www.google.com/chrome/), and [Opera](http://www.opera.com/) from version 15
- [WebKit](https://en.wikipedia.org/wiki/WebKit) -- used in Safari and other Mac software (e.g. Office for Mac), 
closely related to Blink
- [Gecko](https://en.wikipedia.org/wiki/Gecko_(software)) - used in Firefox browser and all related software from 
[Mozilla](https://www.mozilla.org/en-US/) -- e.g. Thunderbird
- [EdgeHTML](https://en.wikipedia.org/wiki/EdgeHTML) - used in 
[Microsoft Edge](https://www.microsoft.com/en-us/windows/microsoft-edge) and in a lot of Windows software (including latest 
version of MS Office)
- [Trident](https://en.wikipedia.org/wiki/Trident_(layout_engine)) (dead) -- used in Internet Explorer, and older Windows software  
- [Presto](https://en.wikipedia.org/wiki/Presto_(layout_engine)) (dead) -- used in old Opera browsers up to version 12 and mobiles.

There are other [rendering engines](https://en.wikipedia.org/wiki/Comparison_of_web_browser_engines) with 
either negligible marketshare or with use only in legacy applications. This leaves you with 
three to five browsers to test your web pages against (in case you are interested in full compatibility).
The most being *Blink*, *Gecko* and *EdgeHTML*. You can leave out WebKit, because it shares much of it code base
with Blink and you may add *Trident* to verify compatibility with Internet Explorer.

## Writing HTML documents
The HTML document is described by a hierarchial structure of elements and written into a simple text file.
Elements are enclosed by so called **tags**, for example:

{% highlight html %}
<p>This is a paragraph element.</p>
{% endhighlight %}

As you can see, the paragraph element starts by the **opening tag** `<p>`, then
there is the content of the element (actual text of the paragraph) and it is
finished by the **closing tag** `</p>`.

There are over 100 elements available in the HTML language. Most of the HTML elements fall into two categories
**block elements** and **line elements**. Block elements act as paragraphs and cannot be inserted into
lines of text (they always interrupt the text line), line elements may be used anywhere. The tag names
of HTML elements may sometimes
seem cryptic, so here is a list of commonly used ones with a little explanation of their
name (sorted alphabetically):

- `<a>` -- [**A**nchor](https://en.wikipedia.org/wiki/Anchor_text) (i.e. a link within a text) (*line element*)
- `<em>` -- **Em**phasis (*line element*)
- `<strong>` -- **Strong** emphasis (*line element*)
- `<p>` -- **P**aragraph (*block element*)
- `<table>` -- well, a **table** (*block element*)
- `<tr>` -- **T**able **R**ow
- `<th>` -- **T**able **H**ead (table header cell)
- `<td>` -- **T**able **D**ata (ordinary table cell)
- `<img>` -- **Im**a**g**e (*line element*)
- `<ol>` -- **O**rdered **L**ist (*block element*)
- `<ul>` -- **U**nordered **L**ist (enumeration) (*block element*)
- `<li>` -- **L**ist **I**tem (*block element*)
- `<div>` -- **Div**ision (a [generic paragraph](todo)) (*block element*)
- `<span>` -- span [(meaning range)](http://www.merriam-webster.com/dictionary/span) A generic part of line (*line element*)

Any element can have **attributes**. Attributes are some additional information about the
element. A typical example would be the Anchor element, which (apart from the link text)
must contain additional information -- the link target.

{% highlight html %}
<a href='https://youtube.com/'>Youtube</a>
{% endhighlight %}

Attributes must be written in the *opening tag*, they are written in form `name='value'`, each
attribute can be specified only once. In the above example the attribute name is `href` (meaning
[**h**ypertext **ref**erence](todo)) and the value is the actual [URL link](todo) (https://youtube.com/).
The order of attributes in a tag is arbitrary.

Note: you can use either single quotes `'` or double quotes `"` around attribute value, there is
no difference.

### Common Attributes
There is a number of common attributes, it's really good to know about:

- `id` -- A unique identifier of the HTML element within the document (used, e.g in [forms](todo)).
- `class` -- An arbitrary class of the HTML element, used mainly for [CSS styles](todo)).
- `title` -- An arbitrary text which is shown when a user hovers over a HTML element.

### Validation
Because web browsers try to be smart (and because end-users want to see page content), they
will try to display HTML pages even if they contain errors. Such pages **may** or may not
render unexpectedly. Errors in HTML pages are tricky, because you might not notice them
until there are too many of them and the browser rendering engine can't take it any more. 

To prevent this, make sure that your HTML pages are valid by checking them with
[HTML Validator](https://validator.w3.org/). This checks the document against all the 
rules outlined in [HTML specification](https://www.w3.org/html/). A valid HTML document has
a really good chance that it will display the same in all available web browser.
To ease the validation process, you should probably install [some browser extension](todo).

## Summary
In this article I described the principle of HTML language. Contrary to popular belief, HTML
is not just a text document with some tags. It is a document with hierarchial structure
of document elements. You should be aware of the basic properties of HTML language and 
its relations to other languages and standards. You should be also aware of the features 
available in HTML5.

### New Concepts and Terms
- hypertext
- rendering
- element
- entities
- attributes
- tags
- children
- root
- HTML
- XHTML
- XML
- DOCTYPE
- validation
- block element
- line element
