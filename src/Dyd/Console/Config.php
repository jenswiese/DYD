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
     * @return array
     */
    public function getDatabases()
    {
        return $this->configuration['databases'];
    }
}
