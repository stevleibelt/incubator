# Systemd timer based rsync on a zfs system

* check if remote host exist `nc $HOST_IT_OR_NAME rsync`
* check if snapshot exits
* if so, delete it
* create zfs snapshot
* rsync from snapshot to remote host
* delete zfs snapshot

