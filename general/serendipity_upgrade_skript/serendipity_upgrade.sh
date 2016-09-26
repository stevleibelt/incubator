#!/bin/bash
####
# @author stev leibelt <artodeto@bazzline.net>
# @since 2016-09-26
# @see http://docs.s9y.org/docs/faq/index.html
# @todo ask to make a database backup
####

#ask for path to the installation (if not exist in current_installaton_path)
#download from http://www.s9y.org/latest
#rename latest to latest.zip
#sha256sum latest.zip
#compare with current_installation.sha256
#if differs, ask to do an installation
#   backup serendipity_config_local.inc.php
#   unzip latest.zip
#   mv $public $public.yyyy-mm-dd
#   mv latest $public
#   cp serendipity_config_local.inc.php $public/serendipity_config_local.inc.php
#   ask to remove $public.yyyy-mm-dd or make a backup
#       tar -zcf public.2016-09-26.tar.gz $public

function output_usage_and_exit()
{
    echo ":: Usage:"
    echo "   "$(basename $0)"<path to the serendipity installation>"
    exit 1
}

if [[ $# -lt 1 ]];
then
    echo ":: Mandatory parameter is missing!"
    echo ""
    output_usage_and_exit
fi

PATH_TO_THE_SERENDIPITY_INSTALLATION="$1"

if [[ ! -d {$PATH_TO_THE_SERENDIPITY_INSTALLATION} ]];
then
    echo ":: Invalid path to the serendipity installation provided!"
    echo ""
    output_usage_and_exit
fi

CURRENT_WORKING_DIRECTORY=$(pwd)
CURRENT_INSTALLED_VERSION_SH512_SUM=current_installation.sha512

cd ${PATH_TO_THE_SERENDIPITY_INSTALLATION}
cd ..

wget http://www.s9y.org/latest
mv latest latest.zip

if [[ -f ${CURRENT_INSTALLED_VERSION_SH512_SUM} ]];
then
    sha512sum latest.zip
fi
