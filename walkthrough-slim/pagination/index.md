---
title: Pagination
permalink: /walkthrough-slim/pagination/
redirect_from: /en/apv/walkthrough-slim/pagination/
---

* TOC
{:toc}

{% include /common/pagination.md %}

## Task - add basic pagination to person list module
Use page number (starting from 0) as path parameter. Make current page button inactive or make it
distinct visually in another way (so the user can tell which page is he currently browsing).

File `src/routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/pagination/pagination.php %}
{% endhighlight %}

Notice, that `page` parameter in route definition is not mandatory and also that it takes only numbers:
`/persons[/{page:[0-9]+}]`.

File `templates/persons-list.latte`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/pagination/persons-list-1.latte %}
{% endhighlight %}

{: note}
Keep in mind that when a visitor clicks on a page number, the browser reloads whole page. If the set of
listed database records depends on another parameter (i.e. search or sorting), you have to pass also
this additional parameter to keep consistent output.

{: note}
You can use Bootstrap's [pagination classes](http://getbootstrap.com/components/#pagination) to make
your pagination buttons look good.

## Task - add previous/next and first/last page button
Link for first page is easy -- just set page parameter to zero. Previous and next page can be calculated
by adding or subtracting one from current page value. Last page number can be calculated by subtracting
one from page count (because it starts from zero).

Links for previous or first page should be visible only if current page is larger than zero. Similarly, links
for next and last page should be visible on other pages than the last one.

Updated file `templates/persons-list.latte`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/pagination/persons-list-2.latte %}
{% endhighlight %}

If you have search function in your person list, you have to decide if you want to paginate filtered results
too. Because there is usually not much displayed records after applying search filter, you would probably
want to hide pagination controls in that case:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/pagination/persons-list-3.latte %}
{% endhighlight %}

{: .note}
You can also check the page parameter value for negative values. You can do this by use of mathematical
function `max(0, intval($args['page']))` to avoid `if()` statement. Function `max()` returns obviously its
larger argument. A combination of `min()` and `max()` can also be handy sometimes -- `min(max(0, $v), 100)`.

{% include /common/pagination-conclusion.md %}