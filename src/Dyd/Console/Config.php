<?php

namespace Dyd\Console;

use Symfony\Component\Config\FileLocator;

/**
 * Class for ...
 *
 * @author: jens
 * @since: 11/5/12
 */
class Config
{
    /** @var string */
    protected $configFilePath;

    /** @var array */
    protected $configuration;

    /** @var array */
    protected $databases = array();

    /**
     * Constructor of the class
     */
    public function __construct()
    {
        $currentDir = getcwd();
        $configDirectories = array($currentDir . '/config');
        $locator = new FileLocator($configDirectories);
        $this->configFilePath = $locator->locate('dyd.conf');
        $this->configuration = \Symfony\Component\Yaml\Yaml::parse($this->configFilePath);
    }

    /**
     * Returns path to config file
     *
     * @return string
     */
    public function getConfigFilePath()
    {
        return $this->configFilePath;
    }

    /**
     * Returns configured databases
     *
     * @return array of DatabaseConfig
     */
    public function getDatabases()
    {
        $databaseConfigs = array();
        foreach ($this->configuration['databases'] as $name => $database) {
            $databaseConfig = new \Dyd\Config\DatabaseConfig();
            $databaseConfig->setName($name);
            $databaseConfig->setIndexFile($database['index']);
            $databaseConfig->setDsn($database['dsn']);
            $databaseConfig->setUsername($database['username']);
            $databaseConfig->setPassword($database['passwd']);
            $databaseConfigs[] = $databaseConfig;
        }

        return $databaseConfigs;
    }
}
