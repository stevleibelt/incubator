<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-07
 */

require __DIR__ . '/../vendor/autoload.php';

use flight\Engine;
use Net\Bazzline\UniqueNumberRepository\Service\ApplicationLocator;

const VERSION = '1.0.0';

$application    = new Engine();
$locator        = new ApplicationLocator();

$application->before('start', function(&$params, &$output){
    echo 'params: ' . var_export($params, true) . PHP_EOL;
    echo 'output: ' . var_export($output, true) . PHP_EOL;
});

//begin of overriding default functionality
$application->map('notFound', function() use ($application) {
    $application->_json('not found', 404);
});
//end of overriding default functionality

//begin of routing
$application->_route('PUT /unique-number-repository', function() use ($application, $locator) {
    /** @var \flight\net\Request $request */
    $request    = $application->request();
    $data       = (array) $request->data;
    $repository = $locator->getRepositoryRepository();
    //$repository->update($data);
    file_put_contents('data/foo', var_export($data, true));
});
$application->_route('DELETE /unique-number-repository', function() {
    echo 'unique-number-repository called with DELETE' . PHP_EOL;
});
$application->_route('GET /unique-number-repository', function() use ($application, $locator) {
    $repository = $locator->getRepositoryRepository();
    $content = $repository->readMany();
    $application->_json($content);
});

$application->_route('PUT /unique-number-repository/@name', function($name) {
    echo 'unique-number-repository called with GET' . PHP_EOL;
    echo var_export($name, true) . PHP_EOL;
});
$application->_route('DELETE /unique-number-repository/@name', function($name) {
    echo 'unique-number-repository called with GET' . PHP_EOL;
    echo var_export($name, true) . PHP_EOL;
});
$application->_route('GET /unique-number-repository/@name', function($name) {
    echo 'unique-number-repository called with GET' . PHP_EOL;
    echo var_export($name, true) . PHP_EOL;
});
$application->_route('GET /version', function() use ($application) {
    $application->_json(VERSION);
});
//end of routing

$application->_start();
