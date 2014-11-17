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
    * implement a support for a "current processor list / process list"
    * implement a support for a "processor history list"

## Terms

### Batch

* container for a batch of work
* contains:
    * id
    * items
    * size

### Processor / Worker / Job

* works with a batch
* implements ProcessorInterface
* this is the area where you put in your business logic

### Queue / List

* a list containing all available items for a given processor
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

* acquire-queue `<queue name>` [`<batch size>`] [`<number of batches>` = 1]
* acquire-queues [`<batch size>`] [`<number of batches>` = 1]
* allocate-queue `<queue name>`
* allocate-queues
* enqueue-into-queue `<queue name>`
* enqueue-into-queues
* process-queue `<queue name>` [`<number of processors>` = 1] [--burst]
* process-queues [`<number of processors>` = 1] [--burst]
* release-queue `<queue name>` [`<batch id>`]
* release-queues

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
* server load can be fetch by
    * url endpoint
    * database table
* rename it to "BatchD" :o)
* queue is a database table
* queues are managed in pure pdo-sql to increase speed and reduce memory footprint
* batch job can be paused

### Processor History

* one entry per executed processor
* has a well defined ProcessorHistoryItem
* is defined by a ProcessorHistoryStorageInterface

### Processor List

* one entry per running processor
* has a well defined ProcessorListItem
* is defined by a ProcessorListStorageInterface

## Flow

* batch job reads configuration (all available batch jobs) and puts them into a queue
* batch job acquires one (or multiple) queued batch jobs and start batch jobs with chunk id working on the queue
* batch job executes batch job per queue and start acquirering until maximum number of queue processors is reached (based on system load and cool down) or no more items are available in the queue and finally starts the real queue processor

### Configuration

#### Default

* enabled: true
* priority: 50
* batch size: 100
* memory limit: 128MB
* runtime limit: 60
* number of processes on high load: 4
* number of processes on medium load: 10
* number of processes on low load: 20
* number of seconds between runs: 4


#### Per Job

* unique name / unique id: string
* [enabled: boolean]
* [priority: integer]
* [batch size: integer]
* [memory limit: string]
* [runtime limit: integer]
* [number of processes on high load: integer]
* [number of processes on medium load: integer]
* [number of processes on low load: integer]
* [number of seconds between runs: integer]
* full qualified acquirer class name
* full qualified allocator class name
* full qualified processor class name
* full qualified releaser class name

### process list

?
* id
* name
* current_batch_size
* maximum_batch_size
* created_at

### process history

?
* id
* name
* current_batch_size
* maximum_batch_size
* created_at
* finished_at
* memory_usage
