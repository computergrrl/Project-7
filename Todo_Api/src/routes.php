<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {

    // Render index view
    $result = $this->todo->getTodos();

     return $response->withJson($result, 200, JSON_PRETTY_PRINT );
});
