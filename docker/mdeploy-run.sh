#!/bin/bash
set -e

echo "Starting mdeploy-run"

cd $TRAVIS_BUILD_DIR/docker/
./replace.sh
cp -f $TRAVIS_BUILD_DIR/_includes/analytics-x.html $TRAVIS_BUILD_DIR/_includes/analytics.html

echo "Executing docker"

docker-compose run --rm -e JEKYLL_ENV=production site bundle exec jekyll build --source /code/
docker-compose run --rm -e MFTP_PASS -e MFTP_PATH -e MFTP_TARGET -e MFTP_USER site /code/docker/mdeploy.sh
