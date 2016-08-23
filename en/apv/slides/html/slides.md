---
layout: slides
title: HTML, CSS and other Web Standards
description: TODO
theme: black
transition: slide
permalink: /en/apv/slides/html/
---

<section markdown='1'>
## HTML
- HyperText Markup Language 
 - **Hypertext** is document interconnected with other documents via links
- The most used format of web pages (documents provided by WWW service)
- Last version of standrd -- HTML5 from 2014
 - https://www.w3.org/TR/html5/
- HTML is language for describing **structure of text document**
- HTML is **not** a programming language
- HTML is interpreted by Web Browsers

</section>

<section markdown='1'>
## Web Browsers 

![Graph -- Browser Share](/en/apv/articles/html/browsers.png)
</section>

<section markdown='1'>
## HTML Structure
- Hierarchical structure of **elements**
 - **parent** - **child** relationship (**siblings** too)
- Elements are written down using **tags**
 - `<h1 id='intro'>Introduction</h1>` 
- Element:
 - Name (enclosed in angle brackets) -- `h1`
 - Start tag -- `<h1>`
 - End tag -- `</h1>`
 - Body -- `Introduction`
 - https://www.w3.org/TR/html5/dom.html#elements

</section>

<section markdown='1'>
## HTML Structure
- `<h1 id='intro'>Introduction</h1>`
- Elements can have **attributes**
 - Additional properties of the element
 - Entered in the start tag in arbitrary order, delimieted by space
 - Name -- `id`
 - Value -- `intro`
 - http://www.w3.org/TR/html5/index.html#attributes-1

</section>

<section markdown='1'>
## HTML Structure 
- **Entities** -- placeholders for special chacaters
 - begin with ampersand `&`, end with semicolon `;`
 - Encoded as either:
  - Symbolic character name -- `&gt;` (greater)
  - Numeric Unicode character code references -- `&#62;` or `&#x3E;`
  - http://www.w3.org/TR/html5/named-character-references.html
- **Comments** -- Part of HTML code which is not interpereted
 - `<!--` comment may not contain two dashes `-->`
 - They are still visible in page source!
- Unless you do something special, then all browsers behave the same

</section>

<section markdown='1'>
## HTML Example
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
            <LI><P>second item of the list
        </UL>
{% endhighlight %}
</section>

<section markdown='1'>
## A Better Example
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
</section>

<section markdown='1'>
## HTML Elements
- **block-level elements** elements -- P, H1, DIV, …
- **inline elements** -- A, IMG, SPAN, …
- inline elements may be inserted in inline elements or block elements
- block elements may be inserted only inside block elements
 - with the exception of A
- common attrbutes;
 - id, class -- used for styling and scripting on client side
 - style -- definition of inline style 
 - title -- hint which is shown on mouse-over
 - others -- http://www.w3.org/TR/html5/elements.html#global-attributes
 - data atrributes -- arbitrary attributes without semantics
- **containment principle** -- related to **page layout** 

</section>

<section markdown='1'>
## HTML Elements -- Tags
- There are some oddities:
 - Empty elements (have no body):
  - `<img src='http://example.com'>` (valid)
  - `<img src='http://example.com' />` (also valid)
  - `<img src='http://example.com'></img>` (also valid but not recommended)
 - Boolean attrbitutes:
  - `<input type='text' required>` (valid)
  - `<input type='text' required='required'>` (valid)
  - `<input type='text' required='1'>` (invalid)
  - `<input type='text' required='0'>` (completely wrong)
  - `<input type='text' required='false'>` (completely wrong)

</section>

<section markdown='1'>
## HTML Header
- The `head` element may contain:
 - `title` -- set page title (required)
 - `meta` -- set page **metadata**, at least encoding:
  - `<meta charset='utf-8' />` (almost required)
 - `style` -- CSS styles in page
 - `link` -- definition of related files (external style, fonts, etc.)
 - `script` -- Javascript code or link to Javascript code 

</section>

<section markdown='1'>
## HTML × XHTML × XML
- XML (Extensible Markup Language) -- generic language for data description
- Looks similar to HTML because of the same ancestor (SGML)
 - contains elements, attributes, entitites
 - does not define interpretation nor rendering of data
- Simplified rules: 
 - required header: <?xml version="1.0"?>
 - tag names are lower-case
 - attribute values must be in quotes, value is required
 - start tag and end tag is always required
 - empty tags may be shortened to <element />
- **XML Application** is an intrepretation of the XML document
 - it is not a program

</section>

<section markdown='1'>
## XML Example
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
</section>

<section markdown='1'>
## HTML × XHTML × XML

![Various HTML related Standards](/en/apv/articles/html/html-standards.png)
</section>

<section markdown='1'>
## HTML × XHTML × XML
- HTML4
 - many optional language elements (langauge was supposed to be smart)
 - complicated implementation of interpreter in web browser
 - semantic elements and visual elements
 - `<!DOCTYPE ` specifices the DTD
- XML
 - faster and more effective processing than HTML
 - simple *parser* implmenetation
- XHTML
 - a XML application of HTML langauge
 - same elements (but unfortunately not exactly)
 - supposedly simplified *interpreter* implementation
 - dead: last standard 1.0 from 2000, version 1.1 and 2.0 never completed)
- HTML5
 - a brand new langauge without lot of historic burden
 - backward compatible (allows both HTML and XHTML syntax)
 - developed from 2007, standardized in 2014
 - not based on SGML
 - complicated implementation of interpreter in web browser

</section>

<section markdown='1'>
## HTML5
- `<!DOCTYPE html>`
- extend semantic elements (`article`, `nav`, `footer`, `menu`, `figure`, …)
- improved user interaction
 - inserting objects into page (video, vector graphics, math)
 - improved form elements (date input, number input, …)
 - validation of forms (diffrent data types, regular expressions, …)
 - spread forms (form elements without containment)
 - data attributes
- removed all visual elements
- accessibilty improvments (WCAG)
- extensible with other markup (MathML, SVG)

</section>

<section markdown='1'>
## Styles
- HTML describes only the **structure** of text document 
 - there is no way to change the visual *rendering*
- To change the rendering of document, **styles** must be used
- CSS (Cascading Style Sheets) is languge for definition of styles
 - CSS is not a programming language
- When no styles are applied, the web browser uses default styles
 - also called **user-agent** styles

</section>

<section markdown='1'>
## CSS Styles
- from CSS3, the standard is split into *modules*
 - various degrees of standardization (earliest 2007)
- various browser tests to determine support:
 - http://www.w3.org/TR/CSS/
 - http://acid3.acidtests.org/
 - http://css3test.com/
 - http://tools.css3.info/selectors-test/test.html
- or http://caniuse.com/
- styles replace depcrated HTML elements like FONT, BASEFONT, BIG, CENTER, S, STRIKE, U, …

</section>

<section markdown='1'>
## CSS Styles
- dozens of modules
 - font properties, color, box properties, box model, effects,
 - border, color, margin, background, …
- **web page is not paper**
 - web page must adapt to (almost) infinite number of window sizes
 - responsive design
 - requires good page layout it HTML as well

</section>

<section markdown='1'>
## CSS Syntax
- CSS document is composed of CSS rules:
 - `selector {property: value;}`
- Example: `body {color: black;}`
 - there is no semicolon after the parentheses
- Selector:
 - element name -- `h1 {color: white}`
 - element class -- `.table_list {width: 100%}` 
 - element id -- `#input_name {width: 40px}`
- Selectors can be combined
- Any number of properties can be set in a single rule

</section>

<section markdown='1'>
## CSS Syntax
- Selector:
 - `li, a` -- for element that is either `<li>` or `<a>`
 - `li a` -- for element `<a>` that is contained in `<li>`
 - `li>a` -- for element `<a>` that is direct child of `<li>`
 - `li.menu` -- for element `<li>` that has clas `menu`
- Pseudo-classes:
 - things which cannot be determined by HTML structure
 - hover, active, focus, link, visited, nth-child, …
 - `li a:visited` -- visited link inside an `li`
 - `li.menu a#prvni:link` -- not visited linke with id `prvni` inside an `li` with class `menu`

</section>

<section markdown='1'>
## Connecting styles with HTML
- External file:
 - `<link rel='stylesheet' type='text/css' href='style.css' />`
 - best solution -- all styles on one place
 - link to HTML element with selectors (element name, class, id)
- Inside HTML page:
 - `<style type='text/css'>body {color: green}; …</style>`
 - used for special pages
 - used to optimize number of HTTP requests
- Inline:
 - `<body style='color: green'>…`
 - (obviously?) without a selector 
 - highest priority, use only for exeptions 

</section>

<section markdown='1'>
## Styles example
{% highlight html %}
<style type="text/css">
    body {color: grey; background: #eeeeee;}
    h3 {background: #cccccc; color: red;}
    .blue {color: blue;}
    #unique {color: white;}
    h3.colored {color: magenta;}
    .black {color: black}
</style>
<body>
    <h3>first</h3>
    <h3 class='blue'>second</h3>
    <h3 id='unique'>third</h3>
    <h3 class='colored'>fourth</h3>
    <h3 class='colored blue'>fifth</h3>
    <h3 class='blue black'>sixth</h3>
</body>
{% endhighlight %}
</section>

<section markdown='1'>
## Cascading Styles
- style properties are inherited from parent elements to child elements
 - the top element is `body` (in rare cases `html`)
 - not all properties are inherited (use common sense)
- all CSS rules are applied in order by priority
 - **closer** and **more specific** rules have higher priority
 - higher priority rules override lower priority rules
 - only properties are overriden, not entire rules  
- inline style > page style > external style
- id > class

</section>

<section markdown='1'>
## CSS Box Model 
- size -- width/height - content + spacing + border
- padding -- inside HTML element -- between content and box
- border -- outside of the HTML element -- around the box
- margin -- outside the HTML element -- around the box
- the size is depending on the **box model**
 - basic types: `inline`, `block` (corresponding with HTML elements)
 - inline is limited by line size
 - block is sized independently 

![Margin & Padding](/en/apv/slides/html/margin-padding.png)
</section>

<section markdown='1'>
## CSS Colors
- on screen, colours are mixed **additively**
- color can be set by
 - name -- `black`, `white`, … (over a hundred)
 - by three RGB components (component intensity 0-255)
  - `color: rgb(255, 0, 0)` (decimal)
  - `color: #FF0000` (hexadecimal)
  - `color: #F00` (shorthand hexadecimal, doubled digits)
  - `color: rgba(255, 0, 0, 0.5)` (with **alpha channel**)
 - by three HSL components
  - `color: hsl(0, 100%, 50%)` 
  - `color: hsla(0, 100%, 50%, 0.5)` (with **alpha channel**)

</section>

<section markdown='1'>
## CSS Layouts
- creating a full page layout is non-trivial task
- layouts for web pages and for web applications are completely different
- use existing layouts, e.g.:
 - Bootstrap (http://getbootstrap.com/)
 - Foundation (http://foundation.zurb.com/)
 - Skeleton (http://getskeleton.com/)
 - SemanticUI (http://semantic-ui.com/)
- complicated layouts use alternatives to CSS (LESS, SASS)
 - must be compiled to CSS for web browsers

</section>

<section markdown='1'>
## Sources
- Always check the data and author
 - many sources are outdated or plain wrong
- www.w3.org/community/webed/wiki/
- https://developer.mozilla.org/en-US/docs/Web
- https://developers.google.com/university/
- http://www.w3c.org

</section>

<section markdown='1'>
## Checkpoint
- Why mustn't the HTML start tag and end tag cross?
- What happens if HTML documents lacks a `<!DOCTYPE`?
- Can you have delete icon on page without using an image?
- What does XML and HTML have in common? 
- Why is CSS3 not standardized yet?
- Who says that `<title>` must not occur twice in a HTML document?
- Is it better to draw a border using CSS or use an PNG image?
- What does HTML4 and HTML5 have in common?

</section>
