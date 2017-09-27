#/bin/bash
set -e

echo "Replacing links"
grep -rlF '](/' . | xargs sed -i 's@](/@](/~xpopelka/@g'
echo "Replacing permalinks"
grep -rl 'permalink: /' . | xargs sed -i 's@permalink: /@permalink: /~xpopelka/@g'
echo "Replacing menulinks"
grep -rl 'url: /' ./_data/ | xargs sed -i 's@url: /@url: /~xpopelka/@g'
grep -rl '#baseurl: "/~xpopelka/"' ./_config.yml | xargs sed -i 's@#baseurl: "/~xpopelka/"@baseurl: "/~xpopelka/"@g'
