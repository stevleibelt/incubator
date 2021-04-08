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

Function Create-LockFileOrExit {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path
    )

    If (Test-Path $path) {
        Write-Error ":: Error"
        Write-Error "   Could not aquire lock, lock file >>${path}<< exists."
        Log-Error "Could not aquire lock. Lock file >>${path}<< exists."

        Exit 1
    }

    New-Item -ItemType File $path
    Set-Content -Path $path -Value "${PID}"
}

Function Release-LockFile {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path
    )

    If (Test-Path $path) {
        $lockFilePID = Get-Content -Path $path

        If ($lockFilePID -eq $PID ){
            Remove-Item -Path $path
        } Else {
            Write-Error ":: Error"
            Write-Error "   Lockfile in path >>${path}<< contains different PID. Expected >>${PID}<<, Actual >>${lockFilePID}<<."
            Log-Error "Lockfile in path >>${path}<< contains different PID. Expected >>${PID}<<, Actual >>${lockFilePID}<<."
        }

        Exit 1
    } Else {
        Write-Error ":: Error"
        Write-Error "   Could not release lock. Lock file >>${path}<< does not exists."
        Log-Error "Could not release lock. Lock file >>${path}<< does not exists."

        Exit 2
    }
}


Function Get-LogFilePath {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path
    )

    If (!(Test-Path $path)) {
        New-Item -ItemType Directory -Force -Path $path
    }

    $dateTime = Get-Date -Format "yyyyMMdd-HHmmss"
    $pathToTheLogFile = '{0}\{1}_{2}.log' -f $path,$env:computername,$dateTime

    return $pathToTheLogFile
}

Function Log-Message {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $true)]
        [string]$message,

        [Parameter(Mandatory = $true)]
        [int]$logLevel = 3
    )

    If ($logLevel -ge $globalLogLevel) {
        Switch ($logLevel) {
            0 { $prefix = "[Trace]" }
            1 { $prefix = "[Debug]" }
            2 { $prefix = "[Information]" }
            3 { $prefix = "[Warning]" }
            4 { $prefix = "[Error]" }
            5 { $prefix = "[Critical]" }
            default { $prefix = "[None]" }
        }
        $dateTime = Get-Date -Format "yyyy-MM-dd HH:mm:ss"

        $logLine = '{0}: {1} - {2}' -f $dateTime,$prefix,$message

        Set-Content -Path $path -Value $logLine
    }
}

Function Log-Debug {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $true)]
        [string]$message
    )

    Log-Message $path $message 1
}

Function Log-Info {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $true)]
        [string]$message
    )

    Log-Message $path $message 2
}

Function Log-Error {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $true)]
        [string]$message
    )

    Log-Message $path $message 4
}

Function CleanUpSystem {
    If (Test-IsAdministrator -eq $false) {
        Write-Host ":: You have to run this script as administrator."

        Exit
    }

    #bo: variable definition
    $currentDate = Get-Date -Format "yyyyMMdd"
    $collectionOfTruncableObjects = New-Object System.Collections.ArrayList
    $globalConfigurationFilePath = ($PSScriptRoot + "\data\globalConfiguration.ps1")
    $localConfigurationFilePath = ($PSScriptRoot + "\data\localConfiguration.ps1")

    #We have to source the files here and not via a function.
    #  If we would source the files via a function, the sourced in variables would exist in the scope of the function only.
    If ((Test-Path $globalConfigurationFilePath)) {
        . $globalConfigurationFilePath
    }

    If ((Test-Path $localConfigurationFilePath)) {
        . $localConfigurationFilePath
    }

    $logFilePath = Get-LogFilePath $logDirectoryPath
    #eo: variable definition

    #bo: clean up
    Create-LockFileOrExit $lockFilePath
    
    ForEach ($object In $collectionOfTruncableObjects) {
        Write-Host $("Path: " + $object.path)

        If ($object.days_to_keep) {
            Write-Host $("Days to keep: " + $object.days_to_keep)
        }
    }

    #Log-Line
    Log-Message $logFilePath "Debug test" 1
    Log-Message $logFilePath "Error test" 4
    #Log-DiskSpace  #to log disk space before and after the run
    #CleanUp-LogFiles   #keeps only the last x log files, plus checks if log file path exists
    #Truncate-Paths #iterates over structur, if path contains `$user`, iterate over content of `$users`

    #function to call
    #Log-DiskSpace
    #CleanUp-LogFiles
    #Truncate-Paths
    #Log-DiskSpace

    Release-LockFile $lockFilePath
    #eo: clean up
}

CleanUpSystem
