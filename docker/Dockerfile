FROM ruby:2.6

COPY Gemfile Gemfile.lock /run/
WORKDIR /run

RUN apt-get update -q \
    && apt-get install -y --no-install-recommends \
        default-jre \
        lftp \
        locales \
        graphviz \
    && rm -r /var/lib/apt/lists/* \
	&& echo "en_US UTF-8" > /etc/locale.gen \
	&& locale-gen en_US.UTF-8 \    
    && gem install bundle \
    && gem install jekyll \
    && bundle install

ENV LANG C.UTF-8
ENV LANGUAGE C.UTF-8
ENV LC_ALL C.UTF-8

COPY plantuml.jar /tmp/
COPY plantuml /usr/bin/
RUN gem install jekyll-plantuml
RUN chmod +x /usr/bin/plantuml
ENV GRAPHVIZ_DOT="/usr/bin/dot"

RUN echo Europe/Prague > /etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata
 