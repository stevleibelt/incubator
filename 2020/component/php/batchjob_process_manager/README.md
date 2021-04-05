# Batchjob Process Manager

## Idea

* simple calls REST-Endpoints to
    * start a batchjob (PUT)
    * stop a batchjob (DELETE)
    * get current status (GET)

# Workflow

* cronbased, the command 'bin/manager' is called
* the manager itself calls the commands
    * 'bin/get_list_of_processes'
    * 'bin/get_status_of_processes' (number of currently working, number of dead)
    * 'bin/remobe_dead_process'
    * 'bin/start_process'
