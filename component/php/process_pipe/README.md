# Process Pipe

Basic idea is to create a [pipe](http://en.wikipedia.org/wiki/Pipeline_(computing)) for processes in php.
Indeed, it is a [pseudo pipeline](http://en.wikipedia.org/wiki/Pipeline_(software)#Pseudo-pipelines) (process collection or process batch)t  since the process is single threaded.

Currently, there is no plan to blow up the code base with an implementation of [STDIN](http://en.wikipedia.org/wiki/Standard_streams#Standard_input_.28stdin.29), [STDOUT](http://en.wikipedia.org/wiki/Standard_streams#Standard_output_.28stdout.29) or [STDERR](http://en.wikipedia.org/wiki/Standard_streams#Standard_error_.28stderr.29).
Errors can be handled by the thrown exception. The defined $data represents the input and output as defined in the ExecutableIntetrface::execute($data) method.

Take a look to the example section.

# Usage

## By using the pipe method for multiple process

```php
$pipe = new Pipe();

$pipe->pipe(
    new ProcessOne(), 
    new ProcessTwo()
);

$data = $pipe->execute($data);

```
## By using the pipe method once for each process

```php
$pipe = new Pipe();

$pipe->pipe(new ProcessOne());
$pipe->pipe(new ProcessTwo());

$data = $pipe->execute($data);
```

## By instantiation

```php
$pipe = new Pipe(
    new ProcessOne(),
    new ProcessTwo()
);

$data = $pipe->execute($data);
```

# to do

* rename $data to $io or $inputOutput

# links

* [pipes](https://github.com/vkartaviy/pipes)
* [php-pipeline](https://github.com/JosephMoniz/php-pipeline)
* [php-pipeline-lib](https://github.com/phppro/php-pipeline-lib)
