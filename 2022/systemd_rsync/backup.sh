#!/bin/bash
####
# This is a working draft to create a simple backup strategy.
####
# @since 2022-04-19
# @author stev leibelt <artodeto@bazzline.net>
####

function _echo_if_be_verbose ()
{
    if [[ ${BE_VERBOSE} -eq 1 ]];
    then
        echo "${1}"
    fi
}

function _main ()
{
    #bo: variables
    local BE_VERBOSE=1
    local ZFS_DATASET="${1}"
    local ZFS_SNAPSHOT_NAME="rsync_backup"
    #eo: variables

    #bo: create snapshot
    if zfs list -t snapshot ${ZFS_DATASET} | grep -q "${ZFS_SNAPSHOT_NAME}"
    then
        _echo_if_be_verbose ":: Snapshot with the name >>${ZFS_SNAPSHOT_NAME}<< detected on pool >>${ZFS_DATASET}<<."
        _echo_if_be_verbose "   Deleting it."

        zfs destroy -r "${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}"

        if [[ ${?} -ne 0 ]];
        then
            echo ":: Could not delete snapshot >>${ZFS_SNAPSHOT_NAME}<< on pool >>${ZFS_DATASET}<<."
        fi
    fi

    zfs snapshot -r "${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}"
    #eo: create snapshot

    #bo: mount snapshot
    #eo: mount snapshot

    #bo: rsync content of snapshot to target
    #eo: rsync content of snapshot to target

    #bo: delete snapshot
    #eo: delete snapshot
}

#_main "${@}"
_main "br01"
