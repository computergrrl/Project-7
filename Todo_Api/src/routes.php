<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {

    $endpoints = [
        'all tasks' => $this->api['api_url'] . '/tasks',
        'single task' => $this->api['api_url'] . 'tasks/{task_id}',

    ];

    $result = [

      'tasks' => $this->todo->getTasks(),
      'endpoints' => $endpoints,
      'version' => $this->api['version']

    ];

     return $response->withJson($result, 200, JSON_PRETTY_PRINT );
});
/*************************create a routing group  ****************************/
$app->group('/api/v1/tasks', function() use($app) {
        $app->get('', function (Request $request, Response $response, array $args) {
            $result = $this->todo->getTasks();
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });

        /*************************Get a task ****************************/
        $app->get('/{task_id}', function (Request $request, Response $response, array $args) {
            $result = $this->todo->getTask($args['task_id']);

            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
        /*************************Add new task ****************************/
        $app->post('', function (Request $request, Response $response, array $args) {

            $result = $this->todo->createTask($request->getParsedBody());

            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
        /*************************Update task ****************************/
        $app->put('/{task_id}', function (Request $request, Response $response, array $args) {
            $data = $request->getParsedBody();
            $data['task_id'] = $args['task_id'];
            $result = $this->todo->updateTask($data);

            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
        /*************************Delete task ****************************/
        $app->delete('/{task_id}', function (Request $request, Response $response, array $args) {
            $result = $this->todo->deleteTask($args['task_id']);

            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
});
