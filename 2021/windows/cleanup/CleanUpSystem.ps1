#!/usr/bin/env pwsh
####
# Cleanup Window System
####
# @see:
#   https://github.com/Bromeego/Clean-Temp-Files/blob/master/Clear-TempFiles.ps1
# @since 2021-04-06
# @author stev leibelt <artodeto@bazzline.net>
####

Function Test-IsAdministrator {
    $currentUser = New-Object Security.Principal.WindowsPrincipal $([Security.Principal.WindowsIdentity]::GetCurrent())
    return $currentUser.IsInRole([Security.Principal.WindowsBuiltinRole]::Administrator)
}

Function Create-TruncableObject {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $false)]
        [int]$daysToKeepOldFiles = 1,

        [Parameter(Mandatory = $false)]
        [bool]$checkForDuplicates = $false,

        [Parameter(Mandatory = $false)]
        [int]$checkForDuplicatesGreaterThanMegabyte = 64
    )

    $properties = @{
        path = $path
        days_to_keep_old_file = $daysToKeepOldFiles
        check_for_duplicates = $checkForDuplicates
        check_for_duplicates_greater_than_megabyte = $checkForDuplicatesGreaterThanMegabyte
    }
    $object = New-Object psobject -Property $properties
    

    return $object
}

Function Add-TruncableObject {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [System.Collections.ArrayList]$collection,

        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $false)]
        [int]$daysToKeepOldFiles = 1,

        [Parameter(Mandatory = $false)]
        [bool]$checkForDuplicates = $false,

        [Parameter(Mandatory = $false)]
        [int]$checkForDuplicatesGreaterThanMegabyte = 64
    )

    $properties = @{
        path = $path
        days_to_keep_old_file = $daysToKeepOldFiles
        check_for_duplicates = $checkForDuplicates
        check_for_duplicates_greater_than_megabyte = $checkForDuplicatesGreaterThanMegabyte
    }
    $object = New-Object psobject -Property $properties

    $collection.Add($object) | Out-Null

    return $collection
}

Function Load-FileIfExists {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path
    )

    If ((Test-Path $path)) {
        . $path
    }
}

Function CleanUpSystem {
    If (Test-IsAdministrator -eq $false) {
        Write-Host ":: You have to run this script as administrator."

        Exit
    }

    #todo
    #bo: variable definition
    ##@todo -> move into dedicated file
    $currentDate = Get-Date -Format "yyyyMMdd"
    $collectionOfTruncableObjects = New-Object System.Collections.ArrayList
    $globalConfigurationFilePath = ($PSScriptRoot + "\data\globalConfiguration.ps1")
    $localConfigurationFilePath = ($PSScriptRoot + "\data\localConfiguration.ps1")
    $logFilePath = ($PSScriptRoot + "\log")
    $lockFilePath = ($PSScriptRoot + "\data\CleanUpSystem.lock")
    $logFilePath = ($PSScriptRoot + "\log\\" + $currentDate + ".log")

    Load-FileIfExists $globalConfigurationFilePath
    Load-FileIfExists $localConfigurationFilePath
    
    ForEach ($object In $collectionOfTruncableObjects) {
        Write-Host $("Path: " + $object.path)

        If ($object.days_to_keep) {
            Write-Host $("Days to keep: " + $object.days_to_keep)
        }
    }

    #check if we can create a function for this to be called like
    #create lock file
    #Add-TruncableObjectToCollection $collection "C:\Users\$user" 7 $true 64

    #eo: variable definition
    #define variables
    #   <string:> log file path
    #   <structur:> list of paths in a configurable way like, maybe put into a dedicated config.ps1 file
    #       {
    #           "C:\My\Path",   #path, should support wildcard $user
    #           7,  #optional: days to keep older files
    #           $true, #optional: check for duplicated files
    #           64, #optional: minimum file size to check for duplicated files
    #       }
    #   <int:> number of log files to keep
    #   <array:> $users
    #define functions
    #Log-Line
    #Log-DiskSpace  #to log disk space before and after the run
    #CleanUp-LogFiles   #keeps only the last x log files, plus checks if log file path exists
    #Truncate-Paths #iterates over structur, if path contains `$user`, iterate over content of `$users`

    #function to call
    #Log-DiskSpace
    #CleanUp-LogFiles
    #Truncate-Paths
    #Log-DiskSpace
}

CleanUpSystem
