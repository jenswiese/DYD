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
    protected $configFile;

    /** @var array */
    protected $configuration;

    /**
     *
     */
    function __construct()
    {
        $currentDir = getcwd();
        $configDirectories = array($currentDir . '/config');
        $locator = new FileLocator($configDirectories);

        $configFile = $locator->locate('dyd.conf');

        $this->configuration = \Symfony\Component\Yaml\Yaml::parse($configFile);
    }
}
