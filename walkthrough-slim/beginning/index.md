---
title: Beginning
permalink: /walkthrough-slim/beginning/
---

* TOC
{:toc}

I will end this walkthrough with its actual beginning. This chapter describes how the course project skeleton
([https://bitbucket.org/apvmendelu/slim-based-project](https://bitbucket.org/apvmendelu/slim-based-project)) was
created. You can use it to create your own unique project in the future.

Following steps may change in the future, this tutorial is for Slim framework version 3.x.

## Prerequisites
1. Install [PHP](http://php.net/downloads.php)
2. Install [Composer](https://getcomposer.org/download/)

You do not have to install [Postgre database](https://www.postgresql.org/) or [Apache web server](https://httpd.apache.org/)
because you only need local PHP to execute Composer. You should be able to run `php` and `composer` commands in your
command line interpreter. I will discuss deployment of the application later, I suppose that you have a remote
server where PHP and database is already working.

## Actual project
1.  Create a directory and open command line in this new folder.
2.  Install Slim framework using Composer ([here](http://www.slimframework.com/docs/v3/tutorial/first-app.html) is their
    manual page about it - a better way is to use [project skeleton](https://github.com/slimphp/Slim-Skeleton)).
    
    ~~~ bash
    composer create-project slim/slim-skeleton .
    ~~~
    
    {: .note}
    You can delete some unnecessary files and folders (like tests folder and  *.md files).

3.  Install [Latte template wrapper for Slim](https://github.com/ujpef/latte-view). This also installs [Latte](https://github.com/nette/latte)
    library. You can read the manual on the GitHub project page, basically you want to register the Latte wrapper to be
    accessible inside your routes and you want to create a custom `{link}` macro to use [route names](/walkthrough-slim/named-routes/).
    
    Slim has a file called `dependencies.php` where you define an associative array of project *services*.
    
    ~~~ bash
    composer require ujpef/latte-view
    ~~~
    
    Than open `src/dependencies.php` and add following lines and delete original *renderer* dependency (if present):
    
    ~~~ php?start_inline=1
    use Latte\MacroNode;
    use Latte\PhpWriter;
    use Latte\Loaders\FileLoader;
    
    $container['view'] = function ($container) use ($settings) {
       //Create instance of Latte engine and configure path to cache files
       $engine = new Engine();
       $engine->setLoader(new FileLoader(__DIR__ . '/../templates/'));
       $engine->setTempDirectory(__DIR__ . '/../cache');
    
       //configure Latte wrapper and return it
       $latteView = new LatteView($engine);
       $latteView->addParam('router', $container->router);
       //define the {link} macro to generate URLs in templates from route names
       $latteView->addMacro('link', function (MacroNode $node, PhpWriter $writer) {
           if (strpos($node->args, ' ') !== false) {
               return $writer->write("echo \$router->pathFor(%node.word, %node.args);");
           } else {
               return $writer->write("echo \$router->pathFor(%node.word);");
           }
       });
       return $latteView;
    };
    ~~~
    
    {: .note}
    Keys of `$container` array will be accessible as `$this->key` in your routes.

4.  Create `cache` and `logs` folders (if not present). Remember to set *write* permission for *others* and *group* on
    Akela server.

5.  Prepare database connection as dependency in `src/dependencies.php`. [PDO](http://php.net/manual/en/book.pdo.php) is
    usually enabled as PHP module on your server. It is the same approach as with Latte templates. The difference is
    that PDO is part of PHP, so we do not need to download anything.
    
    ~~~ php?start_inline=1
    $container['db'] = function ($c) {
       $db = $c['settings']['db'];
       //connect to database
       $pdo = new PDO($db['dbtype'] . ":host=" . $db['dbhost'] . ";dbname=" . $db['dbname'],
                      $db['dbuser'],
                      $db['dbpass']);
       //define error mode -> we want to throw exceptions
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       //define how should fetch() and fetchAll() work
       $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
       //configure character set for database communication - everything is UTF-8
       $pdo->query("SET NAMES 'utf8'");
       return $pdo;
    };
    ~~~
    
    You have to set up the settings for DB connection in `src/settings.php`:
    
    ~~~ php?start_inline=1
    return [
       'settings' => [
           //...
           'db' => [
               'dbtype' => 'pgsql',
               'dbhost' => 'localhost',
               'dbname' => 'xuser',
               'dbuser' => 'xuser',
               'dbpass' => 'password'
           ],
           //...
       ],
    ];
    ~~~
   
6.  Optional: configure `public/.htaccess` for Akela server. On [our development server](/course/mendelu/), we need to
    set the *rewrite base* directory to distinguish between physical part of URL path and virtual paths (handled by
    router). This basically says, that Slim's router should only be supplied with part of path **after**
    `/~xuser/devel/public` to determine current route. It is because the entry point (`index.php` file) of the
    application is stored in the `/~xuser/devel/public` folder. You do not have to bother with this when your
    application is in the root (`/`).
    
    The `.htaccess` file configures [*mod_rewrite*](https://httpd.apache.org/docs/current/mod/mod_rewrite.html) Apache
    module which allows virtual URLs to be handled by PHP script. E.g. `/~xuser/devel/public/path/to/route` is a virtual
    path (no such file exists) -- we want to subtract the real path part (`/~xuser/devel/public` defined by
    `RewriteBase`) and pass the rest (`/path/to/route`) into Slim to select route handler.
    
    ~~~
    # enable the mod_rewrite plugin
    RewriteEngine On
    
    # Set path to your public folder on Akela server.
    RewriteBase /~xuser/devel/public
    
    # if the request is a virtual path (!-f means "not a file")...
    RewriteCond %{REQUEST_FILENAME} !-f
    # ...handle the request with actual index.php file (the entrypoint)
    RewriteRule ^ index.php [QSA,L]
    ~~~
    
    {: .note}
    You can find more on [mod_rewrite](/course/technical-support/#configuration-of-mod_rewrite) in another article.

7.  Optional: install [*PHP dotenv* library](https://github.com/vlucas/phpdotenv) to use dedicated environment files.
    
    ~~~ bash
    composer require vlucas/phpdotenv
    ~~~
    
    Modify `src/settings.php` to load values from `.env` file:
    
    ~~~ php
    <?php
    //this loads the .env file from upper level directory
    $env = Dotenv\Dotenv::create(__DIR__ . DIRECTORY_SEPARATOR . '..');
    $env->load();
    //older version of Dotenv library:
    //$env = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . '..');
    //$env->load();
    return [
       'settings' => [
            //...
       ],
    ];
    ~~~
    
    Create `.env` file:
    
    ~~~
    DB_TYPE=pgsql
    DB_HOST=localhost
    DB_USER=xuser
    DB_PASS=password
    DB_NAME=xuser
    ~~~
    
    Load database connection settings from it:
    
    ~~~ php?start_inline=1
    <?php
    $env = Dotenv\Dotenv::create(__DIR__ . DIRECTORY_SEPARATOR . '..');
    $env->load();
    return [
       'settings' => [
           //...
           'db' => [
               //instead of actual values, use getenv() function to load from .env file
               'dbtype' => getenv('DB_TYPE'),
               'dbhost' => getenv('DB_HOST'),
               'dbname' => getenv('DB_NAME'),
               'dbuser' => getenv('DB_USER'),
               'dbpass' => getenv('DB_PASS')
           ],
           //...
       ],
    ];
    ~~~

8.  Optional: start using [Git](/articles/programming/git/). Prepare `.gitignore` file in the root of your project
    to avoid committing unnecessary files:
    
    ~~~
    /vendor/
    /logs/*
    /cache/*
    /.env
    ~~~
    
    The `vendor` folder can always be downloaded using Composer command `composer install` - dependencies are stored in
    `composer.json` file. If you use PhpStorm or NetBeans, also add `.idea` or `nbproject` line into this file.

10. Optional: set the `$basePath` variable. It may be useful to have absolute path in a variable for templates to
    reference CSS and JavaScript files. You can do it in the `middleware.php` file:
    
    ~~~ php?start_inline=1
    $app->add(function(Request $request, Response $response, $next) {
        //fetch absolute path to root of application
        $basePath = $request->getUri()->getBasePath();
        //pass it to the view layer (templates)
        $this->view->addParam('basePath', $basePath);
        return $next($request, $response);
    });
    ~~~
    
    {: .note}
    [Middleware](https://www.slimframework.com/docs/v3/concepts/middleware.html) is an additional code that can be
    attached to one, multiple or all routes of your application.    

11. Optional: download [Bootstrap](https://getbootstrap.com/), [Font Awesome](https://origin.fontawesome.com/) and
    [jQuery](https://jquery.com/) and extract them into the `public` folder, say `public/css/bootstrap/`,
    `public/css/font-awesome` and `public/js` folders.
   
    You can use `$basePath` variable defined in previous step to ensure smooth loading of referenced files. Relative
    path would cause problems because we are using *nice URLs* for routes and the browser would handle them wrong.
    This is explained in the [mod_rewrite](/course/technical-support/#configuration-of-mod_rewrite) section of another
    article.
   
    ~~~ html
    <!DOCTYPE html>
    <html>
    <head>
       <meta charset="utf-8">
       <title>Title of page</title>
       <link rel="stylesheet" href="{$basePath}/css/bootstrap/css/bootstrap.min.css">
       <link rel="stylesheet" href="{$basePath}/css/font-awesome/css/all.min.css">
       <!-- you custom CSS file has to be last to override Bootstrap -->
       <link rel="stylesheet" href="{$basePath}/css/custom.css">
       <!-- jQuery has to come first because Bootstrap JS depends on it -->
       <script type="text/javascript" src="{$basePath}/js/jquery.js"></script>
       <script type="text/javascript" src="{$basePath}/css/bootstrap/js/bootstrap.bundle.min.js"></script>
       <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        ...
    </body>
    </html>
    ~~~
    
    Use [layout file](/walkthrough-slim/templates-layout/) to avoid code repetition.
    
    {: .note}
    You can use Bootstrap without jQuery, but some dynamic components like *navbar* would stop working.

## Deploying the application
Besides the [Akela](/course/mendelu/) server, you can upload your application to (almost) any PHP hosting (use Google
to to find one -- you can even get a free one -- without second level domain, e.g. `your-app.their-hosting.com`). You
basically need a hosting with PHP and a database. Be careful about PHP version -- check out requirements of all
libraries and used framework. Database is more likely going to be MySQL or MariaDB than PostgreSQL, but the difference
in basic SQL queries is minimal (find a hosting with suitable PHP version and choose database system before you start
coding). There is some more reading about this in the chapter [for external readers](/course/not-a-student/).

You usually want to have your application accessible after entering `http://www.your-app.com` into address bar.
For this, you need a second level domain and you have to pay for it. You also do not want to type anything else after
the domain name, e.g.: `http://www.your-app.com/public/login` -- that would be cryptic and tedious for users.
The application should start right away after typing the domain name. 

After successful registration (and payment), you usually will receive an email with FTP or SSH and database credentials.
Almost all hosting services have a tool for database administration, some use [Adminer](https://www.adminer.org/),
others use [phpMyAdmin](https://www.phpmyadmin.net/), they are similar. You can set up database structure through such
tool or [import](/walkthrough-slim/database-intro/#import-database) it. Than you can create `.env` file
for your hosting with proper credentials. Finally you can upload the application using [FTP or SSH client](/course/technical-support/#ftp--ssh).

{: .note}
Beginners often use PHP hosting as development environment because installing own PHP stack with database is a bit
[problematic](/course/not-a-student/). Sometimes you need to configure the hosting to display PHP errors to be able
to reasonably develop an application.

The `public` folder should be set as the only one visible folder through HTTP protocol. Some hosting services allow you
to choose the path to *public* folder through administration panel, other PHP hosting services are configured to create
third level domains from top-level folders, e.g. a folder called `logs` in the root of your hosting disk space would
cause a third level domain `http://logs.your-app.com` to exist. In this case, you need to rename the `public` folder
to `www`. Some hosting services just publish all your files -- in this case, you need to move contents of `public`
folder up one level to have the `index.php` file in the root.

Be very careful about the `.env` file (especially in the last scenario), check whether there is no way to access it
from the internet, e.g.: `http://logs.your-app.com/.env`. You can hide this file using
[configuration directives in `.htaccess`](/articles/web-applications/environments/#the-env-file).

Folder structure and files on general PHP hosting:

+ cache -- set chmod 0777 to this folder and all files in it
  + .htaccess -- disallow access into this folder
  + *.php -- cached templates
+ logs -- set chmod 0777 to this folder and all files in it
  + .htaccess -- disallow access into this folder
  + app.log -- log file
+ public -- or www
  + css -- public CSS assets
    + *.css
  + images -- public images
    + *.jpg
  + js -- public JS assets
    + *.js
  + .htaccess -- configure `mod_rewrite`
  + index.php -- entry-point of the application
+ src
  + .htaccess -- disallow access into this folder
  + dependencies.php
  + middleware.php
  + routes.php 
  + settings.php
  + ...
+ templates
  + .htaccess -- disallow access into this folder
  + *.latte -- original templates
+ vendor
  + .htaccess -- disallow access into this folder
  + ...
+ .env -- configuration file

Everything under the `public` or `www` folder is available on the internet and can be accessed using HTTP protocol.
Read about uploading user files and hiding them from internet in [previous chapter](/walkthrough-slim/upload/).

{: .note}
Do not upload the `.git` or `.idea` folder and `composer.*` files. They are useless on the hosting.

Those `.htaccess` files should [prevent accessing contents](/course/technical-support/#set-a-directory-as-inaccessible-from-the-internet)
of other folders than `public` or `www` through HTTP although these folders do not contain anything very secret and
the contents of PHP files is never disclosed because the source code is executed and only the result (if any) is
printed out. The `.htaccess` file in `public` or `www` folder is used to configure [`mod_rewrite`](/course/technical-support/#configuration-of-mod_rewrite).

{: .note}
The support of `.htaccess` files sometimes has to be enabled in configuration of hosting service manually. Some hosting
services are not based on Apache or they do not allow usage of `.htaccess` files (check this out before subscribing).
You can run PHP on [NGINX](https://www.nginx.com/) or other HTTP server, but they are configured differently.

## Summary
Now you should have a project in similar state as in my BitBucket repository. The selection of libraries and framework
is arbitrary. I could have chosen [Lumen](https://lumen.laravel.com/) over Slim and [Twig](https://twig.symfony.com/)
over Latte. The process of selection of right libraries is tedious because you have to learn how to use them at least
a bit and test them for your scenario.

You should also have at leas a basic understanding of deploying the application on a real web server.
