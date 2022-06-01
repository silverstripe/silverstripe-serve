<?php

// Shiv in PUBLIC_PATH for pre-4.1
if (!defined('PUBLIC_PATH')) {
    define(
        'PUBLIC_PATH',
        file_exists(BASE_PATH . DIRECTORY_SEPARATOR . 'public')
            ? (BASE_PATH . DIRECTORY_SEPARATOR . 'public')
            : BASE_PATH
    );
}
