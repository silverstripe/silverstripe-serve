<?php

/**
 * Find details of the project that serve has been loaded into
 */

// module installed in project root
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    define('BASE_PATH', realpath(__DIR__ . '/../../'));

// module installed in vendor
} elseif (file_exists(__DIR__ . '/../../../../vendor/autoload.php')) {
    define('BASE_PATH', realpath(__DIR__ . '/../../../../'));
}

// Serve always hosts from the root
define('BASE_URL', '');
