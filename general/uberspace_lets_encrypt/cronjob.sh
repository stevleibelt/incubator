#!/bin/bash -l
####
# @see:
#   https://blog.uberspace.de/lets-encrypt-rollt-an/
#   https://wiki.uberspace.de/webserver:https?s[]=lets&s[]=encrypt
# @author: stev leibelt <artodeto@bazzline.net>
# @since: 2015-12-28
####

#begin of local parameters
LOCAL_ROOT_PATH='/home/<user name>'
LOCAL_LOG_PATH=$LOCAL_ROOT_PATH'/<path to your log files>'
LOCAL_ACCOUNT='<your.domain.tld>'
#end of local parameters

#begin of parameters for letsencrypt-renewer
LOCAL_CONFIGURATION_PATH=$LOCAL_ROOT_PATH'/.config/letsencrypt'
LOCAL_LOGGING_PATH=$LOCAL_ROOT_PATH'/.config/letsencrypt/logs'
LOCAL_WORING_PATH=$LOCAL_ROOT_PATH'/tmp/'
#end of parameters for letsencrypt-renewer

#begin of parameters for uperspace-prepare-certificate
LOCAL_KEY_PATH=$LOCAL_ROOT_PATH'/.config/letsencrypt/live/'$LOCAL_ACCOUNT'/privkey.pem'
LOCAL_CERTIFICATE_PATH=$LOCAL_ROOT_PATH'/.config/letsencrypt/live/'$LOCAL_ACCOUNT'/cert.pem'
#end of parameters for uperspace-prepare-certificate

letsencrypt-renewer --config-dir $LOCAL_CONFIGURATION_PATH --logs-dir $LOCAL_LOGGING_PATH --work-dir $LOCAL_WORING_PATH &>$LOCAL_LOG_PATH
uberspace-prepare-certificate -k $LOCAL_KEY_PATH -c $LOCAL_CERTIFICATE_PATH &>>$LOCAL_LOG_PATH
