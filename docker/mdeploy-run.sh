#!/bin/bash
set -e

echo "Starting mdeploy-run"

cd $TRAVIS_BUILD_DIR
./docker/replace.sh
cp -f ./_includes/analytics-x.html ./_includes/analytics.html

echo "Executing docker"

cd ./docker
docker-compose run --rm -e JEKYLL_ENV=production jekyll jekyll build

docker-compose run --rm deploy
