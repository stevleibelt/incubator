# PHP Worker

Free as in freedom and simple queued task manager.

## Issue to solve

Given is a path containing lots of videos we want to convert to libx265 videos.
Furthermore, the pc that contains this videos is a different one than the pc that has the cpu power to convert the files.
The pc containing the video files is asking a server from time to time to convert the videos.
The pc containing the video files is asking a server from time to time about the status and will fetch the converted data when done.

## More detailed description

The idea is to create a simple client-server-system.
The client is scanning the path for new videos regulary via systemd timers or cronjobs.
The client is calling the server api to create a new converting task by providing the following informations:
* task_type: convert_video_to_libx265
* file_name: "my_file.mp4"
* file_data: <data>
* file_path: "/my/path"

The client is keeping a record of all added task ids and is asking the server from time to time if the task is done or not.
If the task is done, the client is fetching the converted file name and file data and deletes the task.

The server provides a simple REST-API to:
* manage tasks (create, fetch status, fetch data, deletes)
* fetchs the available task types
* maybe manage the task data (if it makes sense to separate the data up- and downloading from the task management

The server also contains a management core to orchastrate the workers *or* is using supervisord to do this.
When a task is created, it is pushed into a queue.
The configured amount of workers is listening to the queues and one worker is fetching the new task and is processing it.

If the server system is shutting down, the task is listening on a sig kill and will stop the current task plus, remove the converted and not finished file and will set back the task in the queue to "not started".
If the server system is starting, the worker manager is checking the queue by resetting all queue items not in state "not started" to this state *before* starting the workers.

## Technical description

* Use [mezzio](https://github.com/mezzio/mezzio) for the client and the server part
* KISS until all is working
* Provide systemd files at the beginning
* Start with one task type called "convert_video_to_libx265"
* Try to define and implement interfaces for the queue and the workers as well
* There is only one queue manager with exclusive read and write rights to and from the queue
* Start with a basic queue manager (maybe even just file based at the beginning)
* Either implement your own worker manager or use supervisord
* Client and server have a root path configured and php is not allowed to write somewhere else
