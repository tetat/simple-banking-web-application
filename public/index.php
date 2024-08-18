<?php

session_start();

use Routes\Router;
use App\Core\Session;
use App\Core\CommonException;

require_once __DIR__ . "/../vendor/autoload.php";

$url = parse_url($_SERVER["REQUEST_URI"])['path'];
$method = $_SERVER["REQUEST_METHOD"];

$router = new Router();
require_once __DIR__ . "/../routes/web.php";


try {
    $router->route($url, $method);
} catch (CommonException $exception) {
    Session::flash('errors', $exception->errors);
    Session::flash('old', $exception->old);

    redirect($exception->next);
}

Session::unflash();