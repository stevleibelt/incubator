#!/bin/bash
####
# This is a working draft to create a simple backup strategy.
####
# @since 2022-04-19
# @author stev leibelt <artodeto@bazzline.net>
####

####
# @param <string: message which gets logged and maybe echoed>
# @param <string: log level>
####
function _log_and_echo_if_be_verbose ()
{
    if [[ ${BE_VERBOSE} -eq 1 ]];
    then
        echo "${1}"
    fi

    logger -i -p cron.${2} "${1}"
}

####
# @param <string: message to log and echo>
####
function _log_and_echo ()
{
    echo "${1}"

    logger -i -p cron.err "${1}"
}

####
# @param <string: message to log and echo>
# @param <int: exit code>
####
function _log_and_echo_and_exit ()
{
    _log_and_echo "${1}"

    exit "${2}"
}

function _main ()
{
    #bo: user input validation
    if [[ ${#} -lt 1 ]];
    then
        _log_and_echo ":: Invalid amount of arguments provided."
        _log_and_echo_and_exit "   ${0} <string: path to the configuration file> <string configuration section>" 1
    fi
    #eo: user input validation

    #bo: variables
    local CURRENT_WORKING_DIRECTORY=$(pwd)
    local CONFIGURATION_SECTION="${2:-default}"
    local CONFIGURATION_SECTION_LOADED=1
    local PATH_TO_THE_CONFIGURATION="${1:-}"

    if [[ -f "${PATH_TO_THE_CONFIGURATION}" ]];
    then
        . "${PATH_TO_THE_CONFIGURATION}"

        if [[ ${CONFIGURATION_SECTION_LOADED} -ne 0 ]];
        then
            _log_and_echo_and_exit "   Could not find and load section >>${CONFIGURATION_SECTION}<<." 2
        fi
    else
        _log_and_echo ":: Invalid path provided."
        _log_and_echo_and_exit "   >>${PATH_TO_THE_CONFIGURATION}<< is not a file." 3
    fi
    #eo: variables

    #bo: environment check
    if [[ ! -f /usr/bin/netcat ]];
    then
        _log_and_echo ":: >>/usr/bin/netcat<< not found."
        _log_and_echo_and_exit "   Please install it." 4
    fi

    if /usr/bin/netcat -z "${RSYNC_HOST}" "rsync"
    then
        _log_and_echo_if_be_verbose ":: Remote host >>${RSYNC_HOST}<< service >>rsync<< is available." "debug"
    else
        _log_and_echo_and_exit ":: Remote host service is not available >>${RSYNC_HOST}<<." 5
    fi
    #eo: environment check

    #bo: snapshot creation
    if [[ ${ZFS_IS_AVAILABLE} -eq 0 ]];
    then
        _umount_zfs_snapshot_if_needed
        _delete_zfs_snapshot_if_exists
        _create_zfs_snapshot
        _mount_zfs_snapshot
        local RSYNC_SOURCE_PATH="${ZFS_MOUNT_POINT}${RSYNC_SOURCE_PATH}"
    fi
    #eo: snapshot creation

    #bo: backup process

    if [[ ${IS_DRY_RUN} -eq 1 ]];
    then
        _log_and_echo_if_be_verbose ":: Would have executed >>${RSYNC_COMMAND} \"${RSYNC_SOURCE_PATH}\" \"${RSYNC_DESTINATION}\"<<." "debug"
    else
        if [[ ! -d "${RSYNC_SOURCE_PATH}" ]];
        then
            _log_and_echo ":: Invalid RSYNC_SOURCE_PATH."
            _log_and_echo_and_exit "   >>${RSYNC_SOURCE_PATH}<< is not a directory." 6
        fi

        if ${RSYNC_COMMAND} "${RSYNC_SOURCE_PATH}" "${RSYNC_DESTINATION}"
        then
            _log_and_echo_if_be_verbose ":: Could finish >>${RSYNC_COMMAND} ${RSYNC_SOURCE_PATH} ${RSYNC_DESTINATION}<<." "info"
        else
            _log_and_echo_and_exit  ":: Could not finish >>${RSYNC_COMMAND} ${RSYNC_SOURCE_PATH} ${RSYNC_DESTINATION}<<." 7
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
        _log_and_echo_if_be_verbose ":: Would have executed >>zfs snapshot -r \"${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}\"<<." "debug"
    else
        if zfs snapshot -r "${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}"
        then
            _log_and_echo_if_be_verbose ":: Create snapshot >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<<." "debug"
        else
            _log_and_echo_and_exit ":: Could not create snapshot >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<<." 8
        fi
    fi
}

function _delete_zfs_snapshot_if_exists ()
{
    if zfs list -t snapshot ${ZFS_DATASET} | grep -q "${ZFS_SNAPSHOT_NAME}"
    then
        _log_and_echo_if_be_verbose ":: Snapshot with the name >>${ZFS_SNAPSHOT_NAME}<< detected on pool >>${ZFS_DATASET}<<." "info"
        _log_and_echo_if_be_verbose "   Deleting it." "debug"

        if [[ ${IS_DRY_RUN} -eq 1 ]];
        then
            _log_and_echo_if_be_verbose ":: Would have executed >>zfs destroy -r \"${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}\"<<." "debug"
        else
            if zfs destroy -r "${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}"
            then
                _log_and_echo_if_be_verbose ":: Deleted snapshot >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<<." "debug"
            else
                _log_and_echo_and_exit ":: Could not delete snapshot >>${ZFS_SNAPSHOT_NAME}<< on pool >>${ZFS_DATASET}<<." 9
            fi
        fi
    else
        _log_and_echo_if_be_verbose ":: Snapshot with the name >>${ZFS_SNAPSHOT_NAME}<< does not exist on pool >>${ZFS_DATASET}<<." "info"
    fi
}

function _mount_zfs_snapshot ()
{
    if [[ ! -d "${ZFS_MOUNT_POINT}" ]];
    then
        if [[ ${IS_DRY_RUN} -eq 1 ]];
        then
            _log_and_echo_if_be_verbose ":: Would have executed >>mkdir \"${ZFS_MOUNT_POINT}\"<<." "debug"
        else
            if mkdir "${ZFS_MOUNT_POINT}"
            then
                _log_and_echo_if_be_verbose ":: Created mount point path >>${ZFS_MOUNT_POINT}<<." "debug"
            else
                _log_and_echo_and_exit ":: Could not create mount point path >>${ZFS_MOUNT_POINT}<<." 10
            fi
        fi
    fi

    _umount_zfs_snapshot_if_needed

    if [[ ${IS_DRY_RUN} -eq 1 ]];
    then
        _log_and_echo_if_be_verbose ":: Would have executed >>mount -t zfs \"${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}\" \"${ZFS_MOUNT_POINT}\"<<." "debug"
    else
        if mount -t zfs "${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}" "${ZFS_MOUNT_POINT}"
        then
            _log_and_echo_if_be_verbose ":: Mounted >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<< in >>${ZFS_MOUNT_POINT}<<." "info"
        else
            _log_and_echo_and_exit ":: Could not mount >>${ZFS_DATASET}@${ZFS_SNAPSHOT_NAME}<< in >>${ZFS_MOUNT_POINT}<<." 11
        fi
    fi
}

function _umount_zfs_snapshot ()
{
    if [[ ${IS_DRY_RUN} -eq 1 ]];
    then
        _log_and_echo_if_be_verbose ":: Would have executed >>umount ${ZFS_MOUNT_POINT}<<." "debug"
    else
        if umount "${ZFS_MOUNT_POINT}"
        then
            _log_and_echo_if_be_verbose ":: Umounted >>${ZFS_MOUNT_POINT}<<." "info"
        else
            _log_and_echo_and_exit ":: Could not umount >>${ZFS_MOUNT_POINT}<<." 12
        fi
    fi
}

function _umount_zfs_snapshot_if_needed ()
{
    if mount | grep -q "${ZFS_MOUNT_POINT}";
    then
        _log_and_echo_if_be_verbose ":: >>${ZFS_MOUNT_POINT}<< is already mounted." "info"

        _umount_zfs_snapshot
    fi
}

_main "${@}"
