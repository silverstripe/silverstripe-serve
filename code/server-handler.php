<?php

/**
 * Server handler
 * Wraps main.php. Except BASE_PATH and FRAMEWORK_PATH to be set by composer's autoload of
 * framework.
 */

use SilverStripe\Core\Environment;

require_once 'constants.php';
require_once BASE_PATH . '/vendor/autoload.php';
require_once 'constants-compat.php';

// Include a bootstrap file (e.g. if you need extra settings to get a module started)
if (Environment::getEnv('SERVE_BOOTSTRAP_FILE')) {
    require_once Environment::getEnv('SERVE_BOOTSTRAP_FILE');
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? ''
);

if ($uri !== "/" && file_exists(PUBLIC_PATH . $uri) && !is_dir(PUBLIC_PATH . $uri)) {
    return false;
}

$_GET["url"] = $uri;
$_REQUEST["url"] = $uri;


$paths = [
    '/public/index.php',
    '/index.php',
    '/vendor/silverstripe/framework/main.php',
    '/framework/main.php',
];
foreach ($paths as $path) {
    if (file_exists(BASE_PATH . $path)) {
        require_once BASE_PATH . $path;
        break;
    }
}
