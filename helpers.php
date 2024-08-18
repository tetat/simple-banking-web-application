<?php

use App\Core\Session;

function env(string $key, string $default = null)
{
    return $_ENV[$key] ?? $default;
}

// this function for selected route in navbar
function uriIs(string $uri): string
{
    if ($_SERVER['REQUEST_URI'] === $uri) {
        return 'bg-emerald-700';
    }

    return 'hover:bg-emerald-500';
}

function old($key, $default = '')
{
    return Session::get('old')[$key] ?? '';
}

function senitize(string $data): string
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function view(string $view, array $data = [])
{
    if ($data) extract($data);

    require_once __DIR__ . "/views/{$view}.php";
}

function redirect($location)
{
    header("Location: {$location}");
    exit;
}

function previousPage()
{
    return $_SERVER['HTTP_REFERER'];
}

function base_path(string $path): string
{
    return __DIR__ . $path;
}

function dd($data)
{
    echo "<pre>";
        print_r($data);
    echo "</pre>";
    die();
}