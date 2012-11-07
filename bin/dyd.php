#!/usr/bin/php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dyd\Console\Command\ConfigCommand;
use Dyd\Console\Command\StatusCommand;
use Dyd\Console\Command\DiffCommand;
use Dyd\Console\Command\DeployCommand;
use Dyd\Console\Command\TestCommand;

$config = new \Dyd\Console\Config();

$application = new \Dyd\Console\Application($config);
$application->add(new ConfigCommand());
//$application->add(new StatusCommand());
//$application->add(new DiffCommand());
//$application->add(new DeployCommand());
$application->add(new TestCommand());
$application->run();
