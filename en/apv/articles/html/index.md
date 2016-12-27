---
title: HTML
permalink: /en/apv/articles/html/
---

* TOC
{:toc}

If you read the [previous article](/en/apv/articles/web/), you should know what web applications
are and that they are created using the HTML language. In this article I'm going to
concentrate more on what HTML is and what is important in it.

## HTML essentials
A web page must be created using HTML (Hyper Text Markup Language) as that is the language which is understood by
[Web Browsers](/en/apv/articles/web/#www-service).
**HyperText** is a document which has links to other parts of the same document or
other documents. Although this may seem normal now, it was quite a revolutionary idea,
because until HyperText's invention, text documents were read in a linear fashion.

HTML is the most used format of Web pages (documents provided by the WWW service).
It is standardized by [W3C -- WWW Consortium](https://www.w3.org/), the latest
HTML version is [HTML5](https://www.w3.org/TR/html5/) finally standardized in 2014.

HTML is not a [programming language](/en/apv/articles/programming/#programming-for-dummies),
there are no variables, conditions, assignments,
etc. This makes learning HTML much easier than learning a programming language
(although it may look cryptic from the beginning).
HTML language is designed to describe the structure of a
text (or mostly text) document. The HTML language is not designed to describe how a text
document will look, it only describes structural elements of the document, such as:

- heading
- paragraphs
- links
- images
- tables
- lists
- navigation
- forms

An HTML document is [parsed](/en/apv/articles/programming/#source-code)
(together with [styles](/en/apv/walkthrough/css/)) by an interpreter built in the web browser.
Then it is **rendered** by the
browser [rendering engine](/en/apv/articles/html/#rendering-engines) on
the users' screen. During rendering, the
browser figures out where each part of the document should be displayed, how big it should be
and how it should look and then draws some lines and points on the screen.

## HTML Language Structure
HTML language consists of the following parts:

- [**elements**](https://www.w3.org/TR/html5/dom.html#elements)
- [**attributes**](http://www.w3.org/TR/html5/index.html#attributes-1)
- [**entities**](https://www.w3.org/TR/html5/syntax.html#named-character-references)
- comments

**Comments** are a part of the HTML code which is not interpreted (rendered):

{% highlight html %}
<!-- comment may not contain two dashes -->
{% endhighlight %}

Comments can be used to take notes or mark spots in the HTML document. Note
however that they are still visible in the page source code in a web browser
(use the *View source* function), so do not put any secrets in HTML comments.

### HTML Elements
HTML elements represent parts of a text document. A `p` element
represents a paragraph in a text, a `table` elements represents a table, etc.
HTML elements are organized into a hierarchial structure. A HTML
document is a text document in which this structure is recorded.
Elements are written down using **tags**:

{% highlight html %}
<p id='intro'>This is an introduction</p>
{% endhighlight %}

The above contains:

 - Element name (enclosed in angle brackets `<` and `>`) -- `p`,
 - Start tag (opening tag) -- `<p>`,
 - End tag -- `</p>`,
 - Element content (element body) -- `This is an introduction`,
 - Attribute -- `id='intro'`.

Each HTML element can have **attributes**, which describe additional properties of the
element. Attributes are entered in the start tag in arbitrary order, delimited by space.
The above example contains one attribute with:

 - name -- `id`,
 - value -- `intro`.

### Entities
Apart from elements, HTML can also contain **entities** which are placeholders for
special characters -- for example `&gt;` represents the character `>` (**g**reater **t**han).
Entities begin with ampersand `&`, end with semicolon `;`, they may be encoded as either:

  - symbolic [character name](http://www.w3.org/TR/html5/named-character-references.html) -- `&gt;`,
  - numeric [Unicode character code](https://en.wikipedia.org/wiki/Unicode) references -- `&#62;`
    (decimal) or `&#x3E;` ([hexadecimal](https://en.wikipedia.org/wiki/Hexadecimal)).

There are two primary reasons for using entities. One reason is that you need to write a character
which has a special meaning in HTML. e.g writing this is incorrect:

{% highlight html %}
<p>Three is smaller than five: 3 < 5</p>
{% endhighlight %}

Because the `<` character denotes the start of tag in HTML, you should write:

{% highlight html %}
<p>Three is smaller than five: 3 &lt; 5</p>
{% endhighlight %}

The web browser will take care of [rendering](#rendering-engines) the entity as the correct character.
Another reason for using entities is that you need to write a
[Unicode character](http://unicode-table.com/en/) which you cannot type on the keyboard.
For example `&#10084;` will give you a heart.

## Writing HTML documents
An HTML document should begin with `<!DOCTYPE html>` header. This denotes that
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

{: .note}
<div markdown='1'>
The formatting is fully optional, so the above document is equal to the
below one:

{% highlight html %}
<!DOCTYPE html><html><head><title>Page Title</title><meta charset="utf-8">
</head><body id='main'><p>Hello World!</p><ul><li class='first'><p>
first item of the list</p></li><li><p>second item of the list</p></li>
</ul></body></html>
{% endhighlight %}
</div>

### Hierarchical Structure
Let us have a look at a sample HTML document:

{% highlight html %}
{% include /en/apv/articles/sample-page.html %}
{% endhighlight %}

If you display the above HTML source document in your browser, you will see
a simple page:

![Screenshot - Sample document](/en/apv/articles/html/sample-page-3.png)

In the beginning I said, that a HTML document is a hierarchial structure
[(tree structure)](https://en.wikipedia.org/wiki/Tree_(graph_theory)) of HTML elements.
In the above example, you can see that `<html>` is
a **root** element, other elements `<body>` and `<head>` are its **children**.
The element `<head>` is a **sibling** to `<body>`. The `<body>` element
has children `<div>`, `<div>` and `<footer>`. It is very important to recognize this
hierarchical structure shown in the below image:

{: .image-popup}
![Hierarchical HTML](/en/apv/walkthrough/css/html.svg)

Notice that the hierarchical structure of HTML means that the following is not a valid HTML document:

{% highlight html %}
<p>Text<strong>in Bold</p></strong>
{% endhighlight %}

It is important to understand HTML document as this hierarchical structure. It will become
more and more important when dealing with [stylesheets](todo) or [Javascript code](todo).

### Common Elements
There are over 100 elements available in the HTML language. The tag names
of HTML elements may sometimes
seem cryptic, so here is a list of commonly used ones with a little explanation of their
names (sorted alphabetically):

- `<a>` -- [**A**nchor](https://en.wikipedia.org/wiki/Anchor_text) (i.e. a link within a text) (*line element*),
- `<em>` -- **Em**phasis (*line element*),
- `<strong>` -- **Strong** emphasis (*line element*),
- `<p>` -- **P**aragraph (*block element*),
- `<table>` -- well, a **table** (*block element*),
- `<tr>` -- **T**able **R**ow,
- `<th>` -- **T**able **H**ead (table header cell),
- `<td>` -- **T**able **D**ata (ordinary table cell),
- `<img>` -- **Im**a**g**e (*line element*),
- `<ol>` -- **O**rdered **L**ist (*block element*),
- `<ul>` -- **U**nordered **L**ist (enumeration) (*block element*),
- `<li>` -- **L**ist **I**tem (*block element*),
- `<div>` -- **Div**ision (a [generic paragraph](https://www.w3.org/TR/html5/grouping-content.html#the-div-element)) (*block element*),
- `<span>` -- Span [(meaning range)](http://www.merriam-webster.com/dictionary/span) A generic part of line (*line element*).

There are many more HTML elements, but not worry, you'll learn them along the way.
There are two basic types of HTML elements:

- **block-level elements** elements -- p, h1, div, …
- **inline elements** -- a, img, span, …

[*Block elements*](https://developer.mozilla.org/en-US/docs/Web/HTML/Block-level_elements)
represent generic paragraphs, i.e. they are blocks
of a text which span the entire line of the document (in other words -- they always start a new text line).
For example a table cannot be inserted in the middle of a line. *Inline elements*
are parts of line. Inline elements may be inserted in inline elements
or block elements. Block elements may be inserted only inside other block elements
The exception to this rule is the `a` (link) element, which is
line element, but block elements may be inserted into it. Be careful not to insert any
other *active* (clickable) element (e.g. `input`) as a child of `a`). Such combination of
elements [is forbidden](http://stackoverflow.com/questions/6393827/can-i-nest-a-button-element-inside-an-a-using-html5).

### Common Attributes
Any element can have **attributes**. Attributes contain some additional information about the
element. A typical example would be the Anchor element, which (apart from the link text)
must contain additional information -- the link target.

{% highlight html %}
<a href='https://youtube.com/'>Youtube</a>
{% endhighlight %}

Attributes must be written in the *opening tag*, they are written in form `name='value'`, each
attribute can be specified only once. In the above example the attribute name is `href` (meaning
[**h**ypertext **ref**erence](https://www.w3.org/TR/2014/REC-html5-20141028/links.html#links))
and the value is the actual [URL link](https://url.spec.whatwg.org/) (https://youtube.com/).
The order of attributes in a tag is arbitrary.

{: .note}
You can use either single quotes `'` or double quotes `"` around an attribute value, there is
no difference in HTML.

Another example would be an image which requires two attributes -- `src` for the image **source**
and `alt` for an **alt**ernative text (used when image cannot be displayed):

{% highlight html %}
<img src='https://www.w3.org/html/logo/downloads/HTML5_Logo_512.png' alt='HTML5 logo'>
{% endhighlight %}

{: .note}
The image element can have no other content apart the image itself. Instead of writing
`<img src...></img>` it is shortened to only the start tag ([see below](#tags) for lengthy explanation).

There is a number of [common attributes](http://www.w3.org/TR/html5/elements.html#global-attributes),
it's really good to know about:

- `id` -- Unique identifier of the HTML element within the document (used,
e.g. in [forms](http://localhost:4000/en/apv/walkthrough/html-forms/) and [CSS styles](todo));
- `class` -- Arbitrary class of the HTML element, used mainly for [CSS styles](todo));
- `title` -- Arbitrary text which is shown when a user hovers over a HTML element;
- `style` -- Definition of an [inline style](todo);
- [data attributes](/en/apv/articles/html/#data-attributes).

### Tags
There are some oddities when writing down HTML elements:

**Empty elements** are elements that have no body -- for example `img` element has no body, because its
content is defined by the image source. For empty elements the end tag is omitted:

- `<img src='http://example.com/image.png'>` (valid)
- `<img src='http://example.com/image.png' />` (also valid)
- `<img src='http://example.com/image.png'></img>` (also valid but not recommended)

[**Boolean** (true/false)](/en/apv/articles/programming/#type-system) attributes are true when they
are present in the tag. They either have no value at all, or they must have the value equal to their name. If
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

Data attributes are useful for passing arbitrary values to [JavaScript](/en/apv/walkthrough/javascript/).
However their use would fall into the advanced category, so you probably won't use them soon.

### HTML Header
The `head` element contains various information about the page itself, these are commonly
called **metadata** (data about data in the page). The `head` section is not part of the
page itself, so do not confuse this with the actual page header (with logo, menu, etc.) --
that goes to the `body` element. The `head` element usually contains the following
children:

- `title` -- set a page title, used for example in the title of the browser window (required)
- `meta` -- set actual page **metadata** (e.g. encoding (see below), page description, author, keywords).
 - `style` -- [CSS styles](/en/apv/walkthrough/css/) in page
- `link` -- definition of related files (external style, fonts, etc.)
- `script` -- [JavaScript](/en/apv/walkthrough/javascript/) code or link to [JavaScript](/en/apv/walkthrough/javascript/) code

#### Encoding
It is highly recommended to set page encoding with `<meta charset='utf-8' />`. Although web
browsers mostly default to utf-8 encoding, you want to make sure that the page
is displayed correctly (even if the user e.g. saves the page to his local drive).

It is also important to save the source code in correct encoding ([utf-8](https://en.wikipedia.org/wiki/Utf-8))
during creation. It has to be the same encoding which you declare in `<head>` section. It is not enough to
put `<meta charset='utf-8' />` into `<head>` and store the source code in
[ASCII encoding](https://en.wikipedia.org/wiki/Extended_ASCII). The web browser may display some
characters incorrectly until you set your editor save the file in correct encoding.

### Validation
Because web browsers try to be smart (and because end-users want to see the page content), they
will try to display HTML pages even if they contain errors. Such pages **may** or may not
render unexpectedly. Errors in HTML pages are tricky, because you might not notice them
until there are too many of them and the browser
[rendering engine](#rendering-engines) can't take it any more.

To prevent this, make sure that your HTML pages are valid by checking them with
the [HTML Validator](https://validator.w3.org/). This checks the document against all the
rules outlined in the [HTML specification](https://www.w3.org/html/). A valid HTML document has
a really good chance that it will display the same in all available web browsers.
To ease the validation process, you should probably install [some browser extension](todo).

## HTML Standards
The standardization organization for all web related standards is [W3C -- WWW Consortium](https://www.w3.org/)
Current HTML version is [HTML5](https://www.w3.org/TR/html5/) finally standardized in 2014
(with minor revision 5.1 standardized in 2016).
The previous version -- HTML 4.01 is still used, you can recognize HTML4 document by the following
(or similar) beginning:

{% highlight html %}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
{% endhighlight %}

HTML4 is a subset of (sometimes called 'an application of') the
[SGML language](https://en.wikipedia.org/wiki/Standard_Generalized_Markup_Language).
The subset (application) is outlined in a [DTD (Document Type Definition)](https://en.wikipedia.org/wiki/Document_type_definition)
(can you spot it above?). HTML is in fact a quite complicated
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

As you can see, in HTML lots of the code is optional, this was intentional so that
the language behaves *smartly* (e.g. when you end a list, it's clear that the
list item is also ended).
But this variability made implementations of web browsers quite complicated and in the end also
proved to be somewhat confusing for HTML developers as well and ultimately lead to
development of the *XHTML* language, but before I get to that, I need to tell you about XML.

### XML
Parallel to HTML an [XML (Extensible Markup Language)](https://en.wikipedia.org/wiki/XML) was
born. The XML language is a generic language for data description, so its companions are
e.g. [CSV -- Comma-Separated Values](https://en.wikipedia.org/wiki/Comma-separated_values) for
tabular data or [JSON -- JavaScript Object Notation](https://en.wikipedia.org/wiki/JSON) for
any structured data. XML has nothing to do with HTML or structure of text documents.
It does not define any interpretation nor any rendering of the data.

However XML looks similar to HTML4 because they both have the same ancestor (SGML). It
contains *elements*, *attributes*, *entities* and *comments* just like HTML does.
But it has simplified writing rules:

 - required header: `<?xml version="1.0"?>`
 - tag names are lower-case
 - attribute values must be in quotes, value is required
 - start tag and end tag is always required
 - empty tags may be shortened to `<element />`

XML is a widely used language with many **XML Applications** (here 'application' means interpretation of a XML document,
not a program), which are again defined using DTD (Document Type Definition). An example of a
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

### HTML × XML × XHTML
HTML (at version 4) was complex to write and even more complex to
process by web browsers. To some extend it felt like it was blocking
further development of the web, because each browser implementation was
complicated and different. Therefore people made efforts to simplify it.
And one of them was the XHTML language. The XHTML language is an XML application
of the HTML language. Which means that it has a simple parser (as XML does),
is faster and contains the same elements as HTML.

Unfortunately a [number of errors have arisen with this concept](https://en.wikipedia.org/wiki/XHTML#Criticism). E.g. the
elements were not exactly the same; the existing pages were broken
in the XML parser (because it is not able to recover in case of an error
and simply fails to process the page). Therefore the agile browsers
started to interpret XHTML documents with a HTML parser (to which they
seemed malformed as well). Even greater confusion
occurred, because it was unclear how the browsers interpret different
documents. To end it all, W3C finally agreed to start all over
with HTML5.

### HTML5
HTML5 is a brand new language which looks like HTML (yes, 3rd one).
It has no relation to SGML, so the `<!DOCTYPE html>` was shortened and
no longer references a DTD. It is a new language without lot of the
historic burden (but some of it is still there) with complicated implementation of
the interpreter in a web browser. But it is also backward compatible (allows both HTML and
XHTML syntax) and finally it is current -- developed from 2007, standardized in 2014 with
a minor revision 5.1 standardized in 2016.

{: .image-popup}
![Various HTML related Standards](/en/apv/articles/html/html-standards.svg)

HTML5 also brought in new features:

- extend semantic elements (`article`, `nav`, `footer`, `menu`, `figure`, …)
- improved user interaction
    - inserting objects into the page (video, audio, vector graphics, math)
    - improved form elements (date input, number input, …)
    - validation of forms (different data types, regular expressions, …)
    - spread forms (form elements without containment)
    - data attributes
- removed all visual elements (`font`, `center`, `big`, …)
- accessibility improvements -- see [WCAG](https://en.wikipedia.org/wiki/Web_Content_Accessibility_Guidelines)
- extensible with other markup ([MathML](https://en.wikipedia.org/wiki/MathML),
[SVG](https://en.wikipedia.org/wiki/Scalable_Vector_Graphics))

HTML5 standard describes the HTML language itself. The most important
part of that is the allowed hierarchy of elements and their attributes. Apart from that, the standard
describes main representations of HTML:

- HTML markup language for writing HTML into text documents,
- XHTML language (an application of XML) for writing HTML into text documents (also called XML syntax of HTML),
- HTML Document Object Model for representing HTML in web browser memory.

The three representations are [not entirely equivalent](https://www.w3.org/TR/2016/REC-html51-20161101/introduction.html#html-vs-xhtml)
but for most practical work you don't need to worry to o much about this. I suggest
you use the HTML markup language over the XHTML markup language. If you use the XHTML langauge, you
have to set [MIME type](https://en.wikipedia.org/wiki/Media_type) to `application/xhtml+xml`
and be prepared that a malformed document won't be displayed.

### Rendering Engines
There are dozens (maybe hundreds) of web browsers available for browsing the web.
Although there are some clearly major browsers, it would still be very difficult
to test your page against all available browsers to verify that the page
is rendered correctly.

<div id="browser-ww-monthly-200807-201612" style="width:600px; height: 400px;"></div>
<p>Source: <a href="http://gs.statcounter.com/#browser-ww-monthly-200807-201612">StatCounter Global Stats - Browser Market Share</a></p>
<script type="text/javascript" src="http://www.statcounter.com/js/fusioncharts.js"></script>
<script type="text/javascript" src="http://gs.statcounter.com/chart.php?browser-ww-monthly-200807-201612"></script>

Luckily there are in fact not so many browsers as it seems. The important (from the HTML point
of view) part of a web browser is its *rendering engine* (also called *layout engine*) and there are only few of those
(sorted by current market-share):

- [Blink](https://en.wikipedia.org/wiki/Blink_(web_engine)) -- Used in
[Google Chrome](https://www.google.com/chrome/), and [Opera](http://www.opera.com/) from version 15.
- [WebKit](https://en.wikipedia.org/wiki/WebKit) -- Used in Safari and other Mac software (e.g. Office for Mac),
closely related to Blink.
- [Gecko](https://en.wikipedia.org/wiki/Gecko_(software)) --Used in Firefox browser and all related software from
[Mozilla](https://www.mozilla.org/en-US/) -- e.g. Thunderbird.
- [EdgeHTML](https://en.wikipedia.org/wiki/EdgeHTML) -- Used in
[Microsoft Edge](https://www.microsoft.com/en-us/windows/microsoft-edge) and in a lot of Windows software (including latest
version of MS Office).
- [Trident](https://en.wikipedia.org/wiki/Trident_(layout_engine)) (dead) -- Used in the Internet Explorer, and older Windows software.
- [Presto](https://en.wikipedia.org/wiki/Presto_(layout_engine)) (dead) -- Used in old Opera browsers up to version 12 and mobiles.

There are other [rendering engines](https://en.wikipedia.org/wiki/Comparison_of_web_browser_engines) with
either negligible market-share or with use only in legacy applications. This leaves you with
three to five browsers to test your web pages against (in case you are interested in full compatibility).
The most important being *Blink*, *Gecko* and *EdgeHTML*. You can leave out WebKit, because it shares much of its code base
with Blink and you may add *Trident* to verify compatibility with the Internet Explorer.

## Summary
In this article I described the principles of HTML language. Contrary to popular belief, HTML
is not just a text document with some tags. It is a document with hierarchial structure
of document elements. You should be aware of the basic properties of HTML language and
its relations to other languages and standards. You should be also aware of the features
available in HTML5. Feel free to go through the [corresponding exercises](/en/apv/walkthrough/html/)
to get yourself acquainted with HTML.

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
- metadata
- encoding
- XML application
- rendering engine (layout engine)
