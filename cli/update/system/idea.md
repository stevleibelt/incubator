System Update
=============

Influenced by [roundcube installer](https://github.com/roundcube/roundcubemail/blob/master/bin/update.sh).

Core Functionalities
--------------------

* current version is a string in a version file
* update mechanism is defined in steps
* each update step has a "before", "at" and "after" section
* example steps are
* main steps are:
    * enable_maintenance
        * before - disable crons, send shutdown order to running process
        * at - link to static page
        * after - ?
    * update_files
        * before - delete cache
        * at - replace updated files
        * after - delete dead files
    * update_database
        * before - execute backup scripts
        * at - execute sql scripts
        * after - execute migration scripts and clean up dead data
    * disable_maintenance
        * before - ?
        * at - link back to dynamic page
        * after - enable crons
