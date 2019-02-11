#!/bin/bash
set -e

echo "Starting mdeploy-run"

cd $TRAVIS_BUILD_DIR
./docker/replace.sh
cp -f ./_includes/analytics-x.html ./_includes/analytics.html

echo "Executing docker"

cd /code/docker/
docker-compose run --rm -e JEKYLL_ENV=production site bundle exec jekyll build --source /code/
docker-compose run --rm site /code/docker/mdeploy.sh
