#!/bin/bash
####
# @author stev leibelt artodeto@bazzline.net
# @since 2016-10-22
####

create_directory_if_not_exists ()
{
    DIRECTORY_PATH="${1}"

    if [[ ! -d ${DIRECTORY_PATH} ]];
    then
        echo ":: creating directory ${DIRECTORY_PATH}"
        mkdir -p ${DIRECTORY_PATH}
    fi
}

#@todo use 
download_file ()
{
    EPISODE_NUMBER="${1}"
    YEAR_OF_RELEASE_DATE="${2}"

    FILE_NAME="alternativlos-${EPISODE_NUMBER}.mp3"
    FILE_PATH="${YEAR_OF_RELEASE_DATE}/${FILE_NAME}"

    if [[ ! -f "${FILE_PATH}" ]];
    then
        wget --quiet "http://alternativlos.cdn.as250.net/${FILE_NAME}"
        create_directory_if_not_exists "${YEAR_OF_RELEASE_DATE}"

        mv "${FILE_PATH}" "${YEAR_OF_RELEASE_DATE}/${FILE_PATH}"
    fi
}

echo ":: Please choose your prefered format."
echo "   0) mp3   1) ogg   2) opus"
read SELECTED_FORMAT_INDEX

case ${SELECTED_FORMAT_INDEX} in
    0)  FEED_URL="http://alternativlos.org/alternativlos.rss"
        ;;
    1)  FEED_URL="http://alternativlos.org/ogg.rss"
        ;;
    2)  FEED_URL="http://alternativlos.org/opus.rss"
        ;;
    *)  echo ":: Invalid input!"
        exit 1;
        ;;
esac

FILE_NAME=""
PUBLISHING_YEAR=""

#current issue:
#   whitespaces in xml file are handled as new line
for FILE_NAME_OR_PUBLISHING_DATE in $(curl --silent "${FEED_URL}" | grep "guid\|pubDate")
do
    echo "current item: ${FILE_NAME_OR_PUBLISHING_DATE}"

    #if grep -q 'guid';
    #then
        #removing <guid>FILENAME</guid>
        #   <guid> has a length of 6 characters
        #   </guid> has a length of 7 characters
    #    FILE_NAME=${FILE_NAME_OR_PUBLISHING_DATE:6:-7}
    #    echo "file name: ${FILE_NAME}"
    #fi
    #else
        #slicing out the year from a string like: <pubDate>Wed, 04 Aug 2010 00:00:00 GMT</pubDate>
    #    PUBLISHING_YEAR=${FILE_NAME_OR_PUBLISHING_DATE:21:4}
    #    echo "publishing year: ${PUBLISHING_YEAR}"
    #fi
done

#YEAR_OF_RELEASE_DATE=$(ls -l ${FILE_PATH} | awk '{ print $8 }')
#@see
#   http://stackoverflow.com/questions/893585/how-to-parse-xml-in-bash
#   http://stackoverflow.com/questions/17333755/extract-xml-value-in-bash-script
#   http://unix.stackexchange.com/questions/83385/parse-xml-to-get-node-value-in-bash-script
