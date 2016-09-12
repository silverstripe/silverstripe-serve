<?php

/**
 * Server handler
 * Wraps main.php. Except BASE_PATH and FRAMEWORK_PATH to be set by composer's autoload of
 * framework.
 */

define('BASE_URL', '');

// module installed in project root
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
	require_once __DIR__ . '/../../vendor/autoload.php';

// module installed in vendor
} else {
	require_once __DIR__ . '/../../../../vendor/autoload.php';
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== "/" && file_exists(BASE_PATH . $uri)) {
    return false;
}

$_GET["url"] = $uri;
$_REQUEST["url"] = $uri;

require_once FRAMEWORK_PATH . '/main.php';
