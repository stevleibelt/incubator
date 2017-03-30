# Apache Server Status Parser Component for PHP

This project aims to deliver an easy to use component to read the apache server status for a configured list of hosts and gain information about that.

This component is relying on the [apache mod_status](https://httpd.apache.org/docs/2.2/mod/mod_status.html) and the undocumented query [notable](https://www.cyberciti.biz/faq/apache-server-status/) (?auto does not contain information about the pid).

# Project Goals

* provides simple access to process information (deals with strings)
* provides detailed access to all information (building a lot of objects)

# Why?

Let me give you an scenario I got on my desk and had to solve it.

## Given

As a maintainer of an infrastructure with multiple apache HTTP servers, I need to know if a given process (identified by its pid, a infrastructure wide unique identifier and its uri) is still running or not.

# Current Status

* scribbling code in tryout.php
* finished first implementation of splitting content

# Workflow

* fetch content
* split content into partials (use csplit?)
    * information
    * statistics
    * scoreboard
    * details
* parse each partial into its fitting format (simple aka array or complex aka object)

# Models

* Server\Information
    * getBuilt
    * getMpm
    * Version
* Server\Statistic
    * getCurrentTime
    * getRestartTime
    * getUptime
    * getLoad
    * getTotalNumberOfRequests
    * getTotalNumberOfTraffic
* Server\Scoreboard
    * getNumberOfRequests
    * getNumberOf($filter)
    * asArray
* Server\Worker
    * getPid
    * getHttpMethod
    * getIpAddress
    * getUrl

# To Do

* write unit test
    * Processor
    * SectionStateMachine
* write parser and create domain object for
    * scoreboard
    * statistic
* write example

# Done

* write unit test
    * DetailOnly
* write parser and create domain object for
    * information

# Notes

Thanks to:
* [mod_status_parser](https://github.com/nikos-glikis/mod_status_parser)
* [determine if an apache process is still running](http://artodeto.bazzline.net/archives/846-determine-if-an-apache-process-is-still-running-via-bash-to-prevent-multiple-instances-running.html)
* [apache for the cloud]()http://people.apache.org/~jim/presos/ACNA11/Apache_httpd_cloud.pdf
* [reading apache server status](https://answers.splunk.com/answers/28058/reading-apache-server-status-output.html)
* [Apache Server Status](https://www.phpclasses.org/browse/file/17516.html)
