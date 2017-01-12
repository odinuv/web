#/bin/bash
set -e

echo "Replacing links"
grep -rlF '](/en' ./en/ | xargs sed -i 's@](/en@](/~xpopelka/en@g'
echo "Replacing permalinks"
grep -rl 'permalink: /en' ./en/ | xargs sed -i 's@permalink: /en@permalink: /~xpopelka/en@g'
echo "Replacing menulinks"
grep -rl 'url: /en' ./_data/ | xargs sed -i 's@url: /en@url: /~xpopelka/en@g'
