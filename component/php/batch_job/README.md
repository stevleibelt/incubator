# Batch Job component for PHP

The component will easy up handling of batch job processes.

## Main Ideas

* it is independent how a batch job is executed (url call, process forking, background process start, think about something else)
* the component defines the manager and the batch job itself, you only plug in your business logic
* the manager takes care to:
    * create the amount of work
    * split the amount of work into batches
    * start the right amount of jobs
* everything is stored in queues
* event based to hook easy up extension:
    * implement a support for a "current worker list / process list"
    * implement a support for a "worker history list"

## Terms

### Batch

* container for a batch of work
* contains:
    * id
    * items
    * size

### Worker / Job

* works with a batch
* implements WorkInterface
* this is the area where you put in your business logic

### Queue / List

* a list containing all available items for a given worker
* implements QueueInterface
* structure:
    * id
    * batch_id
    * status
    * created_at
    * processed_at

### Enqueuer / Loader / Stocker / Restocker / Refiller

* fills up queue with items
* implements EnqueueInterface

### Allocator

* assign available instances (servers or application instances) to the enqueued entries
    * can be done by server load
    * can be done by round robbin
    * can be reassigned if one machine is not available anymore

### Acquirer

* acquires / marks items in queue with a batch id
* implements AcquireInterface

### Releaser

* releases / unmarks items in queue from a batch id
* implements ReleaseInterface

## Available Requests (with reference implementation as console command)



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

### Worker History

* one entry per executed worker
* has a well defined WorkerHistoryItem
* is defined by a WorkerHistoryStorageInterface

### Worker List

* one entry per running worker
* has a well defined WorkerListItem
* is defined by a WorkerListStorageInterface

## Flow

* batch job reads configuration (all available batch jobs) and puts them into a queue
* batch job acquires one (or multiple) queued batch jobs and start batch jobs with chunk id working on the queue
* batch job executes batch job per queue and start acquirering until maximum number of queue workers is reached (based on system load and cool down) or no more items are available in the queue and finally starts the real queue worker

### Configuration

* id
* name
* batch_size
* priority
* high_load_parallel_process
* medium_load_parallel_process
* low_load_parallel_process
* number_of_seconds_for_cooldown

### process list

* id
* name
* current_batch_size
* maximum_batch_size
* created_at

### process history

* id
* name
* current_batch_size
* maximum_batch_size
* created_at
* finished_at
* memory_usage
