# cron job php component

## data structure

### configuration of a cron job

```
id: <string>
description: <string>
interval_of_repetition: <string>
execute_upfront: <null|string>
execute: <string>
execute_on_failure: <null|string>
initial_start_at: <string>
```

A scheduler is needed and has to be available inside the pre and post execution as well as the class to be executed.

### runtime created (tasks list)

```
id: <string>
cronjob_id: <string>
next_run_at: <datetime>
created_at: <datetime>
```

## idea

* queue based
* rest or bus based
* cronjobs with dependencies
* cronjobs with retry on error
* optional client library for
    * client status
    * dealing with multiple system where cronjob could be executed
    * dealing with per system based cronjobs
    * execute scripts via shell
* optional web ui
    * CRUD dealing with cronjobs
    * real time status output
    * history
* alerts
    * email
    * irc
    * slack(?)

# links

* https://www.archlinux.org/pacman/alpm-hooks.5.html
* https://wiki.archlinux.org/index.php/User:Allan/Pacman_Hooks
* https://www.freedesktop.org/software/systemd/man/systemd.service.html
* https://access.redhat.com/documentation/en-US/Red_Hat_Enterprise_Linux/7/html/System_Administrators_Guide/sect-Managing_Services_with_systemd-Unit_Files.html
* https://wiki.archlinux.org/index.php/Systemd
* https://wiki.archlinux.org/index.php/Systemd/Timers

# depcrecated

* one observer
* observer is running each minute (or faster if wished)
* observer is fetching entries with "next_run_at" <= now()
* observer is asking the subjects if a run is needed and provides information about
    * currently running crons
    * current time
    * repository (?)
* sobject could either be a
    * http call
    * process call

## general

* one cron job to change the token every hour

## database tables

### cronjobs

* id
* name
* run_at_day
* run_at_hour
* run_at_minute
* run_at_second
* token / access_key
* maximum_execution_time_in_seconds
* maximum_memory_usage_in_megabytes

### cronjob_queue

* id
* cronjob_id
* next_run_at
* status (0 offline, 1 running, 2 error)

### cronjob_process_list

* id
* cronjob_id
* started_at

### cron history / log

* id
* cronjob_id
* started_at
* finished_at

## implementation / code

* AbstractCronjob
    * calculateNextRunAt()

* Observer
    * getAvailableCronjobsByInterval
    * checkAvailableCrojJobs
        * has a valid finished_at
        * allowed process time is not reached
        * allowed memory usage is not reached
    * call available cronjobs

* Subject
    * validate if token is valid
    * write log / history
    * load fitting cronjob / factory
    * execute cronjob

# links

* https://github.com/Arbitracker/Periodic
