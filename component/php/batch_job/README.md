# Batch Job component for PHP

The component will easy up handling of batch job processes.

## Main Ideas

* it is independent how a batch job is executed (url call, process forking, background process start, think about something else)
* the component defines the manager and the batch job itself, you only plug in your business logic
* the manager takes care to start the batch job
* everything is stored in queues

## Terms

### Batch

* contains id
* contains items
* contains size

### Enqueuer / Loader / Stocker / Restocker / Refiller

* fills up queue with items
* implements EnqueueInterface

### Allocator

* assign available instances (serversm or application instances) to the enqueued entries
    * can be done by server load
    * can be done by round robbin
    * can be reassigned if one machine is not available anymore

### Acquirer

* acquires / marks items in queue with a worker id
* implements AcquireInterface

### Releaser

* releases / unmarks items in queue
* implements ReleaseInterface

### Worker / Batch Job

* works with the acquired queue items
* implements WorkInterface

### Worker History

* one entry per executed worker
* has a well defined WorkerHistoryItem
* is defined by a WorkerHistoryStorageInterface

### Worker List

* one entry per running worker
* has a well defined WorkerListItem
* is defined by a WorkerListStorageInterface

## Unsorted Ideas

* use [uuid](https://packagist.org/packages/rhumsaa/uuid) to generate chunk ids
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

## Flow

* batch job reads configuration (all available batch jobs) and puts them into a queue
* batch job acquires one (or multiple) queued batch jobs and start batch jobs with chunk id working on the queue
* batch job executes batch job per queue and start acquirering until maximum number of queue workers is reached (based on system load and cool down) or no more items are available in the queue and finally starts the real queue worker

### Configuration

* id
* name
* chunk_size
* high_load_parallel_process
* medium_load_parallel_process
* low_load_parallel_process
* number_of_seconds_for_cooldown

### process list

* id
* name
* current_chunk_size
* created_at

### process history

* id
* name
* current_chunk_size
* created_at
* finished_at
* memory_usage
