<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {

    $endpoints = [
        'all tasks' => $this->api['api_url'] . '/todos',
        'single task' => $this->api['api_url'] . 'todos/{id}',

    ];

    $result = [

      'tasks' => $this->todo->getTasks(),
      'endpoints' => $endpoints,
      'version' => $this->api['version']

    ];

     return $response->withJson($result, 200, JSON_PRETTY_PRINT );
});
/*************************create a routing group  ****************************/
$app->group('/api/v1/todos', function() use($app) {

        /*************************Get all tasks ****************************/
        $app->get('', function (Request $request, Response $response, array $args) {
            $result = $this->todo->getTasks();
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });

        /**********************Get a single task ************************/
        $app->get('/{id}', function (Request $request, Response $response, array $args) {
            $result = $this->todo->getTask($args['id']);

            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
        /*************************Add new task ****************************/
        $app->post('', function (Request $request, Response $response, array $args) {

            $result = $this->todo->createTask($request->getParsedBody());

            return $response->withJson($result, 201, JSON_PRETTY_PRINT);
        });
        /*************************Update task ****************************/
        $app->put('/{id}', function (Request $request, Response $response, array $args) {
            $data = $request->getParsedBody();
            $data['id'] = $args['id'];
            $result = $this->todo->updateTask($data);

            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
        /*************************Delete task ****************************/
        $app->delete('/{id}', function (Request $request, Response $response, array $args) {
            $result = $this->todo->deleteTask($args['id']);

            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
});
