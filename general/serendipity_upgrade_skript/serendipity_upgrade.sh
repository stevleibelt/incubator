#!/bin/bash
####
# @author stev leibelt <artodeto@bazzline.net>
# @since 2016-09-26
# @see http://docs.s9y.org/docs/faq/index.html
# @todo ask to make a database backup
####

CURRENT_DATE_AS_STRING=$(date '%Y-%m-%d')
CURRENT_INSTALLED_VERSION_SH512_SUM=current_installation.sha512
CURRENT_WORKING_DIRECTORY=$(pwd)
DIRECTORY_NAME_OF_NEW_VERSION="serendipity"
FILE_NAME_OF_NEW_VERSION="latest.zip"

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

#ask for path to the installation (if not exist in current_installaton_path)

if [[ $# -lt 1 ]];
then
    echo ":: Mandatory parameter is missing!"
    output_usage_and_exit
fi

PATH_TO_THE_SERENDIPITY_INSTALLATION="$1"
PATH_TO_SWITCH_TO=$(dirname ${PATH_TO_THE_SERENDIPITY_INSTALLATION})
CONFIGURATION_FILE_NAME="serendipity_config_local.inc.php"
RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION=$(basename ${$PATH_TO_THE_SERENDIPITY_INSTALLATION})
RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP="${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}.${CURRENT_DATE_AS_STRING}"

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

cd ${PATH_TO_SWITCH_TO}

#download from http://www.s9y.org/latest
wget http://www.s9y.org/latest
#rename latest to latest.zip
mv latest ${FILE_NAME_OF_NEW_VERSION}

if [[ -f ${CURRENT_INSTALLED_VERSION_SH512_SUM} ]];
then
    #compare with current_installation.sha256
    #sha256sum latest.zip
    if sha512sum -c --quiet --status ${CURRENT_INSTALLED_VERSION_SH512_SUM};
    then
        echo ":: Newest release already installed"
        tear_down
        exit 0
    else
        rm ${CURRENT_INSTALLED_VERSION_SH512_SUM}
    fi
fi

#if differs, ask to do an installation

touch ${CURRENT_INSTALLED_VERSION_SH512_SUM}
sha512sum ${FILE_NAME_OF_NEW_VERSION} > ${CURRENT_INSTALLED_VERSION_SH512_SUM}

#backup current installation
#   mv $public $public.yyyy-mm-dd
mv ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION} ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP}

#   unzip latest.zip

unzip ${FILE_NAME_OF_NEW_VERSION}
chmod -R 755 ${DIRECTORY_NAME_OF_NEW_VERSION}
#   mv latest $public
mv ${DIRECTORY_NAME_OF_NEW_VERSION} ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}

#   cp serendipity_config_local.inc.php $public/serendipity_config_local.inc.php
cp ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP}/${CONFIGURATION_FILE_NAME} ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION}/

#   ask to remove $public.yyyy-mm-dd or make a backup
echo ":: Do you want to keep the backup? [Y|n]"
read -p "   " YES_OR_NO

if [[ ${YES_OR_NO} != "n" ]];
then
    echo ":: Create a .tar.gz file from the backup? [Y|n]"
    read -p "   " YES_OR_NO

#       tar -zcf public.2016-09-26.tar.gz $public
    if [[ ${YES_OR_NO} != "n" ]];
    then
        tar -zcf ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP}.tar.gz ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP}
    fi
else
    rm -fr ${RELATIVE_PATH_TO_THE_SERENDIPITY_INSTALLATION_BACKUP}
fi
