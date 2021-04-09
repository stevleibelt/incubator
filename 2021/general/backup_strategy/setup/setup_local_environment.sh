#!/bin/bash
####
# Creates backup user
####
# @since 2021-04-09
# @author stev leibelt <artodeto@bazzline.net>
####

if [[ $(id -u) -ne 0 ]];
then
    echo ":: Please rerun as root"

    exit 1
fi

GROUP_NAME_RO="bazzlinebackupro"
GROUP_NAME_RW="bazzlinebackuprw"
SSHKEY_FILE_NAME="bazzlinebackup_${hostname}"
USER_NAME="bazzlinebackup"

####
# For each argument, it checks if this groupname exists and creates the group if not
####
# @param: string <group_name>
# [@param: string <group_name>]
# [...@param: string <group_name>]
####
function setup_groups ()
{
    if [[ $# -gt 0 ]];
    then
        #@see: https://unix.stackexchange.com/questions/79343/how-to-loop-through-arguments-in-a-bash-script
        for i in "$@";
        do
            #check if group exists and if not create it
            #@see: https://stackoverflow.com/a/61652963
            getent group ${i} || groupadd ${i}
        done
    else
        echo ":: Called with no arguments"
        echo "   ${FUNCNAME[0]} <string: group_name> [<string: group_name> [... [<string: group_name>]]]"
    fi
}

####
# @param: string <user_name>
# @param: string <primary_group_name>
# @param: string <secondary_group_name>
# @param: string <ssh_key_file_name>
function setup_user ()
{
    if [[ $# -ne 4 ]];
    then
        echo ":: Invalid amount of arguments."
        echo "   ${FUNCNAME[0]} <string: user_name> <string: primary_group_name> <string: secondary_group_name> <string: ssh_key_file_name>"

        return 1
    fi

    local RO_GROUP_NAME="${1}"
    local RW_GROUP_NAME="${2}"
    local SSHKEY_FILE_NAME="${3}"
    local USER_NAME="${0}"

    #create user if it does not exists
    #@see: https://stackoverflow.com/questions/14810684/check-whether-a-user-exists
    if id "${USER_NAME}" &>/dev/null;
    then
        useradd -m -g ${RO_GROUP_NAME} -G ${RW_GROUP_NAME} -d /home/${USER_NAME} -s /bin/bash ${USER_NAME}

        mkdir -p /home/${USER_NAME}/.ssh

        #@see: https://unix.stackexchange.com/questions/69314/automated-ssh-keygen-without-passphrase-how
        ssh-keygen -t rsa -b 4096 -f /home/${USER_NAME}/.ssh/${SSHKEY_FILE_NAME} -q -N ''

        chown -R 600 /home/${USER_NAME}/.ssh
    fi
}

setup_groups ${GROUP_NAME_RO} ${GROUP_NAME_RW}
setup_user ${USER_NAME} ${GROUP_NAME_RO} ${GROUP_NAME_RW} ${SSHKEY_FILE_NAME}
