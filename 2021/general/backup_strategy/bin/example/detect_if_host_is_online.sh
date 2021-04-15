#!/bin/bash
####
# Demo script to detect if host is online
####
# [@param: string IP_ADDRESS_OR_HOSTNAME_TO_CHECK]
# @since 2021-04-15
# @author stev leibelt <artodeto@bazzline.net>
####

function detect_if_host_is_online ()
{
    local IP_ADDRESS_OR_HOSTNAME_TO_CHECK="${1:-192.168.178.1}"

    if ping -c 1 -q "${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}" >&/dev/null;
    then
        echo ":: >>${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}<< is online."
    else
        echo ":: >>${IP_ADDRESS_OR_HOSTNAME_TO_CHECK}<< is offline."
    fi
}

detect_if_host_is_online $@
