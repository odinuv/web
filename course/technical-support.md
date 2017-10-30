---
title: Technical support
permalink: /course/technical-support/
redirect_from: /en/apv/course/technical-support/
---

* TOC
{:toc}

This article is about different tools, programs and their configuration. It is not a comprehensive guide or rewrite
of technical manuals. I just want to point you in right directions when you develop a web application and you
encounter some technical issues. The information stated here may be useful to you when you decide to advance behind
the APV course borders and write yourself a new web application and upload it on a Linux server or run it on your
own PC.

Some information related to this topic can also be found in the section for [readers not studying at MENDELU](/course/not-a-student).
A basic training with an IDE and SSH client is part of the [APV course](/course).

## FTP & SSH
[FTP](https://en.wikipedia.org/wiki/File_Transfer_Protocol) and [SSH](https://en.wikipedia.org/wiki/Secure_Shell)
are network services which are usually used to communicate with a web server. FTP service is just for file transfer,
SSH offers full remote access to the system via a command line. Both services require authentication with a login and
a password. Below is an image of [Midnight Commander](https://www.midnight-commander.org/) executed on a remote computer
via SSH (an especially useful tool for remote web server configuration):

{: .image-popup}
![Midnight Commander on remote computer](/course/ssh-mc.png)

To connect with an FTP server you need an FTP client program. SSH is a bit trickier -- you can use it similarly as FTP,
just for file transfers or you can use a remote shell via [Putty](http://www.putty.org/) on Windows or `ssh` command on
Linux (type `ssh user@hostname` to connect). To transfer files over the FTP/SSH protocol use these nice tools:
[WinSCP](https://winscp.net/eng/download.php) on Windows or [FileZilla](https://filezilla-project.org/) (multi-platform).
A basic FTP plugin can also be found in many two-panel file managers.

### File permissions (chmod)
Some PHP applications need to write their own files to the disk (e.g. Latte template cache, image thumbnails, error logs).
Most real world servers run on the Linux platform and a user which executes PHP scripts is different than a user (i.e. you)
who uploaded that script to the server. Therefore you have to set permissions to files/directories for other users to
allow them writing to your files/directories. This is done by the `chmod` command. In the SSH remote shell type
`chmod -R 0777 path/to/file/*`
to allow read/write/execution of your files to everybody else on that system. Switch `-R` means that you set that
privilege to files and directories recursively and `0777` is mode of privileges for you, your usergroup and for everybody
else. Both FileZilla and WinSCP clients provide setting of the user privileges in file/directories context menu.
The following image shows file attributes dialog (you do not have to remember some strange numbers,
there are checkboxes for this):

{: .image-popup}
![FileZilla file attributes](/course/filezilla-privileges.png)

## PHP ecosystem
PHP is used as the main programming language in this book. I will list here some technical details about it and
some information about the related applications.

### PHP configuration
PHP is an [interpreter](/articles/programming/#source-code) and therefore it can be configured
very differently on various systems. A script can work
perfectly in your development environment but it can break down in production environment without obvious reason.
You can make a small script with [`phpinfo()`](http://php.net/manual/en/function.phpinfo.php) function call to list environment
variables and settings of the PHP interpreter. It also lists enabled/installed modules of PHP -- for example:
PDO, MySQL/PostgreSQL, GD library
etc. If you find some PHP setting uncomfortable and you have the privilege to tweak PHP config, you can locate
`php.ini` file and adjust the settings, otherwise you have to contact customer support or even change the way you
operate with your application. The usual output of `phpinfo()` function begins like this:

{: .image-popup}
![PHP info](/course/php-info.png)

Some of default PHP settings may be limiting and sometimes you find out that you need a module which is not
enabled/installed. Most common PHP settings which need to be often adjusted (most limiting ones):

- `memory_limit` -- maximum amount of memory consumed by one instance of a PHP script
- `max_execution_time` -- maximum duration of a PHP script
- `upload_max_filesize` -- maximum size of an uploaded file
- SMTP settings -- for sending an email

For example `memory_limit` setting: when you work with bitmap images (resizing an image to obtain a thumbnail), you need
to fit a whole bitmap into the memory. For a 2 Mpx image you need 2000000 pixels &times; 24 bit per channel ~ about 6 MiB
of memory. But for a 10 Mpx image you need five times more (also include some overhead for calculations and other script needs
-- 128 MiB should be enough for your scripts). Often the memory setting is set very low by default -- 32MB is a typical
value (yes, this is about 100 times less than your mobile phone).

The file upload size can be limiting when you try to import a large database dump with [Adminer](#adminer) and also with image uploads from
users. Even a trained administrator can be lazy to downscale images beforehand, other users just do not care.

Useful PHP extensions:

- PDO and MySQL, PostgreSQL, SQLite -- database interfaces
- gd -- graphics
- zip -- compression
- CURL, SOAP, XML-RPC or LDAP -- communication with other services
- XML or JSON -- file format support

### PHP as command line script interpreter
[PHP](http://php.net) is a useful language, it has many functions in its standard library and many more in additional
plugins. Once you have learned the basics of PHP, you might want to use PHP for other tasks not related to web applications.
PHP is especially good for text file processing. If there is PHP installed in your
system, you can use PHP interpreter (executable file `php`) to run scripts in the terminal. Just type
`php script-name.php` and PHP should run that script. To print output use the `echo` command. Reading from the standard
input is a bit more [complicated](http://php.net/manual/en/features.commandline.io-streams.php) though.

{: .note}
If you have PHP installed but your terminal does not respond to the `php` command, make sure that you have added
PHP location to system variable called `Path` (on Windows). To check its content type `path` into the Windows command
window. To modify the `Path` system variable, open the properties of your computer and find management of system variables
or execute `setx path "%path%;C:\path\to\php"` command (which appends `path\to\php` as another `Path` route).

### Composer
This [tool](https://getcomposer.org/) is used sometimes to download PHP libraries. It is again a command line tool
written in PHP itself. It is used among developers to describe dependencies of their code on various libraries. When
you send your application's source code to a colleague (by email, file sharing service or preferably through
[VCS](https://en.wikipedia.org/wiki/Version_control) system like [Git](https://git-scm.com/)) you do not need to send
large amounts of libraries (which are usually larger than your code itself). You just send a recipe which dependencies
should be downloaded using Composer.

For example: to download [Latte](https://packagist.org/packages/latte/latte) library execute `composer install latte/latte`
in the root of your project. This action will create or modify a `package.json` file which you can send along with your
sources to your colleagues and a `vendor` directory, which contains the library (you do not have to include this directory
when you want to share your code, Composer will download it according to the `packages.json` file contents).

In your code just include Composer's `autoload.php` file (this file handles autoloading of
[classes](/walkthrough/backend-intro/objects/#classes) by their
[namespace](/walkthrough/backend-intro/objects/#namespaces)
and name)  from `vendor` directory (`include 'vendor/autoload.php';`) and you can create a new instance of Latte right
ahead (`$tpl = new Latte\Engine();`) without including any other files.

### Sending emails from web applications
Sometimes it is useful to send an email with notification to a user about an event that took place. PHP uses simple
[`mail()`](http://php.net/manual/en/function.mail.php) function to send plain-text emails. To send HTML emails
or attachments, use some PHP library such as [SwiftMailer](http://swiftmailer.org/). You can download it with Composer
(`composer require swiftmailer/swiftmailer`).

### Adminer
[Adminer](https://www.adminer.org) is a general database tool used in this book. Adminer handles different types of
database engines. It is also a PHP application itself -- you download a single PHP script (do not download Adminer
editor). Alternatives are [phpMyAdmin](https://www.phpmyadmin.net/) for MySQL/MariaDB databases and [phpPgAdmin](http://phppgadmin.sourceforge.net/)
for PostgreSQL. Adminer is more versatile but it has less functions than specific tools.

{: .note}
There are also database-specific applications e.g. [MySQL Workbench](http://www.mysql.com/products/workbench/) or
[PgAdmin](https://www.pgadmin.org/) for database management which are not web-based.

### PHP frameworks
I would have to write many books to describe PHP frameworks one by one. It is even impossible as I do not know
all of them. To develop a real larger scale PHP application you do not need a framework, but after you do that
again and again, you would consider some tasks repetitive. PHP frameworks usually take care of tasks which are
related to application infrastructure (routing, templates, logging, user authentication) and they offer a set of
well known and tested libraries to perform usual tasks (sending emails, communication with database) they also
take care of tedious tasks related to security ([CSRF](todo), [XSS](todo) or [SQL injection](/articles/security/sql-injection/)).
Most of them use [MVC](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) architecture and some of
them offer additional features such as [ORM](/articles/database-tech/#orm), command line tools to speed up
development or testing library interface. They are usually downloadable with Composer.

You can check out the source code and popularity of PHP frameworks on [GitHub](https://github.com/) where their
creators share and develop them (look at stars count):

- [CodeIgniter](https://github.com/bcit-ci/CodeIgniter) -- [website](https://www.codeigniter.com/)
- [Laravel](https://github.com/laravel/laravel) -- [website](https://laravel.com/)
- [Nette](https://github.com/nette/nette) -- [website](https://nette.org/en/)
- [Symphony](https://github.com/symfony/symfony) -- [website](https://symfony.com/)
- [Yii](https://github.com/yiisoft/yii2) -- [website](http://www.yiiframework.com/)
- [Zend](https://github.com/zendframework/zendframework) -- [website](https://framework.zend.com/)
- and many more

There are also "micro-frameworks" used for [SPA](https://en.wikipedia.org/wiki/Single-page_application) backend:

- [Laravel Lumen](https://github.com/laravel/lumen) -- [website](https://lumen.laravel.com/)
- [Slim](https://github.com/slimphp/Slim) -- [website](https://www.slimframework.com/)

To become a really experienced PHP developer, try to develop at least one non trivial application without a framework
to gain insight -- such step can also help you to understand the benefits of using a framework.

## Apache web server
This software is a complicated beast. It powers most web servers in the world and you will definitely have to
configure it at some point of your life. It is very versatile and therefore the configuration is quite detailed.
Also the [website](https://httpd.apache.org/) is not one of those super well organized. You can find its general
config in a file called `httpd.conf` -- always make a backup before you start modifying it.

Most common configuration tasks are enabling or disabling some modules, turning on/off directory listings and
setting up virtual hosts on your own server. Most common modules which you usually want to enable are PHP
for `*.php` files, HTTP authentication support and mod_rewrite. You can use tools to enable plugins (`a2enmod`)
and virtual hosts (`a2ensite`) on Linux systems.

For most website developers, first encounter with Apache's configuration is `.htaccess`  file which serves as
local configuration for a particular directory that it is placed in (and also its subdirectories).
To use `.htaccess` files, the server's administrator has to configure `AllowOverride All` in Apache's global config
for that directory. You are usually allowed to use `.htaccess` files on shared web-hostings to configure mod_rewrite
or protecting your website with HTTP authentication.

{: .note}
On Linux operating systems, files the names of which begin with a dot are considered hidden. If you do not see `.htaccess`
file in directory listing in your FTP/SSH client (and you know that you uploaded it), go to settings and enable
hidden file listing.

### Enabling/disabling directory listing
To enable directory listing is useful for development servers. When you have multiple projects placed in one
directory and you do not want to create custom `index.html` or `index.php` file which you have to modify each
time you add a new project. Apache will create a simple directory listing page for you automatically. On the
other hand, you want to obfuscate as much as possible for production servers and not to show the application
directory structure to a potential attacker.

Put one of the following lines into your `.htaccess` file. The second line is obviously used to disable directory listing.

    Options Indexes
    Options -Indexes

### Set a directory as inaccessible from the Internet
Sometimes you need to store files which should not be accessed freely. Perhaps you want to read them using PHP or
generate thumbnails or apply watermark in case of files containing images. To do this, simply put following into
`.htaccess` file:

    deny from all

### Configuration of mod_rewrite
You might have noticed that professional web applications have nice looking URLs -- like this book, I do not have
`/path/to/file.php` style URLs. I have cool URLs like `/en/articles/name-of-article`. To achieve this,
developers use [mod_rewrite](http://httpd.apache.org/docs/current/mod/mod_rewrite.html). It is an Apache plugin
which is responsible for conversion of a nice readable URL into to a real one. Let's take an e-shop for example:
A URL like `/product/12345/new-super-cool-laptop` can be converted into `product.php?id=12345` which
will be processed by the `product.php` script of the application. The text
"new-super-cool-laptop" is irrelevant for database lookup, but we want to feed it to search engine crawlers
to achieve better ranking in search results for selected key words. Mod_rewrite is configured with
[regular expressions](https://en.wikipedia.org/wiki/Regular_expression) to match a URL which is typed
into a browser and a rule used to convert it to something real and useful.

    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^/product/([0-9]+)/.+$ product.php?id=$1 [L,QSA]

The two `RewriteCond` lines test whether the path entered into browser address bar (`%{REQUEST_FILENAME}`)
is not (`!`) an actual directory (`-d`) or file (`-f`). All conditions must evaluate to true. In the `RewriteRule` section,
a regular expression extracts the ID number by `[0-9]+` pattern and passes it as an `id` parameter of the `product.php`
script.

Here is something more general (the interpretation of a `q` parameter is carried out by application's logic):

    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?q=$1 [L,QSA]

This example takes any text (`.*` pattern) that is contained in the URL and passes it as the `q` parameter.
The flag *L* means that this rule is *last* applied and *QSA* means *query string append* (take everything that is
behind `?` in the original URL and forward it). The URL in the browser stays the same unless there is *R* flag after
`RewriteRule`.

Another use-case of mod_rewrite is to add `www` to the URL beginning when a user enters just `site.com` into
the web browser -- here I used the `R` flag with status code 301 which tells the browser that the content is located
elsewhere and it should navigate to the new URL given in `RewriteRule` (the browser's address bar changes):

    RewriteEngine on
    RewriteCond %{HTTP_HOST} ^site\.com
    RewriteRule ^(.*)$ http://www.site.com/$1 [R=301,L]

{: .note}
If you want to use nice URLs, you have to generate such URLs into the `href` attribute of each `<a>` tag. This means that you
actually place a non-existing URL into the `href` and rely on mod_rewrite to handle it. Your application therefore needs
a complex set of rules to generate and interpret symbolic URLs. Modern frameworks have such functionality built-in and
it is called *routing*.

{: .note}
Nice URLs can cause problems because your web browser generates relative paths according to address bar content.
If you have some non-existing path in the address bar (`/product/12345/new-super-cool-laptop`) and your browser tries
to load an image given by relative path (`<img src="images/shop-logo.png" alt="Logo">`) from that page (the resulting URL of image is `/product/12345/new-super-cool-laptop/images/shop-logo.png`),
it fails. To prevent this, you have to generate all URLs from root of your application. To persuade the browser to do
that, you need to put a `<base href="http://my-cool-site.com/my-shop/">` tag with an absolute path to the application root
(newer browsers do not need domain name) into `<head>` tag. This will cause that all relative URLs are prefixed with
`href` attribute value from `<base>` tag. Therefore the image will be loaded from `http://my-cool-site.com/my-shop/images/shop-logo.png`
which should be OK. Another way is to store absolute path to root of your application and use it everywhere around
in your code: `<img src="{$basePath}/images/shop-logo.png">` where `{$basePath}` contains the same URL as in `<base>` tag.

{: .note}
If your application lives in a subdirectory, you usually need to add `RewriteBase path/to/subdirectory` into
`.htaccess` file (right after `RewriteEngine on` line).

### Configuration of basic HTTP authentication
If your Apache server has enabled modules `mod_auth_basic` and `mod_authn_file`, you can use this approach
to restrict access to a selected directory and its subdirectories. This approach is useful when you want to hide
a web application during its development. Put these lines into your `.htaccess` file:

    AuthType Basic
    AuthName "Restricted Content"
    AuthUserFile /path/to/.htpasswd
    Require valid-user

Contents of the `.htpasswd` file can look like this:

    user:$apr1$Ywno0KCc$/R75cky8xEvL5DpWuTLEy.

The above line defines an account called `user` with a password `pass`. Use some online `.htpasswd`
[generator](http://www.htaccesstools.com/htpasswd-generator/) to obtain yours. There can be more users defined
 in `.htpasswd` file.

## Database systems
In development environment, you almost never have to tweak database settings. When installing a database server,
a form usually pops out which lets you select your intentions (development/production server) and it lets you
create user accounts. To create more users and set permissions for them, you usually use SQL commands directly or
a special environment for database administration.

A real production server should be configured by a database specialist. Important notes about technical issues with
databases from the developer's perspective are in [another article of this book](/articles/database-tech/).
