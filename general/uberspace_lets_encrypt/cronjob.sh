#!/bin/bash -l
####
# @see:
#   https://blog.uberspace.de/lets-encrypt-rollt-an/
#   https://wiki.uberspace.de/webserver:https?s[]=lets&s[]=encrypt
# @author: stev leibelt <artodeto@bazzline.net>
# @since: 2015-12-28
####

LOCAL_ROOT_PATH='/home/<user name>'
LOCAL_LOG_PATH=$LOCAL_ROOT_PATH'/<path to your log files>'
LOCAL_ACCOUNT='<your.domain.tld>'

letsencrypt-renewer --config-dir $LOCAL_ROOT_PATH'/.config/letsencrypt --logs-dir '$LOCAL_ROOT_PATH'/.config/letsencrypt/logs --work-dir '$LOCAL_ROOT_PATH'/tmp/' 1&2>$LOCAL_LOG_PATH
uberspace-prepare-certificate -k $LOCAL_ROOT_PATH'/.config/letsencrypt/live/'$LOCAL_ACCOUNT'/privkey.pem' -c $LOCAL_ROOT_PATH'/.config/letsencrypt/live/'$LOCAL_ACCOUNT'/cert.pem' 1&2>>$LOCAL_LOG_PATH
