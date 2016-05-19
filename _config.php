<?php

$host = "localhost";

if (isset($_GET["host"])) {
    $host = $_GET["host"];
}

define("SERVE_HOST", $host);

$port = "8080";

if (isset($_GET["port"])) {
    $port = $_GET["port"];
}

define("SERVE_PORT", $port);

$root = realpath(__DIR__ . "/../");

define("SERVE_ROOT", $root);

global $_FILE_TO_URL_MAPPING;
$_FILE_TO_URL_MAPPING[$root] = "http://{$host}:{$port}";
