---
title: Pagination
permalink: /en/apv/walkthrough/pagination/
---

* TOC
{:toc}

Pagination is a helpful concept which is used to display large amount of records. There are two main reasons
to paginate results:

- Prevention from overloading internet browser by enormous amount of data (large HTML file = long processing
  and transfer). Still the browser has capability (depending on the hardware) to handle much bigger amount
  of data than an average person.
- Prevention from confusing the user -- each person is different, but displaying few hundreds of records
  at once can surely confuse everybody.
 
It is also useful to sort records according some logical criteria (time/date/surname/price) or let the user
select a column to sort by.

## How to paginate?
I want to show you a simple pagination. We will just display page numbers under the persons list for start.
Afterwards, we will add also button for jumping to previous/next and first/last page.

First of all you have to understand how is the pagination implemented in database. In PostgreSQL you have to
specify [`LIMIT` and `OFFSET`](/en/apv/articles/sql-aggregation/#pagination) clauses in the SQL query
to fetch requested records.

![Limit and offset](offset-limit.svg)

This means that SQL query returns **only certain amount of results** from certain position. To display
pagination controls you need to calculate how many pagination buttons to show, this value can be calculated
only with knowledge of **total record count**. This ultimately means that you have to run another SQL query
with `COUNT(*)` function to fetch total count of **relevant** records.

{: .note}
In MySQL you can use `CALC_FOUND_ROWS` modifier right after `SELECT` clause. And than you can fetch
amount of total rows which would be returned without `LIMIT` clause by subsequent `SELECT FOUND_ROWS()
AS all_row_count` SQL query. It still means that you have to run two queries, but it is less complicated.

When you know total amount of all possible results, you can calculate amount of pages according to
chosen page count. Let's say that you want certain amount of records per page, than you have to divide
total amount of records by page count and round the result up, using [ceil()](http://php.net/manual/en/function.ceil.php)
function.

Take a look at an example -- you have a table with 105 rows (0--104) and you want 25 items per page:

SQL queries:

    SELECT * FROM table WHERE col = val LIMIT 25 OFFSET 0;
    SELECT COUNT(*) AS cnt FROM table WHERE col = val;

Calculations for pagination:

    105 records / 25 per page = 4.2 -> ceil(4.2) -> 5 pages


|       |page 1|page 2|page 3|page 4|page 5  |
|-------|------|------|------|------|--------|
|LIMIT  |25    |25    |25    |25    |25      |
|OFFSET |0     |25    |50    |75    |100     |
|results|0--24 |25--49|50--74|75--99|100--104|

{: .note}
Be careful to apply same `JOIN`s, `WHERE` and/or `GROUP BY` conditions to `COUNT(*)` query as to the
query with `LIMIT` and `OFFSET` clauses. Without them, you wold be displaying page numbers of
non-existing pages.
 
The amount of results per page (`LIMIT`) is usually a concrete number which a user often cannot change
at all (but it is possible to have such function). Much more important for pagination functionality is
to transmit the information about where to start (`OFFSET`) -- you have to tell PHP backend which page
you want to render as a response for your request. In your HTTP request, you can send either page number,
which is multiplied by amount of items per page before applying as `OFFSET`, or a value which is directly
passed into `OFFSET` clause.

## Task - add basic pagination to person list module
Use page number (starting from 0) as request parameter. Make current page button inactive or make it
distinct visually in another way (so the user can tell which page is he currently browsing).

File `persons-list.php`:

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/pagination/persons-list.php %}
{% endhighlight %}

File `persons-list.latte`:

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/pagination/templates/persons-list-1.latte %}
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

Updated file `persons-list.latte`:

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/pagination/templates/persons-list-2.latte %}
{% endhighlight %}

If you have search function in your person list, you have to decide if you want to paginate filtered results
too. Because there is usually not much displayed records after applying search filter, you would probably
want to hide pagination controls in that case:

{: .solution}
{% highlight php %}
{% include /en/apv/walkthrough/pagination/templates/persons-list-3.latte %}
{% endhighlight %}

{: .note}
You can also check the page parameter value for negative values. You can do this by use of mathematical
function `max(0, intval($_GET['page']))` to avoid `if()` statement. Function `max()` returns obviously its
larger argument. A combination of `min()` and `max()` can also be handy sometimes -- `min(max(0, $v), 100)`.

## Summary
Pagination of results is necessary in some cases. When you design your application's interface, you
should think where the amount of displayed records will rise rapidly and implement pagination in
such modules. Another approach is to display some "distinguished" results only and let the user
search in the rest.

Nowadays you can encounter modern approach called *progressive loading* where new records are added into
a page as user scrolls down in his browser. This approach suits better in situations where you have
really large (or infinite) amount of pages. You can see this on [Google images](https://images.google.com?q=cat).
This modern approach ofcourse involves [JavaScript](/en/apv/walkthrough/javascript).

A good idea is to write some general function which will generate HTML structure of pagination for you.
Also retrieval of pagination variables for template can be generalized and put into a function.
This approach can be extended to hide distant page numbers (in case that there are too many pages).

You will start using frameworks for serious web application development, those have usually pagination
support built in. 

### New Concepts and Terms
- pagination