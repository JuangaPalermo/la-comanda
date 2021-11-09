<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/EmpleadoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/PedidoController.php';
require_once './db/AccesoDatos.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
// se lo puedo sacar para pegarle directamente a localhost/ en vez de tener que poner el public despues
// $app->setBasePath('/public');
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

//setting timezone a Buenos Aires
date_default_timezone_set("America/Argentina/Buenos_Aires");

//peticiones
$app->group('/empleados', function (RouteCollectorProxy $group) {
  $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
  $group->get('/{idEmpleado}', \EmpleadoController::class . ':TraerUno');
  $group->post('[/]', \EmpleadoController::class . ':CargarUno');
  $group->delete('[/]', \EmpleadoController::class . ':BorrarUno');
  $group->put('[/]', \EmpleadoController::class . ':ModificarUno');
});

$app->group('/mesas', function (RouteCollectorProxy $group){
  $group->get('[/]', \MesaController::class . ':TraerTodos');
  $group->get('/{idMesa}', \MesaController::class . ':TraerUno');
  $group->post('[/]', \MesaController::class . ':CargarUno');
  $group->delete('[/]', \MesaController::class . ':BorrarUno');
  $group->put('[/]', \MesaController::class . ':ModificarUno');
});

$app->group('/productos', function (RouteCollectorProxy $group){
  $group->get('[/]', \ProductoController::class . ':TraerTodos');
  $group->get('/{idProducto}', \ProductoController::class . ':TraerUno');
  $group->post('[/]', \ProductoController::class . ':CargarUno');
  $group->delete('[/]', \ProductoController::class . ':BorrarUno');
  $group->put('[/]', \ProductoController::class . ':ModificarUno');
});

$app->group('/pedidos', function (RouteCollectorProxy $group){
  $group->get('[/]', \PedidoController::class . ':TraerTodos'); //me trae todos indistintamente del estado.
  $group->get('/{pedidoCodigo}', \PedidoController::class . ':TraerUno'); //me trae un array con todos los productos del ped.
  $group->post('[/]', \PedidoController::class . ':CargarUno');
  $group->delete('[/]', \PedidoController::class . ':BorrarUno');
  $group->put('[/]', \PedidoController::class . ':ModificarUno');
});

//crear una tabla que funcione como backlog de las acciones de los empleados

// para no tener problemas con el put y delete
$app->addBodyParsingMiddleware();

// Run app
$app->run();

