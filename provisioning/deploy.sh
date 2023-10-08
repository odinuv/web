#!/usr/bin/env bash
set -Eeuo pipefail

COMMAND="set sftp:auto-confirm yes
open -u $FTP_USER,$FTP_PASS $FTP_TARGET
mirror --reverse --overwrite --parallel=4 -v /code/_site/ /html/
close
exit"

lftp -c "$COMMAND"
