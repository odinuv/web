FROM ruby:2.3

COPY Gemfile Gemfile.lock /code/
WORKDIR /code

ENV LANG C.UTF-8
ENV LANGUAGE C.UTF-8
ENV LC_ALL C.UTF-8

RUN apt-get update -q \
    && apt-get install -y --no-install-recommends \
        default-jre \
        lftp \
        graphviz \
    && rm -r /var/lib/apt/lists/* \
    && gem install bundle \
    && gem install jekyll \
    && bundle install

COPY plantuml.jar /tmp/
COPY plantuml /usr/bin/
RUN gem install jekyll-plantuml
RUN chmod +x /usr/bin/plantuml
ENV GRAPHVIZ_DOT="/usr/bin/dot"

RUN echo Europe/Prague >/etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata
