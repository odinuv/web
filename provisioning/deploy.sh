#!/usr/bin/env bash
set -Eeuo pipefail

COMMAND="set sftp:auto-confirm yes
open -u $FTP_USER,$FTP_PASS $FTP_TARGET
mirror --reverse --overwrite --parallel=4 -v /code/_site/ /html/
exit"

lftp -c "$COMMAND"
