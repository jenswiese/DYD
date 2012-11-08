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
     * Constructor of the class
     *
     * @param string $dsn
     * @param string $username
     * @param string $passwd (default: null)
     * @throws \Exception
     */
    public function __construct(\Dyd\Config\DatabaseConfig $config)
    {
        try {
            $pdo = \Dyd\Util\ServiceLocator::getPDO(
                $config->getDsn(),
                $config->getUsername(),
                $config->getPassword()
            );
            $this->driverName = $pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);

            $className = "Dyd\Util\Database\Driver\\" . ucfirst($this->driverName);
            if (!class_exists($className)) {
                throw new \Exception("Class '" . $className . "' does not exist.");
            }

            $this->database = new $className($pdo);
        } catch (\Exception $e) {
            // @todo: Log this exception
        }
    }

    public function isAvailable()
    {
        return !is_null($this->database);
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

}
