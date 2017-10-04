<?php

if (file_exists(BASE_PATH . '/vendor/silverstripe/framework/tests/bootstrap.php')) {
	// SS4
	require_once(BASE_PATH . '/vendor/silverstripe/framework/tests/bootstrap.php');
} else {
	// SS3
	require_once(BASE_PATH . '/framework/tests/bootstrap.php');
}