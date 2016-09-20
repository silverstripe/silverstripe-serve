<?php

if (!function_exists("__serve_get_value")) {
    /**
     * Get value from options array, or environment variables or, a default.
     *
     * @param array $options
     * @param string $optionsKey
     * @param string $envKey
     * @param mixed $default
     *
     * @return mixed
     */
    function __serve_get_value(array $options, $optionsKey, $envKey, $default = null) {
        if (!empty($options[$optionsKey])) {
            return $options[$optionsKey];
        }

        if (getenv($envKey)) {
            return getenv($envKey);
        }

        return $default;
    }
}

// Load Composer autoloader...

if (file_exists(__DIR__ . "/../../vendor/autoload.php")) {
    define("BASE_PATH", realpath(__DIR__ . "/../../"));
} elseif (file_exists(__DIR__ . "/../../../../vendor/autoload.php")) {
    define("BASE_PATH", realpath(__DIR__ . "/../../../../"));
}

// Always serve from the root...

define("BASE_URL", "");
