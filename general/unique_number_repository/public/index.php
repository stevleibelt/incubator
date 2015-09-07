<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

use flight\Engine;

$application = new Engine();

//begin of overriding default functionality
$application->map('notFound', function() {
    $application->_json('not found', 404);
});
//end of overriding default functionality

//begin of setting up the routes
//@todo move into configuration/routing.php
//  begin of /unique-number-repository
$application->route('PUT /unique-number-repository', function() {
    echo 'unique-number-repository called with PUT';
});
$application->route('DELETE /unique-number-repository', function() {
    echo 'unique-number-repository called with DELETE';
});
$application->route('GET /unique-number-repository', function() {
    echo 'unique-number-repository called with GET';
});
//  end of /unique-number-repository

//  begin of /unique-number-repository/{name}
$application->route('PUT/unique-number-repository/@name', function($name) {
    echo 'unique-number-repository for ' . $name . ' called with PUT';
});
$application->route('DELETE/unique-number-repository/@name', function($name) {
    echo 'unique-number-repository for ' . $name . ' called with DELETE';
});
$application->route('GET /unique-number-repository/@name', function($name) {
    echo 'unique-number-repository for ' . $name . ' called with GET';
});
//  end of /unique-number-repository/{name}
//end of setting up the routes

$application->start();
