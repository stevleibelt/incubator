# Backup strategy

Free as in freedom backup strategy supporting multiple clients and multiple hosts.

Changelog can be found [here](CHANGELOG.md).

# Problem to solve

Given are multiple clients that are not always online.
Given are clients where the backup have to be triggered manually (like mobilephones) or automatically (like linux systems).
Given is, that there is an always on machine that provices the destination for the clients and acts as a cache.
Given is, that there is a not always on machine that is the single source of truth (zfs mirror, ecc memory etc.).

# Idea to solve the problem

Each client has an ssh key.
The always on machine offeres a place via `smb` for each client.
The always on machine moves the uploaded files into a special "cached" directory, readable but not writeable by the clients.
The always on machine checks every x minutes if real backup machine is online. If this happens, the cached files will be transfered to the machine and a sync to the readable mirror is done.
The always on machine has a weekly backup on an offline medium.
The always on server has a weekly backup on an offline medium.
The real backup server has a monthly backup on an offline medium located in a different location.

# Example

Given is a client called "cliend01".
Given is the always on machine called "server01".
Given is the real backup machine called "backup01".

Given is the following read only path layout for the data on "server01" and "backup01".

```
media
|-image
    |-2019
    |-2020
    |-2021
|-video
    |-2019
    |-2020
    |-2021
```

"server01" offers the following write only path for "client01".

```
upoad/client01/media
|-image
|-video
```

"server01" has the following read only path acting as "cache" for "backup01"

```
cache/media
|-image
|-video
```

Whenever "client01" is uploading files to "server01", "server01" is using the filename (e.g. `IMG_20210405...`) to sort the file into the right cache path like `media/image/2021/2021_04/client01`.

"backup01" offers the following read only path for all clients.

```
media
|-image
    | -2019
    | -2020
    | -2021
|-video
    | -2019
    | -2020
    | -2021
```

"backup01" offeres the following write only path for "server01".

```
upload/server01/media
|-image
|-video
```

Whenever "backup01" is online, "server01" is uploading all files from is cached directory into the backup upload path.
"backup01" is moving the files into the read only path.
"server01" is synchronizing the read only path from "backup01" to "server01".
"server01" is checking if the offline medium is available and synchronizes the read only path to this once a week.
"backup01" is checking if the offline medium is available and synchronizes the read only path to this once a month.

# Steps to solve the problem

* read about ssh keys and systemd, automated cronjobs
    * sync to "server01"
    * sync to "backup01"
* read about how to deal with the cases
    * syncjobs stopped without reasons (does systemd handles pid locking and unlocking?)
    * there is a sync job still running
    * only start syncing when in the right wifi
* create script to move uploaded files into dedicated cached files
* create script to only sync new stuff from "backup01" to "server01"
* create a script that automatically syncs stuff when an offline media became online (mounted)
* create a script to check [data integrety over multiple hosts](https://duckduckgo.com/?t=ffab&q=check+data+integrety+over+multiple+hosts&ia=web)

# Future steps

* create configuration file to handle different destinations (like general shared media files plus private `$HOME`).

# Links

* https://wiki.archlinux.org/index.php/Rsnapshot
* https://wiki.archlinux.org/index.php/systemd
* https://wiki.archlinux.de/title/Beispiel_eines_vollautomatisierten_Backups
* https://wiki.archlinux.org/index.php/Full_system_backup_with_tar
* https://wiki.archlinux.org/index.php/System_backup
* https://wiki.archlinux.org/index.php/Synchronization_and_backup_programs
