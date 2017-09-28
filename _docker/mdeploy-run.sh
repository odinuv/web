#!/bin/bash
set -e

cd $TRAVIS_BUILD_DIR
./_docker/replace.sh
cp -f ./_includes/analytics-x.html ./_includes/analytics.html

cd ./_docker
docker-compose run --rm -e JEKYLL_ENV=production jekyll jekyll build

docker-compose run --rm deploy
