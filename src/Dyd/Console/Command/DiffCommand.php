<?php

namespace Dyd\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Created by JetBrains PhpStorm.
 * User: jens
 * Date: 9/26/12
 * Time: 9:55 AM
 * To change this template use File | Settings | File Templates.
 */
class DiffCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('diff')
            ->setDescription('Displays differences between changesets and configured database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Diff of ...:');
    }
}
