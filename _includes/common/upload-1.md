This chapter is a bonus for interested students. You do not have to include this functionality into your project.
Nevertheless, you or users of your app, will need to upload a file to a web server sooner or later once you decide
to build web sites for a living. PHP has a simple way how to handle [file uploads](http://php.net/manual/en/features.file-upload.php)
but there are a few catches which can slow you down.

I will show you how to upload files to a web server and store them -- let's say that you want to upload documents
or photos for persons stored in your database.

## Limitations
- PHP has setting that defines [maximal size for file upload](/course/technical-support/#php-configuration).
  That option can be set to a different value on every server. You should let your users know that there is a limit.
- Internet connection speed (**upload speed** -- that one is usually significantly slower than download speed) and
  quality of connection is important when uploading larger amounts of data.
- Cheap/free shared web hostings often suffer from issues with full hard drive -- other users uploaded so much files
  that your data does not fit in.

## Security risks
Letting strangers upload files to your server is even more dangerous than letting them store data in your database.
A file's content has to be stored somewhere, regular web hosting providers let you create only a very limited database
storage space. Therefore you have to store user's files in a file system -- that can be an issue. Imagine
that you store all uploaded files from all users into a single directory on you server:

- You have to generate meaningless names (**without extension**) to **prevent execution of uploaded scripts** (an
  attacker may attempt to upload a valid PHP file and execute it through web server by typing its path in his browser).
- The name of file that you generate must also be unique to prevent overwriting of other files uploaded earlier.
- It is a good practice to store files in multiple subdirectories (e.g. generate a name of such directory from upload
  date) to prevent filesystem issues (long file listings).
- You may need to control access to uploaded files and in that case you want them to be completely inaccessible via HTTP
  protocol:
  - You can deny access to directory using [`.htaccess`](/course/technical-support/#set-a-directory-as-inaccessible-from-the-internet)
    when you have privilege to use them.
  - Better solution is to store uploaded files in a directory which is not accessible through HTTP at all, but it is not
    always possible.
  - You should at least disable file listing of directory containing uploaded files using either [`.htaccess`](/course/technical-support/#enablingdisabling-directory-listing)
    or a dummy index file (a poor man's solution).
  - Afterwards, you can use PHP's [`readfile()`](http://php.net/manual/en/function.readfile.php) function to send
    files' contents to authorised visitors.
- You need to store information about uploaded files needed in your application into database.
- You need to take care of [permissions](/course/technical-support/#file-permissions-chmod) for the directory
  where you store uploaded files.

## Uploading a file
I will start with basic file upload which does not save anything to the database. I will just show you how to store
a file on your server. Then I will show you how to store file information to the database and connect it with a person.
Finally I will show you how to make a download script.