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
class DeployCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('deploy')
            ->setDescription('Deploys changeset(s) to configured database.')
            ->addOption('interactive', null, InputOption::VALUE_NONE, 'Activates interactive-mode')
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_NONE,
                'Activates dry-run-mode: Nothing will happen to your database'
            )
            ->addOption('stop-on-error', null, InputOption::VALUE_NONE, 'Deployment will stop if an error occurs.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }

    protected function getOutput()
    {
        $output = <<< EOF



EOF;

    }
}
