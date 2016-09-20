<?php

require_once __DIR__ . "/bootstrap.php";
require_once BASE_PATH . "/vendor/autoload.php";

if (getenv("SERVE_BOOTSTRAP_FILE")) {
    require_once getenv("SERVE_BOOTSTRAP_FILE");
}

$uri = urldecode(
    parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)
);

if ($uri !== "/" && file_exists(BASE_PATH . $uri) && !is_dir(BASE_PATH . $uri)) {
    return false;
}

$_GET["url"] = $uri;
$_REQUEST["url"] = $uri;

if (defined("FRAMEWORK_PATH")) {
    require_once FRAMEWORK_PATH . "/main.php";
} else {
    require_once BASE_PATH . "/framework/main.php";
}
