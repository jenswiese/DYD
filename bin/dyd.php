#!/usr/bin/php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dyd\Console\Command\StatusCommand;
use Dyd\Console\Command\DiffCommand;
use Dyd\Console\Command\DeployCommand;
use Symfony\Component\Console\Application;

$application = new Application('DYD', '0.1-dev');
$application->add(new StatusCommand());
$application->add(new DiffCommand());
$application->add(new DeployCommand());
$application->run();

?>