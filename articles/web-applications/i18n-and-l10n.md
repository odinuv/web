---
title: Internationalisation and localisation
permalink: /articles/web-applications/i18n-and-l10n/
---

* TOC
{:toc}

There are applications which are used by people from different countries either together or individually (multiple
instances of same application). Your should be prepared for such requirement and know how to deliver such application.

You may encounter abbreviations L10N and I18N (numbers mean amount of letters between first and last letter) which
are used instead of long names of these two topics.

Internationalisation is the ability of the application to work in multiple environments -- this has to be designed
and programmed in advance. It is not very difficult to design such application, but it is very hard to internationalize
existing application.

Localisation is the process of customising the application for different national environment -- this is done by
translating text messages and modifying config files etc. Localisation is usually not programming and can be done by
trained operator. You cannot localise application which is not internationalized.

What can be different among languages:

- static texts in templates
- texts in database
- number format -- use some kind of output filter or directive to format numbers
- date and time format -- same as numbers
- plural form -- e.g. "1 beer", "N beers" VS "1 pivo", "2 piva", "5 piv" etc., a library can be used for this
- images with texts -- try to avoid this, you can place text from template or database over image using CSS
- currency and prices -- just use conversion with fixed conversion rate, or download the rate from your bank
- used units (e.g. weight, distance, speed) -- also use conversion and store data using one base system
- CSS -- some languages have very long words e.g. german or different text direction

There are libraries which can take care of static texts in templates, number and date formatting (usually part of
bigger frameworks). They usually work with an identifier of a message and translation files for different languages.
You can configure formatting in config files.

{: .note}
Taking care of application in multiple languages is much more difficult than taking care of single language application.
You have to publish all content multiple times and respond to users from multiple cultures.

## Translating static messages
Static messages in templates are often identified with some condensed version of given message. The disadvantage is
that you have to write down all identifiers and translate them manually. It can also be a bit confusing that you need
to word with multiple files at a time. Here is a small example of template from a multilingual application written
in Laravel framework:

~~~ html
@extends('layout')
@section('content')
    <!-- instead of actual message, an identifier is used -->
    <h1>@lang('app.login')</h1>
    ...
@endsection
~~~

The translation file `en/app.php` for English:

~~~ php
<?php
return [
    'login' => 'Sign in',
    'logout' => 'Sign out',
    '...' => '...'
];
~~~

The translation file `cs/app.php` for Czech:

~~~ php
<?php
return [
    'login' => 'Přihlášení',
    'logout' => 'Odhlášení',
    '...' => '...'
];
~~~

The `@lang` directive takes message under key `login` from file `app.php`. There are multiple copies of such file
located in language specific folders with same keys but different translations of messages. Latte templating engine
uses [*underscore macro*](https://doc.nette.org/en/2.4/localization) for translations. There is also a underscore
function in Laravel.

## Using filters or directives to convert values
Use filters or directives (depends on what your templating system calls it) for given currency or unit transformations.
An example from Laravel framework application is presented again:

First, register template *directives* in `AppServiceProvider.php`:

~~~ php?start_inline=1
Blade::directive('liquidVolume', function ($expression) {
    return "<?php echo App\Helpers\LocalisationHelper::liquidVolume($expression); ?>";
});
Blade::directive('date', function ($expression) {
    return "<?php echo App\Helpers\LocalisationHelper::date($expression); ?>";
});
~~~

A `LocalisationHelper` class defined in `LocalisationHelper.php` file:

~~~ php?start_inline=1
class LocalisationHelper {
    //convert litres to gallons when locale of the application is set to `en`
    static function liquidVolume($vol) {
        if (App::isLocale('en')) {
            //litres to gallons
            return $vol / 3.785; 
        } else {
            return $vol;
        }
    }
    //apply date format specific for actual locale
    static function date($ts) {
        $locale = App::getLocale();
        //read format from config file
        $format = config('app.date_' . $locale);
        return date($ts, $format);
    }
} 
~~~

Finally, in the template, you can use them like this:

~~~ html
@extends('layout')
@section('content')
    <p>
        <!-- the unit is taken from translations -->
        @liquidVolume($info['volume']) @lang('units.liquidVolume')
        @date($info['date_of_production'])
    </p>
@endsection
~~~

## Database design
There are two possible types of internationalisation:
- application that runs in just one language but can be switched to another in its configuration (i.e. company
  information system)
- application that runs in multiple languages (i.e. presentation of international company, e-shop, etc.)

That second type is problematic as it requires storing multiple language versions of entities in one database. You have
to prepare special translation tables/columns for all entities.

Here are four examples of possible database design approaches, you can choose between individual language tables/columns
or more universal solution where you can add another language version without database structure modification.
You can either store the information about the language *as data* or *as database structure*. It depends on whether
you know the amount of languages or not before you start coding. These examples use table called *product*, imagine
that you are developing international e-commerce application.

- This version has individual content for each language -- this may be advantageous and required. Adding or removing
  a language means that you need to modify the database, but it is just whole tables (you can create a script
  for it).

  ![Translation of products 1](/articles/web-applications/db-translations-1.png)

- This is a variant where everything is stored in one table with language column which identifies the language version.
  This allows independent language versions of entities and there is no need to modify database when you want
  to add or remove a language.
  
  ![Translation of products 2](/articles/web-applications/db-translations-2.png)

- This version stores all multilingual content in one table. It is easy to design and easy to query, but adding or
  removing a language is almost impossible (you have to modify all tables and add/remove many columns). It is also
  impossible to have different entities for different languages.
  
  ![Translation of products 3](/articles/web-applications/db-translations-3.png)

- This approach has extra translation table where each row contains messages for different language. This approach
  does not require database modifications for adding/removing a language. It is possible to hide some content
  for given language (just use `JOIN` instead of `LEFT JOIN` when fetching translations -- untranslated items will not
  show up). Notice that default/fallback and common values are in the base table.

  ![Translation of products 4](/articles/web-applications/db-translations-4.png)

You may need to use combinations of these approaches, e.g.: approach 1 or 2 for publishing news articles (you want
different articles for different markets) and approach 3 or 4 for storing e-shop products (you want to sell same
items to all markets).

## Switching languages
Current language should be determined by part of URL, e.g.: `http://your-application.com/en/rest/of/url` in a web
application. Do not use cookies or session to store language -- what would happen after sending a link via email
to another computer?

{: .note}
You can use browser sent HTTP headers to determine the preferred language of the visitor. This can even be taken
care of in `.htaccess` file, but only when the URL language prefix is not present. Allow the visitor to override your
choice.

You probably saw language switcher in many applications, just generate `<a>` tag with different language prefix
in URL and add image of national flag. The problematic part is whether you can implement switching between languages
inside your application: do you have same URLs and same entity IDs for all languages or not? This depends on the design
of database. If not, just redirect to index page in different language.

The setting of application internal locale (another name for "global variable with current language") can be carried
out by a *middleware* associated with that language prefix of URL.

## Summary
Internationalisation and localisation are processes that will allow you to sell your product worldwide and some of
your customers will require you to deliver these features into your products. Be careful during designing of the
application and discuss with users/customers what they really want. Changes are very difficult to carry out.

I used Laravel based application in previous examples because our Slim based stack is not prepared for localisation
at all. It should not be very difficult to define custom filters for Latte and setup translations source for
underscore macro but for serious multilingual application, a full-featured framework like Laravel, Symphony or Nette
would be a better choice. I just needed a suitable example to present the general idea.

### New Concepts and Terms
- I18N
- L10N
