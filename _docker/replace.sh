#/bin/bash
set -e

echo "Replacing links"
grep -rlF '](/' . | xargs sed -i 's@](/@](/~'$MFTP_USER'/'$MFTP_PATH'/@g'
echo "Replacing permalinks"
grep -rl 'permalink: /' . | xargs sed -i 's@permalink: /@permalink: /~'$MFTP_USER'/'$MFTP_PATH'/@g'
echo "Replacing menulinks"
grep -rl 'url: /' ./_data/ | xargs sed -i 's@url: /@url: /~'$MFTP_USER'/'$MFTP_PATH'/@g'
grep -rl '#baseurl: "/~xpopelka/"' ./_config.yml | xargs sed -i 's@#baseurl: "/~xpopelka/"@baseurl: "/~'$MFTP_USER'/'$MFTP_PATH'/"@g'
echo "Replacing slides link"
sed -i "s@<a href='/slides/'@<a href='"$MFTP_USER"/"$MFTP_PATH"/slides/'@g"