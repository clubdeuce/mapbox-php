<?php
define('MAPBOX_TEST_KEY', getenv('MAPBOX_TEST_KEY'));

require dirname(__DIR__) . '/src/Base.php';
require dirname(__DIR__) . '/src/Helpers/Api.php';
require 'includes/TestCase.php';
require dirname(__DIR__) . '/vendor/autoload.php';
