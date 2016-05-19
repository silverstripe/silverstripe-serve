<?php

$uri = urldecode(
    parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)
);

if ($uri !== "/" && file_exists(__DIR__ . "/../../" . $uri)) {
    return false;
}

$_GET["url"] = $uri;
$_REQUEST["url"] = $uri;

require_once __DIR__ . "/../../framework/main.php";
