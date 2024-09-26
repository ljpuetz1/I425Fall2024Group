<?php
require __DIR__ . '/vendor/autoload.php';

$app = new \Slim\App();

$app->get('/', function ($request, $response, $args) {
    return $response->write("Hello I425!");
});

$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->write("Hello ". $args['name']);
});

$app->run();