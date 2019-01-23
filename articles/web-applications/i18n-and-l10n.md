---
title: Internationalisation and localisation
permalink: /articles/web-applications/i18n-and-l10n/
---

* TOC
{:toc}

There are applications which are used by people from different countries either together or individually (multiple
instances of same application). Your should be prepared for such requirement and know how to deliver such application.

You may encounter abbreviations L10N and I18N (numbers mean amount of letters between first and last letter).

Internationalisation is the ability of the application to work in multiple environments -- this has to be designed
and programmed in advance. It is not very difficult to design such application, but it is very hard to internationalize
existing application.

Localisation is the process of customising the application for different national environment -- this is done by
translating text messages and modifying config files etc. Localisation is usually not programming and can be done by
trained operator. You cannot localise application which is not internationalized.

What can be different among languages:

- static texts in templates
- texts in database
- number format
- data and time format
- plural form -- e.g. "1 beer", "N beers" VS "1 pivo", "2 piva", "5 piv" etc.
- images with texts -- try to avoid this, you can place text from template or database over image using CSS
- currency and prices -- just use conversion with fixed conversion rate, or download the rate from your bank
- CSS -- some languages have very long words e.g. german or different text direction

There are libraries which can take care of static texts in templates, number and date formatting (usually part of
bigger frameworks). They usually work with an identifier of a message and translation files for different languages.
You can configure formatting in config files.

{: .note}
Taking care of application in multiple languages is much more difficult than taking care of single language application.
You have to publish all content multiple times and respond to users from multiple cultures.

## Database design
There is two possible types of internationalisation:
- application that runs in just one language but can be switched to another in its configuration (i.e. company
  information system)
- application that runs in multiple languages (i.e. presentation of international company, e-shop, etc.)

That second type is problematic as it requires storing multiple language versions of entities in one database. You have
to prepare special translation tables/columns for all entities.

Here are three examples of possible database design approaches:

![Translation of products 1](/articles/web-applications/db-translations-1.png)

This version stores all multilingual content in one table. It is easy to design and easy to query, but adding or
removing a language is almost impossible (you have to modify all tables). It is also impossible to have different
content for different languages.

![Translation of products 2](/articles/web-applications/db-translations-2.png)

This version has individual content for each language (this may be advantageous and required). Adding or removing
a language still means that you need to modify the database, but it is just tables.

![Translation of products 3](/articles/web-applications/db-translations-3.png)

This approach has extra translation table where each row contains messages for different language. This approach
does not require database modifications for adding/removing a language. It is possible to hide some content
for given language (just use `JOIN` instead of `LEFT JOIN` when fetching translations).

## Switching languages
Current language should be determined by part of URL, e.g.: `http://your-application.com/en/rest/of/url` in a web
application. Do not use cookies or session to store language -- what would happen after sending a link via email
to another computer?

{: .note}
You can use browser headers to determine the preferred language of visitor.

You probably saw language switcher in many applications, just generate `<a>` tag with different language prefix
in URL and add image of national flag. The problematic part is whether you can implement switching between languages
inside your application: do you have same URLs and same entity IDs for all languages or not? This depends on the design
of database. If not, just redirect to index page in different language. 

## Summary
Internationalisation and localisation are processes that will allow you to sell your product worldwide and some of
your customers will require you to deliver these features into your products. Be careful during designing of the
application and discuss with users/customers what they really want. Changes are very difficult to carry out.

### New Concepts and Terms
- I18N
- L10N
