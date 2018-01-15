<?php

// Serve always hosts from the root
define('BASE_URL', '');

// Detect BASE_PATH with public-folder awareness
define(
    'BASE_PATH',
    basename(getcwd()) === 'public'
        ? dirname(getcwd())
        : getcwd()
);
