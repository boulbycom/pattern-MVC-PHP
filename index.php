<?php

require "vendor/autoload.php";
require "app/config/include.php";


$controller = (new \App\Core\Dispatcher())->buildController();

$controller->executeAction();