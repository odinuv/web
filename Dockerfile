FROM ruby:3.2

RUN apt-get update -q \
    && apt-get install -y --no-install-recommends \
        default-jre \
        lftp \
        locales \
        graphviz \
    && rm -r /var/lib/apt/lists/* \
	&& echo "en_US UTF-8" > /etc/locale.gen \
	&& locale-gen en_US.UTF-8

COPY Gemfile Gemfile.lock /code/
WORKDIR /code

RUN bundle install

ENV LANG C.UTF-8
ENV LANGUAGE C.UTF-8
ENV LC_ALL C.UTF-8

RUN echo Europe/Prague > /etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata
