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
    CONFIGURATION_FILE_NAME="serendipity_config_local.inc.php"
    CURRENT_DATE_AS_STRING=$(date +'%Y-%m-%d')
    CURRENT_INSTALLED_VERSION_SH512_SUM="current_installation.sha512"
    DIRECTORY_NAME_OF_NEW_VERSION="serendipity"
    FILE_NAME_OF_NEW_VERSION="latest.zip"
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

    CURRENT_WORKING_DIRECTORY=$(pwd)
    PATH_TO_THE_SERENDIPITY_INSTALLATION="$1"
    PATH_TO_SWITCH_TO=$(dirname ${PATH_TO_THE_SERENDIPITY_INSTALLATION})
    RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION=$(basename ${PATH_TO_THE_SERENDIPITY_INSTALLATION})
    RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP="${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}.${CURRENT_DATE_AS_STRING}"
    RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE="${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP}.tar.gz"

    if [[ ! -d "${PATH_TO_THE_SERENDIPITY_INSTALLATION}" ]];
    then
        echo ":: Invalid path to the serendipity installation provided!"
        echo "The path is not a directory."
        cleanup
        exit 3
    fi

    PATH_TO_THE_SERENDIPITY_CONFIGURATION_FILE="${PATH_TO_THE_SERENDIPITY_INSTALLATION}/${CONFIGURATION_FILE_NAME}"

    if [[ ! -f "${PATH_TO_THE_SERENDIPITY_CONFIGURATION_FILE}" ]];
    then
        echo ":: Invalid path to the serendipity installation provided!"
        echo "No configuration file found."
        cleanup
        exit 4
    fi
}

function prepare_deployment_or_exit()
{
    cd ${PATH_TO_SWITCH_TO}

    #download from http://www.s9y.org/latest
    echo ":: Downloading latest version."
    wget --quiet ${URL_TO_LATEST_RELEASE} &
    circle_until_last_process_has_finished $!

    if [[ ! -f latest ]];
    then
        echo ":: Warning"
        echo "Could not download latest version."
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
    touch ${CURRENT_INSTALLED_VERSION_SH512_SUM}
    sha512sum ${FILE_NAME_OF_NEW_VERSION} > ${CURRENT_INSTALLED_VERSION_SH512_SUM}

    #create a backup
    echo ":: Creating the backup ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE} ..."
    tar -zcf ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE} ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION} &
    circle_until_last_process_has_finished $!

    #backup configuration file
    cp ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}/${CONFIGURATION_FILE_NAME} .

    #   unzip latest.zip
    echo ":: Decompressing latest version ..."
    unzip -qq ${FILE_NAME_OF_NEW_VERSION} &
    circle_until_last_process_has_finished $!
    chmod -R 755 ${DIRECTORY_NAME_OF_NEW_VERSION}
    rm -fr ${FILE_NAME_OF_NEW_VERSION}

    #   mv latest $public
    echo ":: Upgrading current installation ..."
    cp -ru ${DIRECTORY_NAME_OF_NEW_VERSION}/* ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION} &
    circle_until_last_process_has_finished $!
    cp ${CONFIGURATION_FILE_NAME} ${DIRECTORY_NAME_OF_NEW_VERSION}/
}

function postprocess_deployment()
{
    #begin of post deployment
    #   ask to remove $public.yyyy-mm-dd or make a backup
    echo ":: Do you want to keep the backup archive? [Y|n]"
    read -p "   " YES_OR_NO

    if [[ ${YES_OR_NO} == "n" ]];
    then
        rm -fr ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE}
    fi
    #end of post deployment
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

    if [[ -f ${CONFIGURATION_FILE_NAME} ]];
    then
        rm ${CONFIGURATION_FILE_NAME}
    fi

    cd ${CURRENT_WORKING_DIRECTORY}
}
#end of logical steps

#begin of helper functions
function circle_until_last_process_has_finished()
{
    ITERATOR=0
    LAST_STARTED_PROCESS_ID=$1

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
validate_user_input_and_set_runtime_variables_or_exit
prepare_deployment_or_exit
deploy
postprocess_deployment
cleanup
#end of main
