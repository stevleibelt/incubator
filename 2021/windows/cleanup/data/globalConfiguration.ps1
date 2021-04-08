#!/usr/bin/env pwsh
####
# Global Configuration File
####
# @see:
#   https://github.com/Bromeego/Clean-Temp-Files/blob/master/Clear-TempFiles.ps1
# @since 2021-04-07
# @author stev leibelt <artodeto@bazzline.net>
####

#bo: general variable section
$lockFilePath = ($PSScriptRoot + "\CleanUpSystem.lock")
$logFilePath = ($PSScriptRoot + "\log\" + $currentDate + ".log")
#eo: general variable section

#bo: path section
$collectionOfTruncableObjects.Add((Create-TruncableObject 'C:\Users\$user\...' 7 $true 32)) | Out-Null
#eo: path section