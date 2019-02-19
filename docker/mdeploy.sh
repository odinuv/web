#!/bin/bash
set -e

echo "Started mdeploy script"

cd /code/docker/_site/
mkdir /code/docker/tmp/
mv /code/docker/_site/~$MFTP_USER/$MFTP_PATH/* /code/docker/tmp/
cp -r /code/docker/tmp/* /code/docker/_site/
filesChanged=$(find . -type f)
if [ ${#filesChanged[@]} -eq 0 ]; then
    echo "No files to update"
else
    echo "Start building LFTP command"
    COMMAND="set sftp:auto-confirm yes
open -u $MFTP_USER,$MFTP_PASS $MFTP_TARGET"
    for f in $filesChanged
    do
        #do not upload these files that aren't necessary to the site
        if [ "$f" != ".travis.yml" ] && [ "$f" != "deploy.sh" ] && [ "$f" != "test.js" ] && [ "$f" != "package.json" ]
        then
            echo "Appending file $f"
            COMMAND="$COMMAND
mput -d $f"
            #echo "Uploading $f"
            #curl -s --insecure --ftp-create-dirs -T $f -u $MFTP_USER:$MFTP_PASS $MFTP_TARGET/$f
            #if [ $? -ne 0 ]; then
              #echo "Could not upload file" >&2
              #exit 1
            #fi
        fi
    done
    COMMAND="$COMMAND
close
exit"
    echo "Executing LFTP command"
    lftp -c "$COMMAND"
    if [ $? -ne 0 ]; then
        echo "File upload failed" >&2
    fi
fi
