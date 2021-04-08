﻿#!/usr/bin/env pwsh
####
# Global Configuration File
####
# @see:
#   https://github.com/Bromeego/Clean-Temp-Files/blob/master/Clear-TempFiles.ps1
# @since 2021-04-07
# @author stev leibelt <artodeto@bazzline.net>
####

#bo: general variable section
$beVerbose = $false
$globalLogLevel = 0  #@see: https://docs.microsoft.com/en-us/dotnet/api/microsoft.extensions.logging.loglevel?view=dotnet-plat-ext-5.0
$lockFilePath = ($PSScriptRoot + "\CleanUpSystem.lock")
$logDirectoryPath = ($PSScriptRoot + "\log\")
#eo: general variable section

#bo: path section
$collectionOfTruncableObjects.Add((Create-TruncableObject $logDirectoryPath 28)) | Out-Null

$collectionOfTruncableObjects.Add((Create-TruncableObject 'c:\Users\$user\AppData\Local\Mozilla\Firefox\Profiles\*.default\cache\*' 0)) | Out-Null
$collectionOfTruncableObjects.Add((Create-TruncableObject 'c:\Users\$user\Downloads' 30 $true 32)) | Out-Null
#eo: path section