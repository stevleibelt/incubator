# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Open]

### To Add

* create setup section
    * create shell script that
        * creates the user `bazzlinebackup` - done
        * creates the group `bazzlinebackuprw` and `bazzlinebackupr` - done
        * creates ssh key - done
        * asks and creates backup path (store configuration in `/home/bazzlinebackup/.config/net_bazzline/backup/configuration.sh`
* create process section `sort`
    * move files from `upload` to `.ready_to_sort`
    * sort files from `.ready_to_sort` to `.ready_to_upload`
    * create systemd unit file that executes this script every 30 minutes
* create process section `upload`
    * shell script that checks if remote machine is online
    * shell script that rsyncs stuff from configured local source to configured remote destination
        * before rsyncing, move all data from `upload` to `.ready_to_upload` to prevent racecondition that something is uploaded while rest is synced (?)
        * use rsync or scp with flag to delete local files when upload is done
        * if needed, cleanup path `.ready_to_upload` after sucessful upload
* create process section `synchronize`
    * shell script that rsyncs local local source with remote source to fix local checksum errors
    * shell script that executes first script and executes following if machine is available
    * systemd unit file that executes previous shell script every 30 minutes

### To Change

* check if backupuser needs to be able to login
* check if acl instead of `u:g:o` can ease up permission handling
     * to enable the chance that the backup data is not only owned by group `bazzlinebackupr` but maybe also by another group
* implement automatic ssh key regeneration and rotation from source to destination

## [Unreleased]

### Added

### Changed
