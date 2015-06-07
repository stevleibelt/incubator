# CLI Backup Script

## Idea

* runs as cron (every x minutes/hours/days)
* checks if circumstances are given (like connected to a samba/nfs share etc.)
* writes "lock"
* backups configured sources to target
* removes "lock"
* updates "last.synchronized" file with current timestamp

## Dependencies

* [arguments](https://github.com/bazzline/php_component_cli_arguments)
* [commands](https://github.com/bazzline/php_component_command_collection)
* [lock](https://github.com/stevleibelt/php_component_lock)
* [progress bar](https://github.com/bazzline/php_component_cli_progress_bar)
* [process pipe](https://github.com/bazzline/php_component_process_pipe)
* [requirement](https://github.com/bazzline/php_component_requirement)
* optional
    * [memory limit](https://github.com/bazzline/php_component_memory_limit_manager)
    * [process fork](https://github.com/bazzline/php_component_process_fork_manager)
    * [time limit](https://github.com/bazzline/php_component_time_limit_manager)
