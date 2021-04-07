#!/usr/bin/env pwsh
####
# Global Configuration File
####
# @see:
#   https://github.com/Bromeego/Clean-Temp-Files/blob/master/Clear-TempFiles.ps1
# @since 2021-04-07
# @author stev leibelt <artodeto@bazzline.net>
####

$collectionOfTruncableObjects.Add((Create-TruncableObject 'C:\Users\$user\...' 7 $true 32)) | Out-Null