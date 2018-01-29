#/bin/bash
set -e

echo "Replacing links"
grep -rlF '](/' . | xargs sed -i 's@](/@](/~'$MFTP_USER'/@g'
echo "Replacing permalinks"
grep -rl 'permalink: /' . | xargs sed -i 's@permalink: /@permalink: /~'$MFTP_USER'/@g'
echo "Replacing menulinks"
grep -rl 'url: /' ./_data/ | xargs sed -i 's@url: /@url: /~'$MFTP_USER'/@g'
grep -rl '#baseurl: "/~xpopelka/"' ./_config.yml | xargs sed -i 's@#baseurl: "/~'$MFTP_USER'/"@baseurl: "/~'$MFTP_USER'/"@g'
