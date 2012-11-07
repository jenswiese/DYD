#!/usr/bin/php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dyd\Console\Command\InfoCommand;
use Dyd\Console\Command\DeployCommand;

$config = new \Dyd\Console\Config();

$application = new \Dyd\Console\Application($config);
$application->add(new InfoCommand());
$application->add(new DeployCommand());
$application->run();
