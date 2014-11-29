# Batch Job component for PHP

The component will easy up handling of batch job processes.

## Main Ideas

* it is independent how a batch job is executed (url call, process forking, background process, threads or think about something else)
* the component defines the manager and internal components, all you need to do is to plug in your business logic
* the manager takes care of:
    * create the amount of work
    * split the amount of work into batches
    * start the right amount of jobs
* everything is stored in queues
* for version 1.2
    * event based to hook easy up extending:
        * implement a support for a "current processor list / process list"
        * implement a support for a "processor history list"

## Terms

### Batch Job

* collection or summary of
	* processor
    * queue
    * enqueuer
    * aqcuirer
    * releaser

### Batch

* container for a collection of items
* is arrayable (ArrayIterator|Traversable)
* implements BatchInterface
* represents a scoped view on a queue
* contains:
    * id
    * item_id[] - collection of references to items
    * size

### **Process** / Worker / Job

* works with a batch
* implements ProcessorInterface
* this is the area where you put your business logic

### **Queue** / List / Collection

* a list containing all available item ids for a given processor
* a item id is an id referring to a item you want to process
* implements QueueInterface
* structure:
    * id
    * batch_id
    * item_id
    * status_id
    * instance_id
    * created_at
    * processed_at

### **Enqueuer** / Loader / Stocker / Restocker / Refiller

* knows where to fetch items from
* fills up queue with item ids
* implements EnqueueInterface
* inserts item references into the queue 

### Acquirer

* acquires / marks item ids in queue with a batch id
    * simple sets the batch_id for an amount of queue entries
    * with event handling, it can do more
* implements AcquireInterface|LoadBalancerAwareInterface

### Releaser

* releases / unmarks item ids in queue from a batch id
    * simple sets the batch_id for an amount of queue entries to NULL
    * with event handling, it can do more
* implements ReleaseInterface|LoadBalancerAwareInterface

### Instance

* representation of a physical/system endpoint
	* [web]server
    * event loop
    * application

### Load Balancer / Instance Manager - v1.1

* assign available instances (servers or application instances) to the enqueued entries
    * can be done by server load
    * can be done by round robbin
    * can reassign batches to other instance (if one instance is not available anymore)
* implements AllocatorInterface|DeallocatorInterface

## Available Requests (with reference implementation as console command)

* unique_identifier is the name of an item in the configuration (see below)

* acquire-items-in-queue `<unique_identifier>` [`<batch size>`] [`<number of batches>` = 1]
* acquire-items-in-queues [`<batch size>`] [`<number of batches>` = 1]
* load-balance-items-in-queue `<unique_identifier>`
* load-balace-items-in-queues
* enqueue-items-into-queue `<unique_identifier>`
* enqueue-items-into-queues
* process-items-in-queue `<unique_identifier>` [`<number of processors>` = 1] [--burst]
* process-items-in-queues [`<number of processors>` = 1] [--burst]
* release-items-in-queue `<unique_identifier>` [`<batch id>`]
* release-items-in-queues
* show-queue-status `<unique_identifier>` [`<filter>`]
* show-queues-status [`<filter>`]
* manage `<unique_identifier>`

## Unsorted Ideas

* use [uuid](https://packagist.org/packages/rhumsaa/uuid) to generate batch ids
* simple batch jobs (fast, low memory footprint, runtime below a minute)
* manager tasks are split up
    * one job for choosing the upcoming running processors
        * depending on maximum number of running threads per processor
            * depending on load (high, medium, low)
            * depending on cool down time
            * minimum amount of entries in queue
    * one processor prepares the batches per unique_identifier
    * one processor tostarts the prepared chunks per unique_identifier
* database connection is provided by injecting a PDO object (or take a look to [persistents interface](https://github.com/phly/PhlyRestfully))
* server load can be fetch by (can be implemented as batch job “update server load” also)
    * url endpoint
    * database table
* queue is a database table by default/as reference implementation
    * queues are managed in pure pdo-sql to increase speed and reduce memory footprint
* batch job can be paused (planned for version 1.4)
* use rest endpoints for url process calling (and provide example cli implementation for using the rest endpoints - planned for version 1.5)
* the manager simple triggers the commands above by reading the configuration and using the right factories
    * everything is a batch job / processor represented by a queue
        * processor_queue_enqueuer  -> procesor_queue
        * enqueuer_queue_enqueuer   -> enqueuer_queue
        * acquire_queue_enqueuer    -> acquire_queue
        * release_queue_enqueuer    -> release_queue

### Processor History (planned for version 1.3)

* one entry per executed processor
* has a well defined ProcessorHistoryItem
* is defined by a ProcessorHistoryStorageInterface

### Processor List (planned for version 1.3)

* one entry per running processor
* has a well defined ProcessorListItem
* is defined by a ProcessorListStorageInterface

## Flow

* manager reads configuration (all available items) and puts them into a queue
* processor acquires one or multiple batches in the queue
* processor starts working on available batches until maximum number of processors is reached or no more batches are available in the queue

### Configuration

#### Instance

* unique_identifier: string
	* enabled: boolean
    * endpoint: string

#### Batch Job

##### Default / General

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


##### Per Job

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

#### Manager

* path_to_batch_job_configuration
* path_to_instance_configuration

### processor list

* id
* name
* current_batch_size
* maximum_batch_size
* created_at

### processor history

* id
* name
* current_batch_size
* maximum_batch_size
* created_at
* finished_at
* memory_usage
