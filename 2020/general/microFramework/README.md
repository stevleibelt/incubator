# My Two Cents for a Microframework

## Readable Configuration

```php
$application
    ->listenOnRoute('')
    ->withGet()
    ->andExecute(function () {})
    ->and()
    //...
    ->andFinallyRunTheApplication();
```

## Classes

* based on [PicoRest](https://github.com/dirkwinkhaus/PicoRest)

* Http\GET|POST|PUT|DELETE|... with parameters
    * controller action to call
    * optional additional route information (like "/foo")
    * optional description
* Endpoint
    * collection of http methods
    * optional additional route information (like "bar/")
    * optional description
* Route
    * collection of endpoins
    * route information (like "/")
    * optional description
* Router
    * collection of routes
