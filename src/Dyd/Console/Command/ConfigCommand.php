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
class ConfigCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('config')
            ->setDescription('Displays status of configured database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write($this->getOutput());
    }



    protected function getOutput()
    {
        $longVersion = $this->getApplication()->getLongVersion();

        $output = <<< EOT
$longVersion

<comment>Config:</comment>
  /tmp/foobar/project/dyd.conf

<comment>Configured Databases:</comment>
  <comment>database1:</comment>
    <comment>index:</comment> /tmp/database1.index (<info>exists</info>)
    <comment>dsn:</comment> mysql://user:pass@localhost:database1 (<error>not connected</error>)
  <comment>database2:</comment>
    <comment>index:</comment> /tmp/database2.index (<error>does not exist</error>)
    <comment>dsn:</comment> mysql://user:pass@localhost:database2 (<error>not connected</error>)

<comment>Available database driver:</comment>
  mysql, sqlite, pg

<comment>Environment:</comment>
  <comment>PHP-Version:</comment> 5.4.3
  <comment>DYD bin:</comment> /usr/bin
  <comment>DYD config:</comment> /etc/dyd.conf

EOT;

        return $output;
    }

}
