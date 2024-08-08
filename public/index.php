<?php

session_start();

use Routes\Router;
use App\Core\Session;
use App\Core\ValidationException;

require_once __DIR__ . "/../vendor/autoload.php";

$url = parse_url($_SERVER["REQUEST_URI"])['path'];
$method = $_SERVER["REQUEST_METHOD"];

$router = new Router();
require_once __DIR__ . "/../routes/routes.php";

try {
    $router->route($url, $method);
} catch (ValidationException $exception) {
    Session::flash('errors', $exception->errors);
    Session::flash('old', $exception->old);

    redirect(previousPage());
}

Session::unflash();