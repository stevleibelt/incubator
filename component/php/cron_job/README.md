# cron job php component

## idea

* one observer
* observer is running each minute (or faster if wished)
* observer is fetching entries with "next_run_at" <= now()
* observer is asking the subjects if a run is needed and provides information about
    * currently running crons
    * current time
    * history (?)

## general

* one cron job to chance the token every hour

## database tables

### cron

* id
* name
* parent_id
* run_at_day
* run_at_hour
* run_at_minute
* run_at_second
* token / access_key
* maximum_execution_time

### cron_queue

* id
* cron_id
* next_run_at
* status (0 offline, 1 running, 2 error)

### cron history / log

* id
* cron_id
* finished_at

## implementation / code

* CronAbstract
    * calculateNextRunAt()

* CronObserver
    * getAvailableCronJobsByInterval
    * checkAvailableCronJobs
        * has a valid finished_at
        * parent is not running
        * allowed process time is not reached
    * call available cron jobs

* CronSubject
    * validate if token is valid
    * write log / history
    * load fitting cron job / factory
    * execute cron job

# links

* https://github.com/Arbitracker/Periodic
