# Simple Curl Wrapper Component for PHP

This is not a component developed to replace [guzzle]().

The main approach of this component is to create a free as in freedom basic curl object oriented component.

# Example

```php
//it is always good to ship the component with a factory to easy up usage
$factory    = new Net\Bazzline\Component\Curl\RequestFactory();
$request    = $factory->create();

$response = $request->get('http://www.foo.bar');

echo $response->content();
echo $response->contentType();
echo $response->errorCode();
echo $response->statusCode();
```

# Links

## Other Components Available

* https://github.com/php-mod/curl
* https://github.com/anlutro/php-curl
* https://github.com/hamstar/curl
* https://github.com/jyggen/curl
* https://github.com/ixudra/Curl
* https://github.com/brodkinca/BCA-PHP-CURL
* https://github.com/miliqi/laravel-curl
* https://github.com/andrefigueira/Lib-Curl
