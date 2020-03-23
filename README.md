# The Making of Web Application

An online book about web application development with tutorial. We use [PHP](http://php.net/) programming language and [Slim framework](http://www.slimframework.com/) with [Latte](https://github.com/nette/latte) templating engine to guide students through the process of building working web application which can be used to manage persons witch contacts, relationships and their meetings. The book also covers a lot of topics related to web development like SQL language and relational databases, CSS styles with [Bootstrap](https://getbootstrap.com/), security, REST API, Git etc.

You can find the book here: [odinuv.cz](https://odinuv.cz/)

# Contributing

You can open an issue or create pull request.

## Local development

The book is generally written in Markdown with some extensions - look for `.md` files. See [Jekyll](https://jekyllrb.com/)

### Running in Docker

This way is recommended because the application behind the book has a lot of dependencies

```
cd docker
docker-compose up
```

### Run

* `bundle exec jekyll serve`

Book will be available at http://localhost:4000
