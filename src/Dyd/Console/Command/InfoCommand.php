<?php

namespace Dyd\Console\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Input\InputOption;
use \Symfony\Component\Console\Output\OutputInterface;
use \Dyd\Util\Database\DydPDO;

/**
 * Command to display infos about the configured databases
 * and the environment
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class InfoCommand extends Command
{
    /**
     * Configures command
     */
    protected function configure()
    {
        $this
            ->setName('info')
            ->setDescription('Displays info of configured database.');
    }

    /**
     * Executes info command
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getBasicInfos());

        if ($input->getOption('verbose')) {
            $output->writeln($this->getAdditionalInfos());
        }
    }

    /**
     * Returns basic infos
     *
     * @return string
     */
    protected function getBasicInfos()
    {
        $longVersion = $this->getApplication()->getLongVersion();

        $databases = $this->getApplication()->getConfig()->getDatabases();
        $databaseInfos = '';
        foreach ($databases as $name => $database) {
            $databaseInfos .= $this->getDatabaseInfo(
                $name,
                $database['index'],
                $database['dsn']
            );
        }

        $output = <<< EOT
$longVersion

<comment>Configured Databases:</comment>
$databaseInfos

EOT;



        return $output;
    }

    /**
     * @param $name
     * @param $indexFile
     * @param $dsn
     * @return string
     */
    private function getDatabaseInfo($name, $indexFile, $dsn)
    {
        $indexFileExists = file_exists($indexFile);
        $fileInfo = $indexFileExists ? '<info>exists</info>' : '<error>does not exists</error>';
        $isConnected = false;
        $connectionStatus = $isConnected ? '<info>ok</info>' : '<error>not connected</error>';

        $output = <<< EOT
  <comment>$name:</comment>
    <comment>index:</comment> $indexFile ($fileInfo)
    <comment>dsn:</comment> $dsn ($connectionStatus)
EOT;

        return $output;
    }


    /**
     * Returns additional infos (verbose mode)
     *
     * @return string
     */
    private function getAdditionalInfos()
    {
        $configFilePath = $this->getApplication()->getConfig()->getConfigFilePath();
        $dydBin = realpath($_SERVER['SCRIPT_FILENAME']);
        $osVersion = php_uname();
        $phpVersion = phpversion();
        $includePath = get_include_path();

        $availableDbDriver = DydPDO::getAvailableDrivers();
        $availableDbDriver = empty($availableDbDriver) ? '-' : implode(', ', $availableDbDriver);

        $output = <<< EOT
<comment>Config:</comment>
  $configFilePath

<comment>Available database driver:</comment>
  $availableDbDriver

<comment>Environment:</comment>
  <comment>PHP-Version:</comment> $phpVersion
  <comment>OS-Version:</comment> $osVersion
  <comment>DYD bin:</comment> $dydBin
  <comment>Path:</comment> $includePath

EOT;

        return $output;
    }

    /**
     * Intend a string by a given count of spaces
     *
     * @param $string
     * @param $count
     * @return string
     */
    private function intend($string, $count)
    {
        return str_pad($string, $count, ' ', STR_PAD_LEFT);
    }
}
