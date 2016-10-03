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
* a "poisoned" queue entry is moved automatically into an \*error_queue\* after <number of retries>
* for version 1.2
    * event based to hook easy up extending:
        * implement a support for a "current processor list / process list"
        * implement a support for a "processor history list"

## Terms

### Batch Job

* collection or summary of
    * acquirer
    * batch
    * enqueuer
    * processor
    * fetcher
    * queue
    * releaser
* is a container with simple setter and getter methods
    * getProcessor
    * getQueue
    * ...

### Batch

* container for a collection of items
* behaves like an array (ArrayAccess|Iterator)
* implements BatchInterface
* represents a scoped view on a queue
* contains:
    * identifier
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
* database table structure:
    * id
    * batch_id
    * item_id
    * status_id
    * instance_id
    * priority
    * delay_in_milliseconds
    * number_of_tries
    * created_at
    * processed_at
    * lable

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

* use rest, message broker or bus system to transfer the data
    * input validation and process triggering should be independen of the way the data flows into the system
    * messag broker or bus system are command based with listeners like
        * create-batch
        * delete-batch
        * list-available-batches
        * add-item-to-batch
        * delete-item-from-batch
        * process-batch
    * basic rest api like (HTTP METHOD)
        * /api/batch (GET, PUT, DELETE) - create or delete a new batch, PUT returns a new id, GET returns list with current availabe batches and their current status
        * /api/batch/{id} (POST, DELETE) - add items to a batch or delete the whole batch
        * /api/process-batch (POST) - start a batch processing with mandatory parameters "successful callback url", "error callback url" and "batch id"
* use uuid to generate batch ids
    * [uuid - lootils](http://packagist.org/packages/lootils/uuid) (v5, and unit tests)
    * [uuid - laravel](http://packagist.org/packages/webpatser/laravel-uuid) (v5, no unit tests) (v5, no unit tests)
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
* on failure
    * if a process breaks while execution (stops working) you could use the infrastructure to
        * implement a "monitoring" processor (checks the creation date with an expected time frame, validates if the pid is still running etc.)
        * implement a "cleanup" processor (resets stats, sends mails/notifications, clean up file system/database etc.)
* the manager simple triggers the commands above by reading the configuration and using the right factories
    * everything is a batch job / processor represented by a queue
        * processor_queue_enqueuer  -> procesor_queue
        * enqueuer_queue_enqueuer   -> enqueuer_queue
        * acquire_queue_enqueuer    -> acquire_queue
        * release_queue_enqueuer    -> release_queue
* advices:
    * queue:
        * mo multi content queue (they are complex to debug and allowing race conditions)
        * use “order by id ASC” for acquiring to process the queue top down (oldes entries first, timebased right ordering)
        * no complex enqueuer (no priority, nothing that can lead into a race condition, simple new item and that’s it)


### Processor History (planned for version 1.3)

* one entry per executed processor
* has a well defined ProcessorHistoryItem
* is defined by a ProcessorHistoryStorageInterface

### Processor List (planned for version 1.3)

* one entry per running processor
* has a well defined ProcessorListItem
* is defined by a ProcessorListStorageInterface

## Flow

* batchjob manager
    * reads configuration and current number of running process
    * starts acquire manager by passing chunk id generator and all acquireable chunks (all available batch jobs with number of chunks)
    * starts process manager by passing array of batch job to chunk id
    * starts release manager by passing array of chunk id where process are not longer running

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

# Recomendations

* avoid adding a status column to your queue table
    * this would increase complexity
    * reduced scalability since the dbms has to tackle multiple status (on more index to maintain, increased number of consumers)
    * create a queue table for each new step/task/process
    * combine them by the naming like "item_validation_data_queue", "item_validation_url_reachable_queue"
    * if you need to deal with status, implement a StatusManager/StateMachine that calculates the right status

# links

* [iron_mq_php](https://github.com/iron-io/iron_mq_php)
* [iron_worker_php](https://github.com/iron-io/iron_worker_php)
* [SlmQueue](https://github.com/juriansluiman/SlmQueue)
* [Leptir](https://github.com/Backplane/Leptir)
