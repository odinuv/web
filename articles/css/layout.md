---
title: Layout Modes
permalink: /articles/css/layout/
redirect_from: /en/apv/articles/css/layout/
---

* TOC
{:toc}

## Layout Modes
So far I have explained how the web browser (or more precisely its rendering engine) determines
values of different CSS properties. When this is done, the rendering engine may start actually
drawing the HTML elements on the screen. The first step in drawing the elements is determining
their sizes and positions. This is done using a **layout** engine, which can operate
in several [layout modes](https://developer.mozilla.org/en-US/docs/Web/CSS/Layout_mode):

- block layout -- by default used for block elements (`p`, `table`, `ul`, `ol`, `div`, ...),
    - float layout -- a flavour of block layout in which elements are stacked into lines,
    - column layout -- a flavour of block layout in which elements are stacked into columns,
- inline layout -- by default used for inline elements (`a`, `img`, `span`, ...),
- table layout -- used for *contents* of table (the `table` itself is a block element),
- positioned layout -- in this layout, the elements are positioned by their coordinates, without interaction with other elements,
- [flex layout](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Flexible_Box_Layout/Using_CSS_flexible_boxes) (flexible box layout) -- in the layout the boxes are able to change their size to best accommodate the screen,
- [grid layout](http://gridbyexample.com/) -- allows positioning elements in a fixed grid (this is different to table in that a table is a dynamic grid --
it accommodates to content)

The *flex layout* and *grid layout* are the newest additions to CSS layouts. Grid layout is not very well supported
among browsers yet, but there are already [some guides on using it](https://css-tricks.com/snippets/css/complete-guide-grid/).
Keep in mind that layout mode is specified per element (not per document), which means that all the layout modes
can be mixed in a single document. Let's have a quick look on the basic properties and usage of different layout modes.

### CSS Box Model
Before we get to the layout modes, it is important how CSS handles HTML elements. Each element on a page is
represented as a rectangular box (even if it has round corners) with four *edges*:

{: .image-popup}
![Schema -- Box Model](/articles/css/boxmodel.png)

The edges are computed from the element *content*.
In the following example, the `inner` div size is 50 &times; 50 pixels. So that is the
size of content of the `outer` div (yellow box is the *content edge*). To that, the
element **padding** is added (another 50 pixels). Padding is spacing between the element content and
element border, therefore it has the background color of the parent element (it acts as if it were part of the content).
The blue rectangle defines the *padding edge*.
The last part of the element is the magenta **border** (another 50 pixels). Border is placed outside
the element content. The magenta rectangle shows the *border edge*.

Outside of the element is the **margin** (another 50 pixels). Margin is spacing outside of the element --
between the element border and its parent *content edge*. The cyan rectangle shows the *margin edge*.
The margin edge determines the total space occupied by the HTML element on screen.

{: .image-popup}
![Screenshot - Box model](/articles/css/sample-page-10a.png)

{% highlight html %}
{% include /articles/html/css-sample-10a.html %}
{% endhighlight %}

{% highlight css %}
{% include /articles/html/style-10a.css %}
{% endhighlight %}

Therefore, to calculate how much space an HTML element will occupy on a screen, you need to add
content, padding, border and margin dimensions together.
Feel free to experiment wit the page in [your browser developer tools](/course/not-a-student/#web-browser).

### Block layout
Now you probably wonder, why the `.outer` div above is not square. This is because a `div` is a block level element
and block level elements occupy (unless specified otherwise) the entire space of their *parent*. In this
case this is `body` which by default has width and height set to automatic. Automatic width (`width: auto`) means that the
element occupies all available horizontal space of the **parent** element. Automatic height (`height: auto`) means that the
element has height to accommodate all of its **children**.

You can fix that by setting `.outer` width to e.g. `50px`. Now this may sound weird, the actual visible element width
is `2 ✕ 50 (border) + 2 ✕ 50 (margin) + 50 (content size) = 250 px`. I.e. setting the width
to 50px actually results in element width being 250px. This is as designed -- look at the box model schematic
above -- the CSS `width` property refers to the *content width* (content edge). What happens if you
set the width to more than the content width (e.g. 150px) ?

{: .image-popup}
![Screenshot - Block layout - larger width](/articles/css/sample-page-10c.png)

The content size was extended, but the content (obviously?) was not. That's simply because the `.inner` div
has set width to 50px and no border or padding. This means that the space between the `.inner` *margin edge*
and `.outer` *content edge* was extended. You can see it blue because there is nothing in it, so you can see
through to the parent element (`.outer`), which is blue. This is also why `width: 100%`
[does something else than you might expect](http://stackoverflow.com/questions/17468733/difference-between-width-auto-and-width-100-percent).
Try removing the `width` of the `.inner` element, can you guess what happens?

{: .solution}
<div markdown='1'>
The inner element spreads to entire content of the parent element (width: 150px).
</div>

{: .note}
To center the `.inner` div, add `display: flex; justify-content: center` to the `.outer` div.

What happens if you make the content smaller? I also made padding smaller, so that the behavior is more visible:

{: .image-popup}
![Screenshot - Block layout - smaller width](/articles/css/sample-page-10d.png)

As you can see, the `.inner` element width remained 50px wide and it **overflowed** the designated space
in `.outer` div. By default, the overflow is visible. You can control what happens with the overflow
(of `.outer` div) by setting `overflow` property. Try setting it to `hidden` or to `scroll`.
Notice that the overflow does not include the padding (because that is not part of the content) --
i.e. the overflow refers to the *content edge*.

The above describes the basic behavior of positioning and sizing **block** elements. In a simplified way it can
be described that a block element accommodates to the size of its *parent*. Or in other words, that a parent
block defines the space which its children can occupy. Block layout is used for block elements or elements
with `display: block` property. Keep in mind that block layout is vertically oriented -- `height: auto` and
`width: auto` [behave differently](http://stackoverflow.com/questions/15943009/difference-between-css-height-100-vs-height-auto).
This is because HTML was designed for text documents which naturally expand vertically.

### Float layout
Block layout can be greatly modified by using floats. I have added more boxes and slightly
modified the CSS (`.inner` now has margin).

{% highlight html %}
{% include /articles/html/css-sample-11a.html %}
{% endhighlight %}

{% highlight css %}
{% include /articles/html/style-11a.css %}
{% endhighlight %}

{: .image-popup}
![Screenshot - boxes with no float](/articles/css/sample-page-11a.png)

Notice that the boxes are stacked below each other. This is because block layout favors vertical flow -- i.e.
it is assumed that a block level element occupies entire 'line' of screen (even if it really does not). This is typical
for text documents. When you put a table or figure (that is block element) in an a text, you usually want it to
occupy the entire width of the document. If not, you can modify the by setting it to float.

When you set `float: left` to the `.inner` div. You should see this:

{: .image-popup}
![Screenshot - boxes with float left](/articles/css/sample-page-11b.png)

All the `.inner` elements floated out of the parent `.outer` div. Which shrank to zero height, this is
why the blue area disappeared. It still has width `500px` however, because that it defined in the style, so
all you see is 500px wide and 50px thick magenta border. The floated `.inner` elements then stack starting from
top left corner. Notice that they still maintain the position and width of the `.outer` element (the top
left yellow box is in exact same position as in the previous example). This may look like a weird behavior --
the elements are placed outside of their container, yet they respect its size (except height which overflows).
Why does float behave so strangely? Because that is exactly what it is expected to do.

Float was designed for positioning block elements in a flow of text, see how a figure looks without float,
I used [Lorem Ipsum](http://demo.agektmr.com/flexbox/) text to fill the page:

{% highlight html %}
{% include /articles/html/css-sample-12a.html %}
{% endhighlight %}

{% highlight css %}
{% include /articles/html/style-12a.css %}
{% endhighlight %}

{: .image-popup}
![Screenshot - text with no float](/articles/css/sample-page-12a.png)

And now, lets float the figures:

{% highlight html %}
{% include /articles/html/css-sample-12b.html %}
{% endhighlight %}

{% highlight css %}
{% include /articles/html/style-12b.css %}
{% endhighlight %}

{: .image-popup}
![Screenshot - text with float](/articles/css/sample-page-12b.png)

And this is how it looks like if the container `article` does not have enough text

{: .image-popup}
![Screenshot - text with float](/articles/css/sample-page-12c.png)

The above example should make the float behavior more clear. The floated element (`figure`) is removed
from the container (`article`) element and positioned **as if it were there**. Similarly the content of
the container element is adjusted as if the floated element was there. This allows the rendering engine
to maintain both elements as rectangular boxes.

If you want to have the container element to extend with the contained elements, you have to apply
[**Clearfix**](http://complexspiral.com/publications/containing-floats/)
([shorter explanation](http://stackoverflow.com/questions/8554043/what-is-a-clearfix)). The Clearfix is a CSS rule
(yes, it is a rule so special, that it has its own name) looks like this:

{% highlight css %}
.outer::after {
 	content: "";
  	display: block;
  	clear: both;
}
{% endhighlight %}

The `::after` selector is a [**pseudo-element**](https://developer.mozilla.org/en-US/docs/Web/CSS/Pseudo-elements).
Pseudo-elements represent special places in document *content* (remember what [pseudo-classes](#pseudo-classes) are?). The
distinction between pseudo-element and pseudo-class is that pseudo-element use two semicolons `::` (but they
are also accepted with one semicolon, so `:after`). The rule works so that it virtually creates another element
*after* the list child of `.outer` element. That virtual element has no content `content: ""` and stops the
floating `clear: both` and switches layout mode to `block` layout. The same could be (and for older browser was)
achieved by a special element in HTML code, which would stop floating. It is not that important to know how Clearfix works,
but it is a nice illustration of immense CSS capabilities. The important thing is that it ensures that the container
grows with the floats.

Floating blocks are mainly useful for textual documents (as shown in the above example), but it has other
uses too -- e.g. if you replace the yellow boxes in the above example with photos, you'll get a nice
photo gallery. For more complicated layouts, the [flex layout](#flex-layout) is a better solution.

### Column layout
Similarly to float layout, the column layout is an extension to block layout and is designed mainly for
text layouts. In the below example, the text is split into three columns:

{% highlight html %}
{% include /articles/html/css-sample-13a.html %}
{% endhighlight %}

{% highlight css %}
{% include /articles/html/style-13a.css %}
{% endhighlight %}

The columns are primarily set using the `column-count` property. There are also
[other properties](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Columns/Using_multi-column_layouts)
to tweak how the columns behave. You should see an output simirlar to this one:

{: .image-popup}
![Screenshot - text in columns](/articles/css/sample-page-13a.png)

The column layout is primarily useful for splitting text into columns, if you want to put other
blocks in columns, you should see the [flex layout](#flex-layout).

### Inline layout
The inline layout is designed for sizing elements *inside* a flow of text. Inline layout
is default for inline elements (`a`, `span`, `strong`, `em`, ...). It is special in that the
height of the element is controlled by the **line height**. This means that setting e.g. `height` or
`margin-top` does nothing, because the element is sized to fit inside the line. However the
[box model](#css-box-model) still applies, which means that border and padding are addded to the element
height (which is line height). This means that they interfere with the surrounding text:

{: .image-popup}
![Screenshot - inline border](/articles/css/sample-page-14a.png)

The above was generated using the following HTML:

{% highlight html %}
{% include /articles/html/css-sample-14a.html %}
{% endhighlight %}

and CSS style:

{% highlight css %}
{% include /articles/html/style-14a.css %}
{% endhighlight %}

[**Line height**](https://developer.mozilla.org/en/docs/Web/CSS/line-height) (`line-height` property) is
by default set to value `normal`. You can see that in the above example between **computed** styles.
This means a that the line-height is guided by the used font (`font-family`). For the `Times New Roman`
family I used in the example, line-height normal is 1.15. That means 1.15 times bigger than the specified font
size. Therefore the line-height is `16px ✕ 1.15 = 18.4px`. Then you need to add 2 ✕ 10px (padding)
and 2 ✕ 20px (border) which yields 78.4 px as the required height of the line:

{% highlight css %}
{% include /articles/html/style-14a.css %}
{% endhighlight %}

{: .image-popup}
![Screenshot - inline border](/articles/css/sample-page-14b.png)

If you want every line to have the same height, you (obviously?) need to set the `line-height` property
for the entire `article` element. You can switch any element to inline layout by setting
`display: inline` property. You need to be aware of the
[special box model handling](https://hacks.mozilla.org/2015/03/understanding-inline-box-model/) though.

### Table layout
As the name suggests, table layout is designed for rendering tables. Table layout accommodates to
size of the content, first vertically and then horizontally. I.e. table cell width extends with cell
content up to maximum width which would still fit into the table, then the cell height grows.
Table layout mode technically uses several `display` property values:

- `table` for the `table` elements,
- `table-row-group` for the `thead` and `tbody` elements,
- `table-row` for `tr` elements,
- `table-cell` for `td` and `th` elements.

Setting the above display modes (and few others) allows you to imitate the behavior of HTML tables.
It is possible to use this instead of writing tables in HTML. HTML tables should be used to represent
only *semantic* tables -- i.e. it should contain only data whose *meaning* is a table. Consider the following
form:

{: .image-popup}
![Screenshot - Tabular form](/articles/css/sample-page-15b.png)

It is not *semantically* correct to put the form in a `table` and `td` elements, because it is not
truly a table. Yet it makes sense to display it in a form of a table. It can be done with a HTML like this:

{% highlight html %}
{% include /articles/html/css-sample-15b.html %}
{% endhighlight %}

And a CSS like this:

{% highlight css %}
{% include /articles/html/style-15b.css %}
{% endhighlight %}

Notice the use of combined selector `form.tabularForm label` which selects all labels which
are children of `form.tabularForm`. Using tables for non-tabular data is quite
[controversial](http://phrogz.net/css/WhyTablesAreBadForLayout.html). Still, table layout
mode may prove to be useful in many [scenarios](http://colintoh.com/blog/display-table-anti-hero).
Also it can be misused in a lot of scenarios, where a [flex layout](#flex-layout) would be simpler solution.

### Positioned layout
Positioned layout is designed to place elements to certain coordinates irrespective of content.
The positioning (`position` property) can be:

- `relative` -- the element is positioned relative to where **it would be**,
- `absolute` -- the element is positioned relative to its closest positioned parent,
- `fixed` -- the element is positioned relative to browser window,
- `static` -- default positioning, the element is positioned after its preceeding sibling
(i.e elements are positioned as they are written down in the HTML document -- hence `static`).

#### Relative position
You can see how relative positioning works on the [example with floats](#float-layout):

{% highlight html %}
{% include /articles/html/css-sample-16a.html %}
{% endhighlight %}

And a CSS like this:

{% highlight css %}
{% include /articles/html/style-16a.css %}
{% endhighlight %}

The element in the middle has class `special` which moves it
50 pixels to the left of its **original** position:

{: .image-popup}
![Screenshot - Relative position](/articles/css/sample-page-16a.png)

{% highlight css %}
#special {
	position: relative;
	left: -50px;
}
{% endhighlight %}

#### Absolute position
If you modify the `#special` element to:

{% highlight css %}
#special {
	position: absolute;
	left: 0px;
	top: 0px;
}
{% endhighlight %}

You'll see a result like this:

{: .image-popup}
![Screenshot - Absolute position](/articles/css/sample-page-16b.png)

Notice two things: First, the element left it's parent -- you can see that the other
`.inner` elements have been rearranged. Second, the element position should be
positioned at coordinates 0, 0 from top left corner, but it is positioned at
50, 50. This is because the `.inner` element has `margin: 50px`. That is,
the position (`top`, `left`) refers to the [**margin edge**](#css-box-model), while the
size (`width`, `height`) refers to the **content edge**. You have to do
the math on your own.

In the above, there is no explicit positioned parent for the element `#special`. In that case, the
closest positioned parent is `body`. See what happens when you add `position: absolute` to the
container `.outer`.

{% highlight css %}
{% include /articles/html/style-16c.css %}
{% endhighlight %}

{: .image-popup}
![Screenshot - Relative position](/articles/css/sample-page-16c.png)

The `#special` element now **overlaps** the first yellow box (notice there is number 5 instead of 1). This
is because it is positioned at coordinates 0, 0 **relative** to the content of the `.outer` element
(because that is the closest parent of `#special` which has `position: absolute`). This is pretty
important, because it means that the absolute positioning mode is not really absolute. Also it means that
if you have a absolutely positioned elements inside a page and you add `position: absolute` to some
of their parents, the entire layout will break to pieces.

##### Stacking
When working with positioned elements (positioned otherwise than `static`) it becomes to take notice of
element stacking. So far, I told you that child elements are drawn [over their parents](#background)
with transparent background (unless specified otherwise) so that the parents can be seen through.
This describes the default `static` positioning a default **Stacking order**. Stacking order can be
modified by seting the `z-index` property, but only if the element
[position is not `static`](http://stackoverflow.com/questions/9191803/why-does-z-index-not-work).

Let's change the `#special` element color and offset it a bit so that you can see the overlap more clearly:

{: .image-popup}
![Screenshot - Relative position](/articles/css/sample-page-16d.png)

{% highlight css %}
{% include /articles/html/style-16d.css %}
{% endhighlight %}

Now, you can start experimenting with Stacking order (`z-index` property). Default Stacking order value is `auto`,
which means that it is inherited from parent element.

This ultimately leads to `html` element which has `z-index: 0`. Higher `z-index` values bring the element to front,
lower (negative) values push the element back. So lets push back the `#special` element behind the first yellow box.
You can set `z-index: -5` (the negative value is completely arbitrary) on `#special` element and you will see that
it disappeared completely. That is because it was pushed behind all elements with `z-index: 0` which also
includes the `.outer` element. In short, the `#special` element hides behind parent. To fix that, you need to specify
`z-index: -10` on the `.outer` element.

{% highlight css %}
{% include /articles/html/style-16e.css %}
{% endhighlight %}

{: .image-popup}
![Screenshot - Relative position](/articles/css/sample-page-16e.png)

The above works, but if you experiment with it, you'll run into some peculiarities. E.g. setting
`.outer` z-index to 10 would not bring it above the yellow boxes or setting `#special` stacking order
to -20 would not bring it behind its parent. This is because stacking order (`z-index`) is not
simply a single global `height`. In fact, stacking of elements is one of the most complicated parts of CSS
If you are interested more in it, here are some resources:

- [Walkthrough article](http://mdn.beonex.com/en/CSS/Understanding_z-index.1.html),
- [Another article](http://vanseodesign.com/css/css-stack-z-index/),
- [CSS wiki](https://www.w3.org/wiki/CSS_absolute_and_fixed_positioning#The_third_dimension.E2.80.94z-index),
- [the CSS specification](https://www.w3.org/TR/CSS2/visuren.html#propdef-z-index),
- [an appendix to the specification](https://www.w3.org/TR/CSS2/zindex.html).

Absolute position with proper stacking is often used for [modal dialogs](https://en.wikipedia.org/wiki/Modal_window)
which need to overlap everything else on a page.

#### Fixed position
Fixed positioning can be used to position an element relative to **viewport**. To understand what viewport is,
you need a bigger (scrolling page) and you can imagine that you are looking at it through telescope or microscope.
The viewport is the window through which you see the page and you move the viewport to the desired page part by
scrolling. Simply said, viewport is the area you are currently viewing.
It is not correct to say that viewport is the browser window, because viewport is created for any
scrolling area.

You can see how fixed position is used in the following example:

{% highlight html %}
{% include /articles/html/css-sample-17a.html %}
{% endhighlight %}

{% highlight css %}
{% include /articles/html/style-17a.css %}
{% endhighlight %}

{: .image-popup}
![Screenshot - Flex layout](/articles/css/sample-page-17a.png)

Notice that the element is positioned from bottom right corner and its margin still applies. You need to
test that above example on your own and see that the yellow box number five stays attached to the viewport
and does not scroll. Fixed position is widely used for 'sticky' things like alerts and advertisements.

### Flex layout
Flex (flexible boxes) layout is a new addition to CSS standard introduced in CSS3. It addresses the issues which
are mainly connected with layouting applications. CSS and HTML were primarily designed for layouting
text pages which means that the other layout modes oriented in on direction (block & table in vertical,
inline in horizontal). The flex layout is *direction agnostic* -- it does not prefer one direction over the other.
This makes the flex layout mode very suitable for application layouts (particularly
[responsive applications](https://en.wikipedia.org/wiki/Responsive_web_design), but unfortunately it also makes
it a lot more abstract.

To recreate the [example with floats](#float-layout) using flex layout, you can use the following code:

{% highlight html %}
{% include /articles/html/css-sample-18a.html %}
{% endhighlight %}

{% highlight css %}
{% include /articles/html/style-18a.css %}
{% endhighlight %}

{: .image-popup}
![Screenshot - Flex layout](/articles/css/sample-page-18a.png)

The `display: flex;` property switches the layout mode of `.outer` div to *flexible container*.
All children of that element become *flexible boxes*. The property `flex-flow: row wrap;` defines that
the flexible boxes will be arranged in wrapping rows.

The flex layout is a great tool that can be used for a wide range of layouts, you can see:

- [examples](https://philipwalton.github.io/solved-by-flexbox/),
- [demos](http://demo.agektmr.com/flexbox/),
- [guide with examples](https://css-tricks.com/snippets/css/a-guide-to-flexbox/),
- [MDN documentation](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Flexible_Box_Layout/Using_CSS_flexible_boxes).

## Summary
In this article I tried to describe the various systems used to actually draw HTML elements on a computer screen.
Mastering CSS layouts is no easy task and describing all the possibilities would fill many books.
You should start with already created page and layout templates, there is no shame in that. However
it is good to have a general idea how they work.

### New Concepts and Terms
- box model
- content edge
- margin edge
- layout mode
- block layout
- inline layout
- positioned layout
- table layout
- flex layout
- float
- relative positioning
- absolute positioning
- stacking
- stacking order (`z-index`)
- fixed position
- viewport