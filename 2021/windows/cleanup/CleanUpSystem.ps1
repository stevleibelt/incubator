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

Function CleanUpSystem {
    If (Test-IsAdministrator -eq $false) {
        Write-Host ":: You have to run this script as administrator."

        Exit
    }

    #todo
    #bo: variable definition
    ##@todo -> move into dedicated file
    $logFilePath = "c:\net.bazzline\CleanUpSystem\log"
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
