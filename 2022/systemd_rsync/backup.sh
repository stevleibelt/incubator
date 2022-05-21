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
    #bo: user input validation
    if [[ ${#} -lt 1 ]];
    then
        echo ":: Invalid amount of arguments provided."
        echo "   ${0} <string: path to the configuration file>"
        echo ""

        exit 1
    fi
    #eo: user input validation

    #bo: variables
    local CURRENT_WORKING_DIRECTORY=$(pwd)
    local PATH_TO_THE_CONFIGURATION="${1:-}"

    if [[ -f "${PATH_TO_THE_CONFIGURATION}" ]];
    then
        . "${PATH_TO_THE_CONFIGURATION}"
    else
        echo ":: Invalid path provided."
        echo "   >>${PATH_TO_THE_CONFIGURATION}<< is not a file."
        echo ""

        exit 2
    fi
    #eo: variables

    #bo: environment check
    if [[ ! -f /usr/bin/netcat ]];
    then
        echo ":: >>/usr/bin/netcat<< not found."
        echo "   Please install it."
        echo ""

        exit 3
    fi

    if /usr/bin/netcat -z "${RSYNC_HOST}" "rsync"
    then
        _echo_if_be_verbose ":: Remote host >>${RSYNC_HOST}<< service >>rsync<< is available."
    else
        echo ":: Remote host service is not available >>${RSYNC_HOST}<<."
        echo ""

        exit 4
    fi
    #eo: environment check

    #bo: snapshot creation
    if [[ ${ZFS_IS_AVAILABLE} -eq 0 ]];
    then
        _delete_zfs_snapshot_if_exists
        _create_zfs_snapshot
        _mount_zfs_snapshot
        local RSYNC_SOURCE_PATH="${ZFS_MOUNT_POINT}${RSYNC_SOURCE_PATH}"
    fi
    #eo: snapshot creation

    #bo: backup process

    if [[ ${IS_DRY_RUN} -eq 1 ]];
    then
        _echo_if_be_verbose ":: Would have executed >>${RSYNC_COMMAND} \"${RSYNC_SOURCE_PATH}\" \"${RSYNC_DESTINATION}\"<<."
    else
        if [[ ! -d "${RSYNC_SOURCE_PATH}" ]];
        then
            echo ":: Invalid RSYNC_SOURCE_PATH."
            echo "   >>${RSYNC_SOURCE_PATH}<< is not a directory."
            echo ""

            exit 11
        fi

        if ${RSYNC_COMMAND} "${RSYNC_SOURCE_PATH}" "${RSYNC_DESTINATION}"
        then
            _echo_if_be_verbose ":: Could finish >>${RSYNC_COMMAND} ${RSYNC_SOURCE_PATH} ${RSYNC_DESTINATION}<<."
        else
            echo  ":: Could not finish >>${RSYNC_COMMAND} ${RSYNC_SOURCE_PATH} ${RSYNC_DESTINATION}<<."
            echo ""

            exit 10
        fi
    fi
    #eo: backup process

    if [[ ${ZFS_IS_AVAILABLE} -eq 0 ]];
    then
        _umount_zfs_snapshot
        _delete_zfs_snapshot_if_exists
    fi
    #bo: create snapshot

}

function _create_zfs_snapshot ()
{
    if [[ ${IS_DRY_RUN} -eq 1 ]];
    then
        _echo_if_be_verbose ":: Would have executed >>zfs snapshot -r \"${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}\"<<."
    else
        if zfs snapshot -r "${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}"
        then
            _echo_if_be_verbose ":: Create snapshot >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<<."
        else
            echo ":: Could not create snapshot >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<<."
            echo ""

            exit 6
        fi
    fi
}

function _delete_zfs_snapshot_if_exists ()
{
    if zfs list -t snapshot ${ZFS_DATASET} | grep -q "${ZFS_SNAPSHOT_NAME}"
    then
        _echo_if_be_verbose ":: Snapshot with the name >>${ZFS_SNAPSHOT_NAME}<< detected on pool >>${ZFS_DATASET}<<."
        _echo_if_be_verbose "   Deleting it."

        if [[ ${IS_DRY_RUN} -eq 1 ]];
        then
            _echo_if_be_verbose ":: Would have executed >>zfs destroy -r \"${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}\"<<."
        else
            if zfs destroy -r "${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}"
            then
                _echo_if_be_verbose ":: Deleted snapshot >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<<."
            else
                echo ":: Could not delete snapshot >>${ZFS_SNAPSHOT_NAME}<< on pool >>${ZFS_DATASET}<<."
                echo ""

                exit 7
            fi
        fi
    else
        _echo_if_be_verbose ":: Snapshot with the name >>${ZFS_SNAPSHOT_NAME}<< does not exist on pool >>${ZFS_DATASET}<<."
    fi
}

function _mount_zfs_snapshot ()
{
    if [[ ! -d "${ZFS_MOUNT_POINT}" ]];
    then
        if [[ ${IS_DRY_RUN} -eq 1 ]];
        then
            _echo_if_be_verbose ":: Would have executed >>mkdir \"${ZFS_MOUNT_POINT}\"<<."
        else
            if mkdir "${ZFS_MOUNT_POINT}"
            then
                _echo_if_be_verbose ":: Created mount point path >>${ZFS_MOUNT_POINT}<<."
            else
                echo ":: Could not create mount point path >>${ZFS_MOUNT_POINT}<<."

                exit 8
            fi
        fi
    fi

    if mount | grep -q "${ZFS_MOUNT_POINT}";
    then
        _echo_if_be_verbose ":: >>${ZFS_MOUNT_POINT}<< is already mounted."

        _umount_zfs_snapshot
    fi

    if [[ ${IS_DRY_RUN} -eq 1 ]];
    then
        _echo_if_be_verbose ":: Would have executed >>mount -t zfs \"${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}\" \"${ZFS_MOUNT_POINT}\"<<."
    else
        if mount -t zfs "${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}" "${ZFS_MOUNT_POINT}"
        then
            _echo_if_be_verbose ":: Mounted >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<< in >>${ZFS_MOUNT_POINT}<<."
        else
            echo ":: Could not mount >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<< in >>${ZFS_MOUNT_POINT}<<."
            echo ""

            exit 5
        fi
    fi
}

function _umount_zfs_snapshot ()
{
    if [[ ${IS_DRY_RUN} -eq 1 ]];
    then
        echo ":: Would have executed >>umount ${ZFS_MOUNT_POINT}<<."
    else
        if umount "${ZFS_MOUNT_POINT}"
        then
            _echo_if_be_verbose ":: Umounted >>${ZFS_MOUNT_POINT}<<."
        else
            echo ":: Could not umount >>${ZFS_MOUNT_POINT}<<."
            echo ""

            exit 9
        fi
    fi
}

_main "${@}"
