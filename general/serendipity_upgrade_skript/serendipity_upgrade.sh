#!/bin/bash
####
# @author stev leibelt <artodeto@bazzline.net>
# @since 2016-09-26
# @see http://docs.s9y.org/docs/faq/index.html
# @todo
#   ask to make a database backup
#   move stuff into functions pre_deploy, deploy and post_deploy
####

function setup()
{
    #enable bash job support (fg & bg)
    set -o monitor
    CURRENT_DATE_AS_STRING=$(date +'%Y-%m-%d')
    CURRENT_INSTALLED_VERSION_SH512_SUM=current_installation.sha512
    CURRENT_WORKING_DIRECTORY=$(pwd)
    DIRECTORY_NAME_OF_NEW_VERSION="serendipity"
    FILE_NAME_OF_NEW_VERSION="latest.zip"
}

function circle_until_last_process_has_finished()
{
    ITERATOR=0
    LAST_STARTED_PROCESS_ID=$!

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

        sleept 0.5
    done

    #restore current curser position
    printf "\033[K"
    #wait
}

function output_usage_and_exit()
{
    echo ":: Usage:"
    echo "   "$(basename $0)"<path to the serendipity installation>"
    tear_down
    exit 1
}

function tear_down()
{
    if [[ -f ${FILE_NAME_OF_NEW_VERSION} ]];
    then
        rm ${FILE_NAME_OF_NEW_VERSION}
    fi

    cd ${CURRENT_WORKING_DIRECTORY}
}

setup

#ask for path to the installation (if not exist in current_installaton_path)

if [[ $# -lt 1 ]];
then
    echo ":: Mandatory parameter is missing!"
    output_usage_and_exit
fi

#begin of pre deployment
PATH_TO_THE_SERENDIPITY_INSTALLATION="$1"
PATH_TO_SWITCH_TO=$(dirname ${PATH_TO_THE_SERENDIPITY_INSTALLATION})
CONFIGURATION_FILE_NAME="serendipity_config_local.inc.php"
RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION=$(basename ${PATH_TO_THE_SERENDIPITY_INSTALLATION})
RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP="${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}.${CURRENT_DATE_AS_STRING}"
RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE="${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP}.tar.gz"

if [[ ! -d "${PATH_TO_THE_SERENDIPITY_INSTALLATION}" ]];
then
    echo ":: Invalid path to the serendipity installation provided!"
    echo ":: The path is not a directory."
    tear_down
    exit 3
fi

PATH_TO_THE_SERENDIPITY_CONFIGURATION_FILE="${PATH_TO_THE_SERENDIPITY_INSTALLATION}/${CONFIGURATION_FILE_NAME}"

if [[ ! -f "${PATH_TO_THE_SERENDIPITY_CONFIGURATION_FILE}" ]];
then
    echo ":: Invalid path to the serendipity installation provided!"
    echo ":: No configuration file found."
    tear_down
    exit 4
fi
#end of pre deployment

#begin of deployment
cd ${PATH_TO_SWITCH_TO}

#download from http://www.s9y.org/latest
echo ":: Downloading latest version."
wget --quet http://www.s9y.org/latest
#rename latest to latest.zip
mv latest ${FILE_NAME_OF_NEW_VERSION}

if [[ -f ${CURRENT_INSTALLED_VERSION_SH512_SUM} ]];
then
    #compare with current_installation.sha256
    #sha256sum latest.zip
    if sha512sum -c --quiet --status ${CURRENT_INSTALLED_VERSION_SH512_SUM};
    then
        echo ":: Newest version already installed."
        tear_down
        exit 0
    else
        rm ${CURRENT_INSTALLED_VERSION_SH512_SUM}
    fi
fi

#if differs, ask to do an installation

touch ${CURRENT_INSTALLED_VERSION_SH512_SUM}
sha512sum ${FILE_NAME_OF_NEW_VERSION} > ${CURRENT_INSTALLED_VERSION_SH512_SUM}

#create a backup
echo ":: Creating the backup ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE} ..."
tar -zcf ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE} ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}
circle_until_last_process_has_finished

#backup configuration file
cp ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}/${CONFIGURATION_FILE_NAME} .

#   unzip latest.zip
echo ":: Decompressing latest version ..."
circle_until_last_process_has_finished
unzip -qq ${FILE_NAME_OF_NEW_VERSION}
chmod -R 755 ${DIRECTORY_NAME_OF_NEW_VERSION}
rm -fr ${FILE_NAME_OF_NEW_VERSION}

#   mv latest $public
echo ":: Upgrading current installation ..."
cp -ru ${DIRECTORY_NAME_OF_NEW_VERSION}/* ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}
circle_until_last_process_has_finished
cp ${CONFIGURATION_FILE_NAME} ${DIRECTORY_NAME_OF_NEW_VERSION}/
#end of deployment

#begin of post deployment
#   ask to remove $public.yyyy-mm-dd or make a backup
echo ":: Do you want to keep the backup archive? [Y|n]"
read -p "   " YES_OR_NO

if [[ ${YES_OR_NO} == "n" ]];
then
    rm -fr ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP_ARCHIVE}
fi

echo ":: Done"
#end of post deployment
