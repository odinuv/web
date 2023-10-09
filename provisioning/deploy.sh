#!/usr/bin/env bash
set -Eeuo pipefail

DIR_TO_UPLOAD='/code/_site/'
EXCLUDE_FILE='/code/provisioning/legacy_files.txt'
TMP_FILE='/tmp/upload_files.txt'
CMD_FILE='/tmp/commands.txt'
if [ "$1" == "full" ]; then
    find "$DIR_TO_UPLOAD" -type f > "$TMP_FILE"
else
    find "$DIR_TO_UPLOAD" -type f | grep -v -f "$EXCLUDE_FILE" > "$TMP_FILE"
fi

printf "pwd \n" > "$CMD_FILE"
while IFS= read -r line
do
    printf "put %s /html/%s\n" "$line" "$(realpath --relative-to=$DIR_TO_UPLOAD "$line")" >> "$CMD_FILE"
done < "$TMP_FILE"

printf "quit \n" >> "$CMD_FILE"

# cat "$CMD_FILE"
export SSHPASS=$FTP_PASS
sshpass -e sftp -oBatchMode=no -v -b "$CMD_FILE" -P 22 "$FTP_USER@$FTP_TARGET"

rm "$CMD_FILE"
rm "$TMP_FILE"
