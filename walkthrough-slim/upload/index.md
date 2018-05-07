---
title: File upload
permalink: /walkthrough-slim/upload/
---

* TOC
{:toc}

{% include /common/upload-1.md %}

### Prepare a form
Upload of files is performed using HTTP's POST method but you have to add special attribute `enctype="multipart/form-data"`
to your `<form>` tag. To select a file from visitor's computer use `<input type="file" name="user_file" />` tag.
New browsers support `accept=".jpg, .png"` attribute to limit file types, but you cannot trust it, it is merely a user
convenience function.

Template `upload.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/upload/upload-01.latte %}
{% endhighlight %}

PHP handles incoming file upload automatically and stores file in temporal directory. You should move the file to target
directory Using `moveTo()` method of Slim's file object. Slim has the `getUploadedFiles()` method on `$request` object
which returns collection of uploaded files.

According to my previous advice, the file is renamed using a randomly generated string, the random file name is being
generated until there is no collision. You can prefix file name with current date using `date('Y-m-d')` or `time()`
function for better debugging.

Routes in `routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/upload/upload-01.php %}
{% endhighlight %}

Notice that I used a configuration entry to store the path for uploaded files. Append this line to settings array in 
`src/settings.php` file and also create the `uploads` folder in your project:

~~~ php?start_inline=1
return [
    'settings' => [
        //...
        'uploadDir' => __DIR__ . '/../uploads',
        //...
    ],
];
~~~

{: .note}
Remember to set [permissions](/course/technical-support/#file-permissions-chmod) for target directory to 0777.
Otherwise you won't be able to store files on Linux systems. You can set the `uploadDir` configuration to a path which
is outside the scope of HTTP server. For example: when your public folder is `/home/username/public_html/devel/public`
set `uploadDir` to `__DIR__ . "/../uploads"` to put uploaded files next to `public` directory.

### Create a database table
Now you know that files are being stored in a directory of your choice but you need to store other information to access
the right file afterwards. We need to store file name, file type, original file name and ID of person which is associated
with this file. Therefore we need a new database table:

{: .solution}
{% highlight sql %}
{% include /common/upload/file.sql %}
{% endhighlight %}

### Store file metadata into database
Now you can modify your PHP script and your template to display person selector and store all required information
into a database table. The `file_type` key contains so called [MIME type](https://en.wikipedia.org/wiki/Media_type)
of a file -- this was declared by the browser and should not be trusted very much. The rest of file attributes is
self explanatory.

Template `upload.latte`:

{: .solution}
{% highlight html %}
{% include /walkthrough-slim/upload/upload-02.latte %}
{% endhighlight %}

Routes in `routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/upload/upload-02.php %}
{% endhighlight %}

{: .note}
You can apply some restrictions on uploaded files -- maybe you want to limit the size or file type. You can use PHP's GD
library to check image properties with [`getimagesize()`](http://php.net/manual/en/function.getimagesize.php) function.
If you reject the file, remember to delete it from file system using [`unlink()`](http://php.net/manual/en/function.unlink.php)
function. Generally, file validation is very difficult because every file type validates differently.

### Download script
Uploaded files are now stored on file system, information about that files are in database and we know which person
is related with particular file -- you can use this to list person related files in your application. Every file has
an ID which can be used to download that file via dedicated PHP script. You may think that downloading a file should
be an easy and straightforward action -- this is unfortunately wrong. Remember that files should not be stored in a
directory which is accessible via HTTP protocol. Therefore you cannot simply generate the `<a>` tag pointing to a file
or use `header()` function to generate `Location: path-to-file` header and let browser to do the rest.

In following script I simply fetch file information from database using file ID and then generate proper HTTP response
with correct `Content-Type` and `Content-Disposition` headers. I will deliver file contents to visitor using
[`readfile()`](http://php.net/manual/en/function.readfile.php) function.

Route in `routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/upload/fetch-file-01.php %}
{% endhighlight %}

{: .note}
This script uses `$response` object's method `withStatus()` to notify client about errors and non-existing files by
HTTP status code. Such codes are useful for browsers and search engine crawlers to understand that this URL
contains nothing interesting.

Try to switch different `Content-Disposition` headers to modify behaviour of browser -- `inline` disposition displays
file content directly in browser if the browser supports such file type (HTML, XML, an image or a PDF file) while
`attachment` disposition forces browser to offer visitor to download the file whatever the file type is. You can also
change the `filename` section to whatever you want to suggest different file name in file dialog. `Content-Type` header
is crucial for interpretation of transferred data -- you have to set correct [MIME type](https://en.wikipedia.org/wiki/Media_type)
so the browser can display the file or open appropriate application. In this case I simply use MIME type reported
during file upload.

~~~ php?start_inline=1
return $response
    ->withHeader('Content-Type', $fileInfo['file_type'])
    ->withHeader('Content-Disposition', 'inline; filename="' . $origName . '"')
    ->withBody($stream);
~~~

{: .note}
`Content-Type` and `Content-Disposition` are also often used when you generate a PDF, PNG/JPG image, CSV, Word or Excel
document in your PHP script instead of plain HTML.

### Caching
HTTP protocol has support for caching of transmitted files. It means that static files which do not change a lot are
downloaded only once and stored in your computer's memory and HTTP provides means how your browser and a server
reason about this. The server sends HTTP response header with file *version* along with file data. Your browser
remembers that *version* and when it makes subsequent HTTP request for that same file, it sends the *version* string
that it has in its cache. The server simply checks if the *version* is same and confirms it -- the file contents
is not transmitted in this case. There is a chance that it has newer *version* and it tells to the browser to delete
the old one and store a new one -- contents of file is transmitted this time. You can achieve significant improvement
of load-time for a website with a lot of static files if your browser uses cache properly. The *version* can be
a date and a time of last content update or a [hash](/walkthrough-slim/login/#storing-users-passwords)
of some unique content part.

Common PHP script output should not be cached because there is a good chance that data in database or something else
changed (e.g. user logged on/off) and you want to deliver new content as response for each request. On the other hand,
PHP script which sends uploaded file which never (or very rarely) changes as response should employ HTTP caching.
Plus the fact that files are commonly quiet large so you can save a lot of time and bandwidth.

In following script I use just very simple approach, first HTTP response is extended with `Last-Modified` header
with current time (or you can use real file's [modification time](http://php.net/manual/en/function.filemtime.php)).
Visitor's browser remembers that information and when requesting that same URL using HTTP it attaches `If-Modified-Since`
header. Subsequent requests are turned down once the PHP script detects that browser has a copy of file in its cache
(browser sends `If-Modified-Since` header and PHP script can detect this using `$request->getHeader('If-Modified-Since')`
method). My approach does not examine the version of cached file because it never changes.

{: .note}
Besides using `Last-Modified` and `If-Modified-Since` approach, you can use [`ETag`](https://en.wikipedia.org/wiki/HTTP_ETag)
HTTP header for content which changes cannot be captured by date and time.

Route in `routes.php`:

{: .solution}
{% highlight php %}
{% include /walkthrough-slim/upload/fetch-file-02.php %}
{% endhighlight %}

Upload some file, find its ID in database table and try do download it using second version of `fetch-file` script.
Open developer tools network console and observe first and subsequent HTTP request for file. You should see HTTP
status code 200 and some amount of transferred bytes for the first time. Subsequent requests should be handled with
304 status code (Not Modified) and much smaller amount of transferred bytes. When you clear your browser's cache using
`Ctrl+Shift+Del` or reload the page using `Ctrl+F5`, the scenario should repeat (HTTP 200 + data for first response
and HTTP 304 + no data for subsequent responses). Observe HTTP headers too and look for `Last-Modified` and
`If-Modified-Since` headers in responses and requests.

{: .note}
You might not want to use cache for non-public files.

{% include /common/upload-2.md %}