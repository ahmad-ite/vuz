<?php

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
});

function my_autoloader_function($class)
{
    $base_dir = __DIR__ . '/app/';


    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    $file = str_replace('/app/App', '',  $file);
    if (file_exists($file)) {
        require_once $file;
    }
}
