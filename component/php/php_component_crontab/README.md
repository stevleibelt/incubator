# YAC - Yet Another Crontab for PHP

This crontab has to solve one issue, take care of missed cron's when the crontab has to be disabled (e.g. deployment).

## Idea

* do less not more
* simple data structure for each task
* one mothercron is just there to fetch the currently task and calls childrens to execute the task (non blocking event foo)
* support for strtotime expressions like "every first in the month"
* export to crontab format

## Data Structure

* id
* name
* command to execute
* initial_start_date
* interval_in_seconds
* next_run_date
