#!/bin/bash
set -e

COMMAND="set sftp:auto-confirm yes
open -u $FTP_USER,$FTP_PASS $FTP_TARGET
mirror --reverse --use-cache --overwrite --no-perms --no-umask --transfer-all --parallel=4 -vvv /code/docker/_site/ /html/
close
exit"

lftp -c "$COMMAND"
