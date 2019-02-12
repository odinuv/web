#!/bin/bash
set -e

COMMAND="set sftp:auto-confirm yes
open -u $FTP_USER,$FTP_PASS $FTP_TARGET
mirror -R -vvv /code/docker/_site/ /html/
close
exit"

lftp -c "$COMMAND"
