## Summary
Pagination of results is necessary in some cases. When you design your application's interface, you
should think where the amount of displayed records will rise rapidly and implement pagination in
such modules. Another approach is to display some "distinguished" results only and let the user
search in the rest.

Nowadays you can encounter modern approach called *progressive loading* where new records are added into
a page as user scrolls down in his browser. This approach suits better in situations where you have
really large (or infinite) amount of pages. You can see this on [Google images](https://images.google.com?q=cat).
This modern approach ofcourse involves [JavaScript](./javascript).

A good idea is to write some general function which will generate HTML structure of pagination for you.
Also retrieval of pagination variables for template can be generalized and put into a function.
This approach can be extended to hide distant page numbers (in case that there are too many pages).

You will start using frameworks for serious web application development, those have usually pagination
support built in.

### New Concepts and Terms
- pagination