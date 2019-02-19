#!/bin/bash
set -e

#COMMAND="set sftp:auto-confirm yes
#open -u $FTP_USER,$FTP_PASS $FTP_TARGET
#mirror --reverse --use-cache --overwrite --no-perms --no-umask --transfer-all --parallel=4 -vvv /code/docker/_site/ /html/
#close
#exit"

#lftp -c "$COMMAND"

date +%Y%m%d%H%M%S

upload_file() {
    if [ "$1" != ".travis.yml" ] && [ "$1" != "deploy.sh" ] && [ "$1" != "test.js" ] && [ "$1" != "package.json" ]
    then
        echo "Uploading $1" && curl --ftp-create-dirs -T "${1}" -u "${FTP_USER}":"${FTP_PASS}" "${FTP_TARGET}/html/${1}"
        if [ $? -ne 0 ]; then
          echo "Could not upload file" >&2
          exit 1
        fi
    fi    
}
export -f upload_file

cd /code/docker/_site/
#find . -type f -exec echo "Uploading {}" \;
#find . -type f -exec echo "Uploading $1" --exec curl --ftp-create-dirs -T "${1}" -u "${FTP_USER}":"${FTP_PASS}" "${FTP_TARGET}/html/${1}" {} \;
find . -type f -exec echo "Uploading {}" \; -exec curl --disable-epsv --ftp-method nocwd --ftp-pasv --ftp-create-dirs -T "{}" -u "${FTP_USER}":"${FTP_PASS}" "${FTP_TARGET}/html/{}" \;

#allFiles=$(find . -type f)
#for f in ${allFiles}
#do
#    #do not upload these files that aren't necessary to the site
#    if [ "$f" != ".travis.yml" ] && [ "$f" != "deploy.sh" ] && [ "$f" != "test.js" ] && [ "$f" != "package.json" ]
#    then
#        echo "Uploading $f"
#        curl --ftp-create-dirs -T "${f}" -u "${FTP_USER}":"${FTP_PASS}" "${FTP_TARGET}/html/${f}"
#        if [ $? -ne 0 ]; then
#          echo "Could not upload file" >&2
#          exit 1
#        fi
#    fi
#done

date +%Y%m%d%H%M%S
