<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {

//how to access endpoints (will appear on base_url page)
    $endpoints = [
        'all tasks' => $this->api['api_url'] . '/todos',
        'single task' => $this->api['api_url'] . 'todos/{id}',

    ];

/*display endpoints as well as version number and full list of
the current existing tasks*/
    $result = [

      'endpoints' => $endpoints,
      'version' => $this->api['version'],
      'tasks' => $this->todo->getTasks()

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
