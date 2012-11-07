<?php

namespace Dyd\Console;

use \Dyd\Console\Config;

/**
 * Class represents console application
 *
 * @author: Jens Wiese <jens@dev.lohering.de>
 * @since: 2012-11-04
 */
class Application extends \Symfony\Component\Console\Application
{
    /** @var \Dyd\Console\Config */
    protected $config;

    /**
     * Constructor of the class
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $name = "dyd";
        $version = "0.1-dev";

        $this->config = $config;

        parent::__construct($name, $version);
    }

    /**
     * Returns dyd config
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
