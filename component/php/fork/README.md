# Fork Component for PHP

## Terms

* Manager
    * gets tasks attached
    * uses sub processes to execute task
    * takes care that forking is available
    * implements posix signal handling
    * taking care of optional runtime limit
    * taking care of optional memory limit
    * taking care of maximal number of sub processes

* Thread
    * the stupid simple sub process that works on a well defined task
    * implements posix signal handling

* AbstractTask
    * implements the unique logic a sub process should execute

## Additional Ideas

* an event listener can be used to easy up extending this component
* add shared memory for inter process calls (ipc)
* a sub process should implement
    * getProcessId()
    * getParentProcessId()
    * getRuntime()
    * getMemoryUsage()
    * setGroupId($groupId)
    * setUserId($userId)

## links

Following links to projects and pages to easy up stepping into process forking (in php).
Thanks to all the great projects and pages out there.

* [fork explained at wikipedia.org](https://en.wikipedia.org/wiki/Fork_(operating_system))
* [fork tutorial for linux](http://www.yolinux.com/TUTORIALS/ForkExecProcesses.html)
* [php process forking](http://www.electrictoolbox.com/article/php/process-forking/)
* [php forking tutorial](http://phpsblog.agustinvillalba.com/)
* [php forking example to speed up image resizing](http://oliversmith.io/technology/2011/10/07/speeding-up-php-using-process-forking-for-image-resizing/)
* [pcntl_fork manual](http://php.net/manual/en/function.pcntl-fork.php)
* [php-process-manager by dannymar](https://github.com/dannymar/php-process-manager)
* [php spork by gwilym](https://github.com/gwilym/php-spork)
* [php fork by mitallast](https://github.com/mitallast/php-fork)
* [workman by jimbosjsb](https://github.com/jimbojsb/workman)
* [PHP-Fork by robbmj](https://github.com/robbmj/PHP-Fork)
* [php-fork by mpierzchalski](https://github.com/mpierzchalski/php-fork)
* [php spork by kriswallsmith](https://github.com/kriswallsmith/spork)
* [PHP_Fork by pear](https://github.com/pear/PHP_Fork)
* [process-fork by pbergman](https://github.com/pbergman/processes-fork)
* [forki by kakawait](https://github.com/kakawait/forki)
* [php semaphore fork test by johan addriaans](https://github.com/johan-adriaans/PHP-Semaphore-Fork-test)
* [fork-helper by ducan3dc](https://github.com/duncan3dc/fork-helper)
* [php thread by mmarquez](https://github.com/mmarquez/php-thread)
* [forkdaemon php by baracudanetworks](https://github.com/barracudanetworks/forkdaemon-php)
* [power spawn by lordgnu](https://github.com/lordgnu/PowerSpawn)
