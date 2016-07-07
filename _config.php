<?php

$host = "localhost";

if (isset($_GET["host"])) {
    $host = $_GET["host"];
}

putenv("SERVE_HOST={$host}");

$port = "8080";

if (isset($_GET["port"])) {
    $port = $_GET["port"];
}

putenv("SERVE_PORT={$port}");

$path = realpath(__DIR__ . "/../");

putenv("SERVE_PATH={$path}");

global $_FILE_TO_URL_MAPPING;
$_FILE_TO_URL_MAPPING[$path] = "http://{$host}:{$port}";
