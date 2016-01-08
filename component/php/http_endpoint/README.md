# HTTP Endpoint for php

This project aims to deliver an easy to use and free as in freedom object oriented php http endpoint or server component.

# Example

## Build Configuration

```
<?php

use Net\Bazzline\Component\HttpEndpoint\Configuration\Builder;

$builder = new Builder();

$builder
    ->beforeDispatchingTheRoute(function(Request $request) { return $request; })  //do some stuff at the beginning
    ->listenWithPost()
    ->onTheRoute('/user[/:name]')
    ->execute(function(Request $request, Response $response) { return $response; })
    ->listenWithGet()
    ->onTheRoute('/user[/:name]')
    ->execute(function(Request $request, Response $response) { return $response; })
    ->onError()
    ->execute(function(Request $request, Response $response) { return $response; })
    ->afterDispatchingTheResponse(function(Response $response) { return $response; }    //do some stuff at the end
    ->andFinallyDump(new FileSystemDumper());
```

## The Configuration

```
<?php

return array(
    'get' => array(
        '/user[/:name]' => function(Request $request, Response $response) { return $response; }
    )
);
```
