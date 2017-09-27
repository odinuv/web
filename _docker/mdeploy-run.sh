#!/bin/bash
set -e

cd $TRAVIS_BUILD_DIR
$TRAVIS_BUILD_DIR/_docker/replace.sh

docker-compose run --rm -e JEKYLL_ENV=production jekyll jekyll build

docker-compose run --rm deploy
