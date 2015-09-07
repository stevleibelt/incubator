<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

//begin of setting up the routes
//@todo move into configuration/routing.php
//  begin of /unique-number-repository
Flight::route('PUT /unique-number-repository', function(){
    echo 'unique-number-repository called with PUT';
});
Flight::route('DELETE /unique-number-repository', function(){
    echo 'unique-number-repository called with DELETE';
});
Flight::route('GET /unique-number-repository', function(){
    echo 'unique-number-repository called with GET';
});
//  end of /unique-number-repository

//  begin of /unique-number-repository/{name}
Flight::route('PUT/unique-number-repository/@name', function($name){
    echo 'unique-number-repository for ' . $name . ' called with PUT';
});
Flight::route('DELETE/unique-number-repository/@name', function($name){
    echo 'unique-number-repository for ' . $name . ' called with DELETE';
});
Flight::route('GET /unique-number-repository/@name', function($name){
    echo 'unique-number-repository for ' . $name . ' called with GET';
});
//  end of /unique-number-repository/{name}
//end of setting up the routes

Flight::start();
