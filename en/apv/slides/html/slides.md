---
layout: slides
title: HTML, CSS and other Web Standards
description: Overview of HTML language, a little excursion into its history and introduction to CSS language.
transition: slide
permalink: /en/apv/slides/html/
---

<section markdown='1'>
## HTML
- HyperText Markup Language:
    - **Hypertext** is a document interconnected with other documents via links.
- The most used format of web pages (documents provided by WWW service).
- The last version of the standard -- HTML5 from 2014 -- [W3C Specification](https://www.w3.org/TR/html5/).
- HTML is a language for describing the **structure of a text document**.
- HTML is **not** a programming language.
- HTML is interpreted by Web Browsers.

</section>

<section markdown='1'>
## Web Browsers

![Graph -- Browser Share](/en/apv/articles/html/browsers.png)
</section>

<section markdown='1'>
## HTML Structure
- Hierarchical structure of **elements**:
    - **parent** -- **child** relationship (**siblings** too).
- Elements are written down using **tags**:
    - `<h1 id='intro'>Introduction</h1>`
- Element:
    - Name (enclosed in angle brackets) -- `h1`,
    - Start tag -- `<h1>`,
    - End tag -- `</h1>`,
    - Body -- `Introduction`,
    - [W3C Specification](https://www.w3.org/TR/html5/dom.html#elements).

</section>

<section markdown='1'>
## HTML Structure
- `<h1 id='intro'>Introduction</h1>`
- Elements can have **attributes**:
    - Additional properties of the element,
    - Entered in the start tag in arbitrary order (delimited by space),
    - Name -- `id`,
    - Value -- `intro`,
    - [W3C Specification](http://www.w3.org/TR/html5/index.html#attributes-1).

</section>

<section markdown='1'>
## HTML Structure
- **Entities** -- placeholders for special characters:
    - Begin with the ampersand `&`, end with the semicolon `;`,
    - Encoded as:
        - a symbolic character name -- `&gt;` (greater) -- defined in
        [W3C Specification](http://w3c.github.io/html/syntax.html#named-character-references),
        - or a numeric Unicode character code reference -- `&#62;` or `&#x3E;`,
- **Comments** -- a part of the HTML code which is not interpreted:
    - `<!--` a comment may not contain two dashes `-->`,
    - They are still visible in the page source!
- Unless you do something special, all browsers generally do behave the same way.

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
            <LI class=main><P>First!
            <LI><P>second list item
        </UL>
{% endhighlight %}
</section>

<section markdown='1'>
## Better HTML Example
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
            <li class='main'><p>First!</p></li>
            <li><p>second list item</p></li>
        </ul>
    </body>
</html>
{% endhighlight %}
</section>

<section markdown='1'>
## HTML Elements
- **Block-level elements** -- P, H1, DIV, …
- **Inline elements** -- A, IMG, SPAN, …
- Inline elements may be inserted in inline elements or block elements.
- Block elements may be inserted only inside block elements.
    - With the exception of A.

</section>

<section markdown='1'>
## HTML Attributes
- Common attributes:
    - id, class -- used for styling and scripting on the client side,
    - style -- definition of an inline style,
    - title -- hint which is shown on mouse-over,
    - others -- http://www.w3.org/TR/html5/elements.html#global-attributes,
    - data attributes -- arbitrary attributes without semantics.
- **Containment principle** -- related to the **page layout**.

</section>

<section markdown='1'>
## HTML Elements -- Oddities
- Empty elements (have no body):
    - `<img src='http://example.com'>` -- valid,
    - `<img src='http://example.com' />` -- also valid,
    - `<img src='http://example.com'></img>` -- also valid but not recommended.

</section>

<section markdown='1'>
## HTML Elements -- Oddities
- Boolean attributes:
    - `<input type='text' required>` -- valid True,
    - `<input type='text' required='required'>` -- valid True,
    - `<input type='text' required='1'>` -- invalid True,
    - `<input type='text' required='0'>` -- completely wrong,
    - `<input type='text' required='false'>` -- completely wrong,
    - `<input type='text'>` -- valid False.

</section>

<section markdown='1'>
## HTML Header
- a `head` element may contain:
    - `title` -- set page title (required),
    - `meta` -- set page **metadata**, at least encoding:
        - `<meta charset='utf-8' />` (almost required)
    - `style` -- CSS styles in the page,
    - `link` -- a definition of related files (external style, fonts, etc.),
    - `script` -- a JavaScript code or a link to a JavaScript code.

</section>

<section markdown='1'>
## HTML × XHTML × XML
- XML (Extensible Markup Language) -- a generic language for data description.
- Looks similar to HTML -- the same ancestor (SGML):
    - contains elements, attributes, entities,
    - does not define interpretation or rendering of data.
- Simplified rules:
    - required header: `<?xml version="1.0"?>`,
    - a tag name is lower-case, the end tag is required
    - an attribute value must be in quotes, a value is required,
    - an empty tag may be shortened to `<element />`,
- An **XML Application** is an interpretation of the XML document (not a program).

</section>

<section markdown='1'>
## XML Example
{% highlight xml %}
<?xml version='1.0' encoding='utf-8' ?>
<menu-item>
    <name last_modified='1.2.2007'>category1</name>
    <caption>First category</caption>
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

![Various HTML related Standards](/en/apv/articles/html/html-standards.svg)
</section>

<section markdown='1'>
## HTML × XHTML × XML
- HTML4 has:
    - many optional language elements (the language was supposed to be smart),
    - complicated implementation of an interpreter in a web browser,
    - semantic elements and visual elements,
    - `<!DOCTYPE ` that specifies the DTD.
- XML has:
    - faster and more effective processing than HTML,
    - simple *parser* implementation.
    - no error recovery
</section>

<section markdown='1'>
## HTML × XHTML × XML Cont.
- XHTML:
    - is an XML application of the HTML language,
    - has supposedly simplified *interpreter* implementation,
    - has no error recovery if transmitted as `application/xhtml+xml`,
- HTML5:
    - is a brand new language without a lot of historic burden,
    - is developed from 2007, standardized in 2014,
    - is not based on SGML,
    - has complicated implementation of an interpreter.
    - contains both HTML and XHTML markups (and HTML DOM) representations
</section>

<section markdown='1'>
## HTML5
- `<!DOCTYPE html>`
- Extended semantic elements (`article`, `nav`, `menu`, ...).
- Improved user interaction:
    - inserting objects into the page (video, vector graphics, math, ...),
    - improved form elements (date, number, ...),
    - validation of forms (data types, regexp, ...),
    - spread forms (form elements without containment),
    - data attributes.
- Removed all visual elements.
- Done some accessibility improvements (see WCAG).
- Extensible with other markups (MathML, SVG).

</section>

<section markdown='1'>
## Styles
- HTML describes only the **structure** of a text document.
    - There is no way to change the visual *rendering*.
- To change the rendering of a document, **styles** must be used.
- CSS (Cascading Style Sheets) is a language for the definition of styles.
    - CSS is not a programming language.
- When no styles are applied, the web browser uses default styles (also called **user-agent** styles).

</section>

<section markdown='1'>
## CSS Styles
- From CSS3, the standard is split into **modules**:
    - Various degrees of standardization (earliest 2007).
- Various browser tests to determine the support:
    - [http://www.w3.org/TR/CSS/](http://www.w3.org/TR/CSS/)
    - [http://acid3.acidtests.org/](http://acid3.acidtests.org/)
    - [http://css3test.com/](http://css3test.com/)
    - [http://tools.css3.info/selectors-test/test.html](http://tools.css3.info/selectors-test/test.html)
    - or [http://caniuse.com/](http://caniuse.com/)
- Styles replace deprecated HTML elements like FONT, BASEFONT, BIG, CENTER, S, STRIKE, U, …

</section>

<section markdown='1'>
## CSS Styles
- Dozens of modules:
    - font properties, color, box properties, box model,
    - border, color, margin, background, effects, …
- **Web page is not paper**.
    - Web page must adapt to (almost) infinite number of window sizes.
    - Leads to **Responsive design**.
    - Requires a good page layout in HTML as well.

</section>

<section markdown='1'>
## CSS Syntax
- A CSS document is composed of CSS rules:
    - `selector {property: value;}`
- Example: `body {color: black;}`
    - There is no semicolon after the parentheses.
- Selector:
    - element name -- `h1 {color: white}`
    - element class -- `.table_list {width: 100%}`
    - element id -- `#input_name {width: 40px}`
- Selectors can be combined.
- Any number of properties can be set in a single rule.
</section>

<section markdown='1'>
## CSS Syntax
- Selector combinations examples:
    - `li, a` -- for an element that is either `<li>` or `<a>`,
    - `li a` -- for an element `<a>` that is contained in `<li>`,
    - `li>a` -- for an element `<a>` that is a direct child of `<li>`,
    - `li.menu` -- for an element `<li>` that has the class `menu`.
- Pseudo-classes:
    - things which cannot be determined by HTML structure,
    - hover, active, focus, link, visited, nth-child, …
    - `li a:visited` -- a visited link inside an `li`,
    - `li.menu a#first:link` -- a not visited link with id `first` inside an `li` with the class `menu`.
</section>

<section markdown='1'>
## Connecting styles with HTML
- External file:
    - `<link rel='stylesheet' href='style.css'>`
    - The best solution -- all styles in one place.
    - a link to the HTML element with selectors (element name, class, id).
</section>

<section markdown='1'>
## Connecting styles with HTML cont.
- Inside HTML page:
    - `<style type='text/css'>body {color: green;} … </style>`
    - Used for special pages.
    - Used to optimize the number of HTTP requests.
- Inline:
    - `<body style='color: green'>…`
    - (Obviously?) without a selector.
    - Highest priority, use only for exceptions.
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
- Style properties are inherited from parent elements to child elements:
    - the top element is `body` (in rare cases `html`);
    - not all properties are inherited (use common sense).
- All CSS rules are applied in order by priority:
    - **closer** and **more specific** rules have higher priority;
    - higher priority rules override lower priority rules;
    - only properties are overridden, not entire rules.
- Inline style > page style > external style.
- Id > class.

</section>

<section markdown='1'>
## CSS Box Model
- Padding -- inside of the HTML element -- between the content and the box.
- Border -- outside of the HTML element -- around the box.
- Margin -- outside of the HTML element -- around the box.

![Margin & Padding](/en/apv/articles/html/margin-padding.png)
</section>

<section markdown='1'>
## CSS Box Size
- Size -- width/height - content + spacing + border.
- The size is depending on the **box model**:
    - basic types: `inline`, `block` (corresponding with HTML elements);
    - inline is limited by the line size;
    - the block is sized independently.

</section>

<section markdown='1'>
## CSS Colors
- On screen, colours are mixed **additively**.
- A color can be set by:
    - name -- `black`, `white`, … (over a hundred);
    - by three RGB components (component intensity 0-255):
        - `color: rgb(255, 0, 0)` (decimal),
        - `color: #FF0000` (hexadecimal),
        - `color: #F00` (shorthand hexadecimal),
        - `color: rgba(255, 0, 0, 0.5)` (**alpha channel**);
    - by three HSL components:
        - `color: hsl(0, 100%, 50%)`,
        - `color: hsla(0, 100%, 50%, 0.5)` (**alpha channel**).
</section>

<section markdown='1'>
## CSS Layouts
- Creating a full page layout is a non-trivial task.
- Layouts for web pages and for web applications are completely different.
- Use existing layouts, e.g.:
    - Bootstrap ([getbootstrap.com](http://getbootstrap.com/)),
    - Foundation ([foundation.zurb.com](http://foundation.zurb.com/)),
    - Skeleton ([getskeleton.com](http://getskeleton.com/)),
    - SemanticUI ([semantic-ui.com](http://semantic-ui.com/)).
- Complicated layouts use alternatives to CSS (LESS, SASS).
    - Must be compiled to CSS for web browsers.
</section>

<section markdown='1'>
## Sources
- Always check the data and the author -- many sources are outdated or plain wrong.
- [W3C wiki](www.w3.org/community/webed/wiki/)
- [Mozilla Developer Portal](https://developer.mozilla.org/en-US/docs/Web)
- [Google University](https://developers.google.com/university/)
- [W3C](http://www.w3c.org)
</section>

<section markdown='1'>
## Checkpoint
- Why mustn't the HTML start tag and end tag cross?
- What happens if a HTML document lacks a `<!DOCTYPE`?
- Can you have a delete icon on a page without using an image?
- What does XML and HTML have in common?
- Why CSS3 has not been standardized yet?
- Who says that `<title>` must not occur twice in a HTML document?
- Is it better to draw a border using CSS or use an PNG image?
- What does HTML4 and HTML5 have in common?
</section>
