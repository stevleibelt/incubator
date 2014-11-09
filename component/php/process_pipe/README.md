# Process Pipe

Basic idea is to create a [pipe](http://en.wikipedia.org/wiki/Pipeline_(computing)) for processes in php.
Indeed, it is a [pseudo pipeline](http://en.wikipedia.org/wiki/Pipeline_(software)#Pseudo-pipelines) (process collection or process batch)t  since the process is single threaded.

Currently, there is no plan to blow up the code base with an implementation of [STDIN](http://en.wikipedia.org/wiki/Standard_streams#Standard_input_.28stdin.29), [STDOUT](http://en.wikipedia.org/wiki/Standard_streams#Standard_output_.28stdout.29) or [STDERR](http://en.wikipedia.org/wiki/Standard_streams#Standard_error_.28stderr.29).
Errors can be handled by the thrown exception. Input is defined by the ExecutableInterface, as well as the output (return value).

Take a look to the example section. The following examples are:

* no input
* input array
* failing execution
* input generator
* input transformer
* input validator
* data flow manipulator

# Usage

## By using the pipe method for multiple process

```php
$pipe = new Pipe();

$pipe->pipe(
    new ProcessOne(), 
    new ProcessTwo()
);

$output = $pipe->execute($input);

```
## By using the pipe method once for each process

```php
$pipe = new Pipe();

$pipe->pipe(new ProcessOne());
$pipe->pipe(new ProcessTwo());

$output = $pipe->execute($input);
```

## By instantiation

```php
$pipe = new Pipe(
    new ProcessOne(),
    new ProcessTwo()
);

$output = $pipe->execute($input);
```

# to do

* write unit tests
* release it

# links

* [pipes](https://github.com/vkartaviy/pipes)
* [php-pipeline](https://github.com/JosephMoniz/php-pipeline)
* [php-pipeline-lib](https://github.com/phppro/php-pipeline-lib)
