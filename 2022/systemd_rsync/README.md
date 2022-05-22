# Systemd timer based rsync on a zfs system

## Setup

```
cp configuration.sh.dist configuration.sh
#adapt configuration.sh
```

## To do

* add systemd service
* add systemd timer
* find a way to inject user based configuration path
  * or support multi section configuration so we use the right section
* `if [[ ${SECTION} -eq "foo" ]];`
* `./backup configuration.sh foo`
* add logging

