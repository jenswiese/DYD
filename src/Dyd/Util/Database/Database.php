<?php

namespace Dyd\Util\Database;

/**
 * Description of Database
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class Database implements DatabaseInterface
{
    protected $database;
    protected $driverName;
    protected $databaseName = 'dyd_changelog';

    /**
     * Constructor
     *
     * @param string $dns
     */
    public function __construct($dsn)
    {
        $this->database = $this->createByDsn($dsn);
    }

    public function getDriver()
    {
        return $this->driverName;
    }

    public function hasChangelogTable()
    {
        return $this->database->hasChangelogTable();
    }

    public function createChangelogTable()
    {
        return $this->database->createChangelogTable();
    }

    public function retrieveChangelogs()
    {
        return $this->database->createChangelogTable();
    }

    public function retrieveChangelogByName($name)
    {
        return $this->database->retrieveChangelogByName($name);
    }

    public function execQuery($sql)
    {
        return $this->database->execQuery($sql);
    }

    public function writeChangelog($name, $sql)
    {
        return $this->database->writeChangelog($name, $sql);
    }

    public function deleteChangelog($name)
    {
        return $this->database->deleteChangelog($name);
    }

    public function executeQuery($sql)
    {

    }

    /**
     *
     * @param string $dsn
     * @return implementation of DatabaseInterface
     */
    private function createByDsn($dsn)
    {
        $pdo = \Dyd\Util\ServiceLocator::getPDO($dsn);
        $this->driverName = $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);

        $className = "Dyd\Util\\" . ucfirst($this->driverName) . 'Database';
        if (!class_exists($className)) {
            throw new \Exception("Class '" . $className . "' does not exist.");
        }

        return new $className($pdo);
    }
}
