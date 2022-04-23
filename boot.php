<?php
const ROOT_DIR = __DIR__.'/';

require_once(ROOT_DIR."/vendor/autoload.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$dotenv = \Dotenv\Dotenv::createMutable(ROOT_DIR);

try {
    $dotenv->load();
    $dotenv->required(['MONGO_DSN', 'MONGO_DB'])->notEmpty();
}
catch (\Dotenv\Exception\ValidationException $exception) {
    if (ini_get('display_errors')) {
        echo 'ERROR: '.$exception->getMessage().'<br>';
    }
    exit('Нехватает конфигов');
}


