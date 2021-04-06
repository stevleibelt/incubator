# Cleanup temporary or cached files

## General Idea

In general, it is easy to do.
You have to clean up system and user cache and temporary files.

At the end, you iterate over a big list of locations and delete the content of it.

```
#as example
Set-Location "C:\Users"
Remove-Item ".\*\Appdata\Local\Temp\*" -Force -Recurse -EA SilentlyContinue -Verbose

#or put all in a variable and do it at once
$ListOfPathsToCleanUp = @("C:\Windows\Temp\*", "C:\Users\*\Appdata\Local\Temp\*")
Remove-Item $ListOfPathsToCleanUp -Force -Recurse -EA SilentlyContinue -Verbose
```

You could even add a "age" of files you want to keep, e.g. "only keep files not older than 30 days in the download path".
You cold even add a "only keep one copy" of a file, e.g. calculate the checksum of big files to delete the duplicates (happens when a file is downloaded more than once).

Since you are running it in verbose mode, you can log the output and keep it for one week.

## Paths to clean up

You should clean files in the following user paths:

* `%appdata%MicrosoftTeams`
* Take a look to [Powershell/Clear_Browser_Caches](https://github.com/lemtek/Powershell/blob/master/Clear_Browser_Caches)
* `PS C:\Windows\system32>$tempfolders = @("C:\Windows\Temp\*", "C:\Windows\Prefetch\*", "C:\Documents and Settings\*\Local Settings\temp\*", "C:\Users\*\Appdata\Local\Temp\*")`
* `PS C:\Windows\system32>Remove-Item $tempfolders -force -recurse`
* Check [TempFileCleanup.bat](https://github.com/bmrf/tron/blob/master/resources/stage_1_tempclean/tempfilecleanup/TempFileCleanup.bat)

# Links

* [Clean Browser Cache and Recycle Bin](https://github.com/Bromeego/Clean-Temp-Files) - 20210406
* [How to clear your Microsoft Teams cache on Windows 10](https://www.onmsft.com/how-to/how-to-clear-your-microsoft-teams-cache-on-windows-10) - 20200428
