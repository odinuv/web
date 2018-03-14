#!/bin/bash
set -e

gitLastCommit=$(git show --summary --grep="Merge pull request")
if [[ -z "$gitLastCommit" ]]
then
    lastCommit=$(git log --format="%H" -n 1)
else
    echo "We got a Merge Request!"
    #take the last commit and take break every word into an array
    arr=(${gitLastCommit})
    #the 5th element in the array is the commit ID we need. If git log changes, this breaks. :(
    lastCommit=${arr[4]}
fi
echo ${lastCommit}

cd ../_site
filesChanged=$(find . -type f)
if [ ${#filesChanged[@]} -eq 0 ]; then
    echo "No files to update"
else
    COMMAND="set sftp:auto-confirm yes
    open -u $FTP_USER,$FTP_PASS $FTP_TARGET"
    for f in ${filesChanged}
    do
        #do not upload these files that aren't necessary to the site
        if [ "$f" != ".travis.yml" ] && [ "$f" != "deploy.sh" ] && [ "$f" != "test.js" ] && [ "$f" != "package.json" ]
        then
            COMMAND="$COMMAND
            put $f"
            #echo "Uploading $f"
            #curl --ftp-create-dirs -T ${f} -u ${FTP_USER}:${FTP_PASS} ${FTP_TARGET}/html/${f}
            #if [ $? -ne 0 ]; then
              #echo "Could not upload file" >&2
              #exit 1
            #fi
        fi
    done
    $COMMAND = "$COMMAND
    close
    exit"
    lftp -c "$COMMAND"
    if [ $? -ne 0 ]; then
        echo "File upload failed" >&2
    fi
fi
