# Batch Job component for PHP

The component will easy up handling of batch job processes.

## Main Ideas

* it is independent how a batch job is executed (url call, process forking, background process start, think about something else)
* the component defines the manager and the batch job itself, you only plug in your business logic
* the manager takes care to start the batch job
* everything is stored in queues

## Unsorted Ideas

* simple batch jobs
* manager tasks are split up
    * one job for choosing the upcoming running batch jobs
        * depending on maximum number of running threads per batch job type
            * depending on load (high, medium, low)
            * depending on cool down time
            * minimum amount of entries in queue
    * one job simple prepares the chunks per batch job type
    * one job to start the prepared chunks per batch job
* basic queue table
    * id
    * chunk_id
    * created_at
    * status
