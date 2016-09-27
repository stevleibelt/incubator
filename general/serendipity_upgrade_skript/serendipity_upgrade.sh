#!/bin/bash
####
# @author stev leibelt <artodeto@bazzline.net>
# @since 2016-09-26
# @see http://docs.s9y.org/docs/faq/index.html
# @todo
#   ask to make a database backup
#   streamline variable names
#   move current_installation.sha512 into $HOME/.config/..
####

#begin of logical steps
function setup_static_variables()
{
    #enable bash job support (fg & bg)
    set -o monitor
    CURRENT_DATE_AS_STRING=$(date +'%Y-%m-%d')
    CURRENT_INSTALLED_VERSION_SH512_SUM="current_installation.sha512"
    DIRECTORY_NAME_OF_NEW_VERSION="serendipity"
    FILE_NAME_OF_NEW_VERSION="latest.zip"
    INITIAL_CURRENT_WORKING_DIRECTORY=$(pwd)
    SERENDIPITY_CONFIGURATION_FILE_NAME="serendipity_config_local.inc.php"
    URL_TO_LATEST_RELEASE="http://www.s9y.org/latest"
}

function validate_user_input_and_set_runtime_variables_or_exit()
{
    if [[ $# -lt 1 ]];
    then
        echo ":: Mandatory parameter is missing!"
        echo "Usage:"
        echo "   "$(basename $0)"<path to the serendipity installation>"
        cleanup
        exit 1
    fi

    PATH_TO_THE_SERENDIPITY_INSTALLATION="$1"
    CURRENT_WORKING_DIRECTORY=$(dirname ${PATH_TO_THE_SERENDIPITY_INSTALLATION})
    RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION=$(basename ${PATH_TO_THE_SERENDIPITY_INSTALLATION})
    RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP="${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}.${CURRENT_DATE_AS_STRING}"
    RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE="${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP}.tar.gz"

    if [[ ! -d "${PATH_TO_THE_SERENDIPITY_INSTALLATION}" ]];
    then
        echo ":: Invalid path to the serendipity installation provided!"
        echo "Provided path is not a directory."
        cleanup
        exit 3
    fi

    PATH_TO_THE_SERENDIPITY_CONFIGURATION_FILE="${PATH_TO_THE_SERENDIPITY_INSTALLATION}/${SERENDIPITY_CONFIGURATION_FILE_NAME}"

    if [[ ! -f "${PATH_TO_THE_SERENDIPITY_CONFIGURATION_FILE}" ]];
    then
        echo ":: Invalid path to the serendipity installation provided!"
        echo "Provided path does not contain a configuration file."
        cleanup
        exit 4
    fi
}

function prepare_deployment_or_exit()
{
    cd ${CURRENT_WORKING_DIRECTORY}

    #download from http://www.s9y.org/latest
    echo ":: Downloading latest version."
    wget --quiet ${URL_TO_LATEST_RELEASE} &
    circle_until_last_process_has_finished $!

    if [[ ! -f latest ]];
    then
        echo ":: Warning"
        echo "Could not download latest version from ${URL_TO_LATEST_RELEASE}."
        cleanup
        exit 5
    fi
    #rename latest to latest.zip
    mv latest ${FILE_NAME_OF_NEW_VERSION}

    if [[ -f ${CURRENT_INSTALLED_VERSION_SH512_SUM} ]];
    then
        #compare with current_installation.sha256
        #sha256sum latest.zip
        if sha512sum -c --quiet --status ${CURRENT_INSTALLED_VERSION_SH512_SUM};
        then
            echo ":: Newest version already installed."
            cleanup
            exit 0
        else
            rm ${CURRENT_INSTALLED_VERSION_SH512_SUM}
        fi
    fi
}

function deploy()
{
    #create checksum file
    touch ${CURRENT_INSTALLED_VERSION_SH512_SUM}
    sha512sum ${FILE_NAME_OF_NEW_VERSION} > ${CURRENT_INSTALLED_VERSION_SH512_SUM}

    #create a backup
    echo ":: Creating the backup ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE} ..."
    tar -zcf ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE} ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION} &
    circle_until_last_process_has_finished $!

    #backup configuration file
    cp ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}/${SERENDIPITY_CONFIGURATION_FILE_NAME} .

    #unpack latest version file
    echo ":: Decompressing latest version ..."
    unzip -qq ${FILE_NAME_OF_NEW_VERSION} &
    circle_until_last_process_has_finished $!
    chmod -R 755 ${DIRECTORY_NAME_OF_NEW_VERSION}
    rm -fr ${FILE_NAME_OF_NEW_VERSION}

    #update installation
    echo ":: Upgrading current installation ..."
    cp -ru ${DIRECTORY_NAME_OF_NEW_VERSION}/* ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION} &
    circle_until_last_process_has_finished $!

    #restore configuration file
    cp ${SERENDIPITY_CONFIGURATION_FILE_NAME} ${DIRECTORY_NAME_OF_NEW_VERSION}/
}

function postprocess_deployment()
{
    echo ":: Do you want to keep the backup archive? [Y|n]"
    read -p "   " YES_OR_NO

    if [[ ${YES_OR_NO} == "n" ]];
    then
        rm -fr ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE}
    fi
}

function cleanup()
{
    if [[ -f ${FILE_NAME_OF_NEW_VERSION} ]];
    then
        rm ${FILE_NAME_OF_NEW_VERSION}
    fi

    if [[ -d ${DIRECTORY_NAME_OF_NEW_VERSION} ]];
    then
        rm -fr ${DIRECTORY_NAME_OF_NEW_VERSION}
    fi

    if [[ -f ${SERENDIPITY_CONFIGURATION_FILE_NAME} ]];
    then
        rm ${SERENDIPITY_CONFIGURATION_FILE_NAME}
    fi

    #restore previous current working directory
    cd ${INITIAL_CURRENT_WORKING_DIRECTORY}
}
#end of logical steps

#begin of helper functions
function circle_until_last_process_has_finished()
{
    local ITERATOR=0
    local LAST_STARTED_PROCESS_ID=$1

    if [[ ! -z ${LAST_STARTED_PROCESS_ID} ]];
    then
        echo ""
        #store current curser position
        printf "\033[s"

        while ps -p ${LAST_STARTED_PROCESS_ID} | grep -q ${LAST_STARTED_PROCESS_ID};
        do
            if [[ ${ITERATOR} -eq 0 ]];
            then
                ((++ITERATOR))
                printf "\033[u[-]"
            elif [[ ${ITERATOR} -eq 1 ]];
            then
                ((++ITERATOR))
                printf "\033[u[\]"
            elif [[ ${ITERATOR} -eq 2 ]];
            then
                ((++ITERATOR))
                printf "\033[u[|]"
            else
                ((++ITERATOR))
                printf "\033[u[/]"
            fi

            sleep 0.5
        done

        #restore current curser position
        printf "\033[K"
        wait
        echo ""
    fi
}
#end of helper functions

#begin of main
setup_static_variables
validate_user_input_and_set_runtime_variables_or_exit $@
prepare_deployment_or_exit
deploy
postprocess_deployment
cleanup
#end of main
