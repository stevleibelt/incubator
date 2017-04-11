# Apache Server Status Parser Component for PHP

This project aims to deliver an easy to use component to read the apache server status for a configured list of hosts and gain information about that.

This component is relying on the [apache mod_status](https://httpd.apache.org/docs/2.2/mod/mod_status.html) and the undocumented query "[?notable](https://www.cyberciti.biz/faq/apache-server-status/)" ("?auto" does not contain information about the pid).

# Project Goals

* provides simple access to process information (deals with strings)
* provides detailed access to all information (building a lot of objects)

# Why?

Let me give you an scenario I got on my desk and had to solve it.

## Given

As a maintainer of an infrastructure with multiple apache HTTP servers, I need to know if a given process (identified by its pid, a infrastructure wide unique identifier and its uri) is still running or not.
Sometimes I know the IP Address of the server where process is running, mostly all I have is a pid, the unique identifier and the uri.
And finally, it is allowed to use the apache server status but no ssh command execution.

# How To Use

# Example

Examples are placed in the path <project root>/example. Because of the two implemented content fetchers, they are devide into the two categories "local" and "remote".

## Example Using Local File

```
#if no file path is provided, the shipped with example file will be used
#parse all
<project root>/example/local/parse_all.php [<path to the apache status file to parse>]
#parse detail only
<project root>/example/local/parse_detail_only.php [<path to the apache status file to parse>]
```

## Example Using Remote File

```
#if no file path is provided, the build in example url will be used
#parse all
<project root>/example/remote/parse_all.php [<url to the apache status page>]
#parse detail only
<project root>/example/remote/parse_detail_only.php [<url to the apache status page>]
```

# Current Status

* finished example
* finished implementation based on the example data

# Workflow

* fetch content
* split content into partials (use csplit?)
    * detail
    * information
    * scoreboard
    * statistic
* parse each partial into its fitting format (simple aka array or complex aka object)

# Models

* DomainModel\Detail
    * dynamic detail information about each worker
* DomainModel\Information
    * general static information about the environment
* DomainModel\Scoreboard
    * dynamic and general worker information
* DomainModel\Statistic
    * dynamic server statistic

# Future Improvements

## To Do

* add how to section
* create release history
* write unit test
    * DetailListOfLineParser
    * Processor
    * SectionStateMachine
    * ScoreboardListOfLineParser
    * StatisticListOfLineParser

## Done

* created
    * HttpFileFetcher
    * Service/Builder section
* example written
    * local (using FileFetcher)
        * parse all (uses the FullStorage)
        * parse detail only (uses the DetailOnlyStorage)
    * remote (using HttpFetcher)
        * parse all (uses the FullStorage)
* unit test written
    * DetailOnly
* parser and domain object written
    * information
    * scoreboard
    * statistic

# Notes

Thanks to:
* [mod_status_parser](https://github.com/nikos-glikis/mod_status_parser)
* [determine if an apache process is still running](http://artodeto.bazzline.net/archives/846-determine-if-an-apache-process-is-still-running-via-bash-to-prevent-multiple-instances-running.html)
* [apache for the cloud]()http://people.apache.org/~jim/presos/ACNA11/Apache_httpd_cloud.pdf
* [reading apache server status](https://answers.splunk.com/answers/28058/reading-apache-server-status-output.html)
* [Apache Server Status](https://www.phpclasses.org/browse/file/17516.html)
