# Systemd timer based rsync on a zfs system

## Setup

```
cp configuration.sh.dist configuration.sh
#adapt configuration.sh
```

## Usage

```
#assuming your configuration.sh contains a section for the user >>foo<<
./backup configuration.sh foo
```

## Done

* Added logging
* Added configuration section support

## To do

* add systemd timer
  * Let the user choose
    * [every 15 minutes](https://unix.stackexchange.com/questions/126786/systemd-timer-every-15-minutes)
    * every hour
    * once per day (15 minute after boot?)
* [Hardening](https://www.opensourcerers.org/2022/04/25/optimizing-a-systemd-service-for-security/) the systemd files
* write install.sh
* write uninstall.sh

