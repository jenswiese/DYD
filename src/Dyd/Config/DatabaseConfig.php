<?php

namespace Dyd\Config;

/**
 * Container for Database configuration
 *
 * @author: Jens Wiese <jens@dev.lohering.de>
 * @since: 2012-11-08
 */
class DatabaseConfig
{
    /** @var string */
    private $name;

    /** @var string */
    private $indexFile;

    /** @var string */
    private $dsn;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var array */
    private $options = array();

    /**
     * @param string $indexFile
     */
    public function setIndexFile($indexFile)
    {
        $this->indexFile = $indexFile;
    }

    /**
     * @return string
     */
    public function getIndexFile()
    {
        return $this->indexFile;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $dsn
     */
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }

    /**
     * @return string
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
