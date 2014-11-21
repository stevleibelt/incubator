# Batch Job component for PHP

The component will easy up handling of batch job processes.

## Main Ideas

* it is independent how a batch job is executed (url call, process forking, background process, threads or think about something else)
* the component defines the manager and batch job components itself, all you need to do is to plug in your business logic
* the manager takes care of:
    * create the amount of work
    * split the amount of work into batches
    * start the right amount of jobs
* everything is stored in queues
* for version 1.1
    * event based to hook easy up extension:
        * implement a support for a "current processor list / process list"
        * implement a support for a "processor history list"

## Terms

### Batch

* container for a batch of work
* is arrayable (ArrayIterator|Traversable)
* implements BatchInterface
* contains:
    * id
    * item_id[] - collection of queue item ids
    * size

### Processor / Worker / Job

* works with a batch
* implements ProcessorInterface
* this is the area where you put in your business logic

### Queue / List

* a list containing all available item ids for a given processor
* a item id is an id referring to a item you have to process
* implements QueueInterface
* structure:
    * id
    * batch_id
    * item_id
    * status
    * created_at
    * processed_at

### Enqueuer / Loader / Stocker / Restocker / Refiller

* knows where to fetch items from
* fills up queue with item ids
* implements EnqueueInterface

### Instance

* representation of a physical/system endpoint (aka [web]server)

### Allocator

* assign available instances (servers or application instances) to the enqueued entries
    * can be done by server load
    * can be done by round robbin
    * can be reassigned if one machine is not available anymore

### Acquirer

* acquires / marks item ids in queue with a batch id
    * simple sets the batch_id for an amount of queue entries
    * with event handling, it can do more
* implements AcquireInterface

### Releaser

* releases / unmarks item ids in queue from a batch id
    * simple sets the batch_id for an amount of queue entries to NULL
    * with event handling, it can do more
* implements ReleaseInterface

## Available Requests (with reference implementation as console command)

* unique_id is the name in the configuration (see below)

* acquire-items-in-queue `<unique_id>` [`<batch size>`] [`<number of batches>` = 1]
* acquire-items-in-queues [`<batch size>`] [`<number of batches>` = 1]
* allocate-items-in-queue `<unique_id name>`
* allocate-items-in-queues
* enqueue-items-into-queue `<unique_id>`
* enqueue-items-into-queues
* process-items-in-queue `<unique_id>` [`<number of processors>` = 1] [--burst]
* process-items-in-queues [`<number of processors>` = 1] [--burst]
* release-items-in-queue `<unique_id>` [`<batch id>`]
* release-items-in-queues
* show-queue-status `<unique_id>` [`<filter>`]
* show-queues-status [`<filter>`]

## Unsorted Ideas

* use [uuid](https://packagist.org/packages/rhumsaa/uuid) to generate chunk ids
* simple batch jobs (fast, low memory footprint, runtime below a minute)
* manager tasks are split up
    * one job for choosing the upcoming running batch jobs
        * depending on maximum number of running threads per batch job type
            * depending on load (high, medium, low)
            * depending on cool down time
            * minimum amount of entries in queue
    * one job simple prepares the chunks per batch job type
    * one job to start the prepared chunks per batch job
* database connection is provided by injecting a PDO object (or take a look to [persistents interface](https://github.com/phly/PhlyRestfully))
* server load can be fetch by (can be implemented as batch job “update server load” also)
    * url endpoint
    * database table
* queue is a database table by default/as reference implementation
    * queues are managed in pure pdo-sql to increase speed and reduce memory footprint
* batch job can be paused (planned for version 1.3)
* use rest endpoints for url process calling (and provide example cli implementation for using the rest endpoints)
* the manager simple triggers the commands above by reading the configuration and using the right factories
    * everything is a batch job / processor represented by a queue
        * processor_queue_enqueuer  -> procesor_queue
        * enqueuer_queue_enqueuer   -> enqueuer_queue
        * acquire_queue_enqueuer    -> acquire_queue
        * release_queue_enqueuer    -> release_queue

### Processor History (planned for version 1.2)

* one entry per executed processor
* has a well defined ProcessorHistoryItem
* is defined by a ProcessorHistoryStorageInterface

### Processor List (planned for version 1.2)

* one entry per running processor
* has a well defined ProcessorListItem
* is defined by a ProcessorListStorageInterface

## Flow

* batch job reads configuration (all available batch jobs) and puts them into a queue
* batch job acquires one (or multiple) queued batch jobs and start batch jobs with chunk id working on the queue
* batch job executes batch job per queue and start acquirering until maximum number of queue processors is reached (based on system load and cool down) or no more items are available in the queue and finally starts the real queue processor

### Configuration

#### Default / General

* enabled: true
* priority: 50
* batch size: 100
* memory limit: 128MB
* runtime limit: 60
* number of processes on high load: 4
* number of processes on medium load: 10
* number of processes on low load: 20
* number of seconds between runs: 4
* database
    * database name
    * table prefix
    * user name
    * password
    * host


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
* database table name

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
