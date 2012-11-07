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
class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $foo = new \Symfony\Component\Console\Helper\DialogHelper();

        for ($i = 0; $i < 10; $i++) {
//            $bar = $foo->ask($output, 'Frage: ', 'foo');
//            $bar = $foo->askConfirmation($output, "Delete the system? ", false);
//            $output->writeln($bar);
        }
    }
}
