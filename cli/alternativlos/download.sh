#!/bin/bash
####
# @author stev leibelt artodeto@bazzline.net
# @since 2016-10-22
####

create_directory_if_not_exists ()
{
    DIRECTORY_PATH="$1"

    if [[ ! -d ${DIRECTORY_PATH} ]];
    then
        echo ":: creating directory ${DIRECTORY_PATH}"
        mkdir -p ${DIRECTORY_PATH}
    fi
}

#@todo use 
download_file ()
{
    EPISODE_NUMBER="$1"
    YEAR_OF_RELEASE_DATE="$2"

    FILE_NAME="alternativlos-{$EPISODE_NUMBER}.mp3"
    FILE_PATH="${YEAR_OF_RELEASE_DATE}/${FILE_NAME}"

    if [[ ! -f ${FILE_PATH} ]];
    then
        wget --quiet "http://alternativlos.cdn.as250.net/{$FILE_NAME}"
        create_directory_if_not_exists "${YEAR_OF_RELEASE_DATE}"

        mv "${FILE_PATH}" "${YEAR_OF_RELEASE_DATE}/${FILE_PATH}"
    fi
}

LIST_OF_FILE_NAME_AND_PUBLISHING_DATE=$(curl --silent "http://alternativlos.org/alternativlos.rss" | grep "guid\|pubDate")

FILE_NAME=""
PUBLISHING_YEAR=""

for FILE_NAME_OR_PUBLISHING_DATE in $(curl --silent "http://alternativlos.org/alternativlos.rss" | grep "guid\|pubDate")
do
    echo "${FILE_NAME_OR_PUBLISHING_DATE}"

    if [[ ${FILE_NAME} == "" ]];
    then
        FILE_NAME="${FILE_NAME_OR_PUBLISHING_DATE}"
    else
        PUBLISHING_YEAR="${FILE_NAME_OR_PUBLISHING_DATE}"
    fi
done

#YEAR_OF_RELEASE_DATE=$(ls -l ${FILE_PATH} | awk '{ print $8 }')
