[Templates](../templates/) allow you to create HTML pages with a simplified code and
also protect your page against [Cross Site Scripting attacks](/articles/security/xss/).
Apart from that, the template engine allows you to take advantage of
**Template Page Layouts** (or **Template Layouts** or **Page Layouts**).
Template Layouts are not to be confused with [**HTML/CSS Page Layouts**](/articles/css/#page-layout),
which define the visual layout of content in a HTML page.
Template Layouts are used to define the HTML code layout across different files,
share common parts of the code and reduce repetition. Template Layouts have no
effect on the final look of the HTML page. They are merely a programmatic tool used
for better HTML code organization.

Each HTML page in a web application **shares** a lot of the HTML code with other pages in
that application. So far you have only created simple isolated pages, so this might
not seem obvious at the moment. But if you look at any existing web application you
should see that all the pages usually share the same header, footer, navigation,
design, etc. Only some part of the page is **specific** to the page itself.
In real world applications, to have high amount of a shared code is a good thing,
because it reduces code repetition and leads to consistent feel & look of the application.