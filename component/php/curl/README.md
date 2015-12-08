# Simple Curl Wrapper Component for PHP

This is not a component developed to replace [guzzle]().

The main approach of this component is to create a free as in freedom basic curl object oriented component.

# Example

```php
//it is always good to ship the component with a factory to easy up usage
$factory    = new Net\Bazzline\Component\Curl\RequestFactory();
$request    = $factory->create();

$url        = 'http://www.foo.bar';

//begin of fluent interface draft
$request->usePost()
    ->onTheUrl($url)
    ->withTheData($data)
    ->withTheHeaderLine($headLine)
    ->withTheOption($option)
    ->withResponseModifier($modifier)
    ->andFetchTheResponse();
//end of fluent interface draft

$response = $request->get($url);

echo $response->content();
echo $response->contentType();
echo $response->errorCode();
echo $response->statusCode();
```

# To do's

* add [dispatcher](https://github.com/jyggen/curl/blob/master/src/Dispatcher.php) or HandlerGenerator/HandlerFactory
    * https://secure.php.net/manual/en/function.curl-init.php
    * https://secure.php.net/manual/en/function.curl-multi-init.php

# Links

* http://resttesttest.com/

## Other Components Available

* https://github.com/php-mod/curl
* https://github.com/anlutro/php-curl
* https://github.com/hamstar/curl
* https://github.com/jyggen/curl
* https://github.com/ixudra/Curl
* https://github.com/brodkinca/BCA-PHP-CURL
* https://github.com/miliqi/laravel-curl
* https://github.com/andrefigueira/Lib-Curl
