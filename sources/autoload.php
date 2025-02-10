<?php

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

function dd(...$vars)
{
    echo '<pre style="background-color: #f4f4f4; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">';
    foreach ($vars as $var) {
        dump($var);
    }
    echo '</pre>';
    exit(1);
}

function dump($var)
{
    echo htmlspecialchars(var_export($var, true), ENT_QUOTES, 'UTF-8') . PHP_EOL;
}