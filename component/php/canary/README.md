# Canary for PHP

Free as in freedom open monitoring system influenced by [canaryio/canary](https://github.com/canaryio/canary).

## Basic Idea

* longtime running code is 
    * sign on when he starts
    * sending a "ping" to an endpoint to illustrate "I am not dead yet"
    * sign off when he finishes

## Terms

* Aggregator
    * Endpoint that fetchs data continously
* Sampler
    * Collection of Sensors
* Sensor
    * Measurment that contains the target (what to test), the same (how to test) and hte status (ok|!ok)
* Publisher
    * Converts collected measurements into the metrics

## Notes

* uses the [EnumerableDeferred](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/Process/EnumerableDeferred.php) to do a "ping" each x entries
