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
        [string]$lockFilePath,

        [Parameter(Mandatory = $true)]
        [string]$logFilePath,

        [Parameter(Mandatory = $false)]
        [bool]$beVerbose
    )

    If (Test-Path $lockFilePath) {
        Write-Error ":: Error"
        Write-Error "   Could not aquire lock, lock file >>${lockFilePath}<< exists."
        Log-Error $logFilePath "Could not aquire lock. Lock file >>${lockFilePath}<< exists." $beVerbose

        Exit 1
    }

    New-Item -ItemType File $lockFilePath
    Set-Content -Path $lockFilePath -Value "${PID}"

    Log-Debug $logFilePath "Lock file create, path >>${lockFilePath}<<, content >>${PID}<<" $beVerbose
}

Function Release-LockFile {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$lockFilePath,

        [Parameter(Mandatory = $true)]
        [string]$logFilePath,

        [Parameter(Mandatory = $false)]
        [bool]$beVerbose
    )

    If (Test-Path $lockFilePath) {
        $lockFilePID = Get-Content -Path $lockFilePath

        If ($lockFilePID -eq $PID ){
            Remove-Item -Path $lockFilePath

            Log-Debug $logFilePath "Lock file removed, path >>${lockFilePath}<<" $beVerbose
        } Else {
            Write-Error ":: Error"
            Write-Error "   Lockfile in path >>${lockFilePath}<< contains different PID. Expected >>${PID}<<, Actual >>${lockFilePID}<<."
            Log-Error $logfilePath  "Lockfile in path >>${lockFilePath}<< contains different PID. Expected >>${PID}<<, Actual >>${lockFilePID}<<." $beVerbose
        }

        Exit 1
    } Else {
        Write-Error ":: Error"
        Write-Error "   Could not release lock. Lock file >>${lockFilePath}<< does not exists."
        Log-Error $logfilePath "Could not release lock. Lock file >>${lockFilePath}<< does not exists." $beVerbose

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

    $date = Get-Date -Format "yyyyMMdd"
    $pathToTheLogFile = '{0}\{1}_{2}.log' -f $path,$env:computername,$date

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
        [int]$logLevel = 3,

        [Parameter(Mandatory = $false)]
        [bool]$beVerbose
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

        Add-Content -Path $path -Value $logLine

        If ($beVerbose) {
            Write-Host $logLine -ForegroundColor DarkGray
        }
    }
}

Function Log-Debug {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $true)]
        [string]$message,

        [Parameter(Mandatory = $false)]
        [bool]$beVerbose
    )

    Log-Message $path $message 1 $beVerbose
}

Function Log-Info {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $true)]
        [string]$message,

        [Parameter(Mandatory = $false)]
        [bool]$beVerbose
    )

    Log-Message $path $message 2 $beVerbose
}

Function Log-Error {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $true)]
        [string]$message,

        [Parameter(Mandatory = $false)]
        [bool]$beVerbose
    )

    Log-Message $path $message 4 $beVerbose
}

Function Log-Diskspace {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [string]$path,

        [Parameter(Mandatory = $false)]
        [bool]$beVerbose
    )

    $logicalDisk = Get-WmiObject Win32_LogicalDisk | Where-Object { $_.DriveType -eq "3" }

    $totalSizeInGB = "{0:N1}" -f ( $logicalDisk.Size / 1gb)
    $freeSizeInGB = "{0:N1}" -f ( $logicalDisk.Freespace / 1gb )
    $freeSizeInPercentage = "{0:P1}" -f ( $logicalDisk.FreeSpace / $logicalDisk.Size )

    Log-Info $path "Drive: ${logicalDisk.DeviceID}, Total Size (GB) ${totalSizeInGB}, Free Size (GB} ${freeSizeInGB}, Free size in percentage ${freeSizeInPercentage}" $beVerbose
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
    Create-LockFileOrExit $lockFilePath $logFilePath $beVerbose

    Log-DiskSpace $logFilePath $beVerbose

    Truncate-Paths $collectionOfTruncableObjects $logFilePath $beVerbose

    Log-DiskSpace $logFilePath $beVerbose

    Release-LockFile $lockFilePath $logFilePath $beVerbose
    #eo: clean up
}

Function Truncate-Paths {
    [CmdletBinding()]
    param(
        [Parameter(Mandatory = $true)]
        [System.Collections.ArrayList]$collectionOfTruncableObjects,

        [Parameter(Mandatory = $true)]
        [string]$logFilePath,

        [Parameter(Mandatory = $false)]
        [bool]$beVerbose
    )
    
    ForEach ($object In $collectionOfTruncableObjects) {
        #check if path ends with a wildcard
        Log-Debug $logFilePath "Processing path >>${object.path}<<"

        If ($object.path -contains '$user') {
            Write-Host "Is a user path"
        } Else {
            Write-Host "Is not a user path"
        }
    }

}

CleanUpSystem
