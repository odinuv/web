#!/bin/bash
set -e

echo "Setting _site writable"
sudo chmod -R 0777 $TRAVIS_BUILD_DIR/docker/_site
echo "Replacing links"
grep -rlF '](/' $TRAVIS_BUILD_DIR | xargs sed -i 's@](/@](/~'$MFTP_USER'/'$MFTP_PATH'/@g'
echo "Replacing permalinks"
grep -rl 'permalink: /' $TRAVIS_BUILD_DIR | xargs sed -i 's@permalink: /@permalink: /~'$MFTP_USER'/'$MFTP_PATH'/@g'
echo "Replacing menulinks"
grep -rl 'url: /' $TRAVIS_BUILD_DIR/_data/ | xargs sed -i 's@url: /@url: /~'$MFTP_USER'/'$MFTP_PATH'/@g'
grep -rl '#baseurl: "/~xpopelka/"' $TRAVIS_BUILD_DIR/_config.yml | xargs sed -i 's@#baseurl: "/~xpopelka/"@baseurl: "/~'$MFTP_USER'/'$MFTP_PATH'/"@g'
