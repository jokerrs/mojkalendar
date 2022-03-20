<?php
foreach (file("../.env") as $item) {
    $config = explode("=", $item);
    $_ENV[$config[0]] = trim($config[1]);
}
require_once "vendor/autoload.php";
require_once "functions.php";
require_once "routes.php";
