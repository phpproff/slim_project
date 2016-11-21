<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';
spl_autoload_register(function ($classname) {
    require (__DIR__ . "/../classes/" . $classname . ".php");
});

$config['displayErrorDetails'] = true;
$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "";
$config['db']['dbname'] = "exampleapp";
$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("./logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/getorder/{id}', function (Request $request, Response $response, $args) {
    $Order_id = (int)$args['id'];
    $mapper = new OrderMapper($this->db);
    $order = $mapper->getOrderById($Order_id);
    $response = $response->withJson($order, 200);
    return $response;
});

$app->post('/cancelorder/{id}', function (Request $request, Response $response, $args) {
    $Order_id = (int)$args['id'];         
    $mapper = new OrderMapper($this->db);
    $result = $mapper->changeStatus($Order_id);
    if($result=="Success") $status=true; else $status=false;
    $response = $response->withJson(['status'=>$status,'msg'=>$result ], 200);
    return $response;

});
$app->run();
