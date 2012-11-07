<?php

namespace Dyd\Console\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Input\InputOption;
use \Symfony\Component\Console\Output\OutputInterface;


/**
 * Created by JetBrains PhpStorm.
 * User: jens
 * Date: 9/26/12
 * Time: 9:55 AM
 * To change this template use File | Settings | File Templates.
 */
class CheckCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription(
                'Checks environment for working DYD to work correct (e.g. checks installed PDO-drivers, DB-Connection infos).'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * Display of:
         *
         * Configured databases
         *   - DSN
         *   - IndexFile
         *   - ServerString
         *
         * Installed Pdo-Drivers
         */


        $database = \Dyd\Util\ServiceLocator::getPDO($dsn);
        $installedPdoDrivers = $database->getAvailableDrivers();

        $co


        $output->writeln('Checking environment for needed libraries ...:');
        $output->writeln('PDO installed: ' . (class_exists('\PDO') ? 'yes' : 'no'));
    }
}
