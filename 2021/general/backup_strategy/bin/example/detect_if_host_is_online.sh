#!/bin/bash
####
# Demo script to detect if host is online
####
# [@param: string IP_ADDRESS_OR_HOSTNAME_TO_CHECK]
# [@param: string SSH_PUBLIC_KEY]
# @since 2021-04-15
# @author stev leibelt <artodeto@bazzline.net>
####

function detect_if_host_is_online ()
{
    local IP_ADDRESS_OR_HOSTNAME_TO_CHECK="${1:-192.168.178.1}"
    local SSH_PUBLIC_KEY="${2:-INVALID}"

    if ping -c 1 -q "${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}" >&/dev/null;
    then
        echo ":: >>${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}<< is online."
    else
        echo ":: >>${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}<< is offline."
    fi

    if [[ ${SSH_PUBLIC_KEY} != 'INVALID' ]];
    then
        if ssh-keyscan "${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}" | grep -q "${SSH_PUBLIC_KEY}"
        then
            echo ":: >>${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}<< does offer expected >>${SSH_PUBLIC_KEY}<<."
        else
            echo ":: >>${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}<< does not offer expected >>${SSH_PUBLIC_KEY}<<."
        fi
    fi
}

detect_if_host_is_online $@
