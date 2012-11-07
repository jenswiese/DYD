<?php

namespace Dyd\Util\Database\Driver;

/**
 * Description of Database
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class Mysql implements DatabaseInterface
{
    protected $pdo;
    protected $databaseName = 'dyd_changelog';

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function hasChangelogTable()
    {
        $sql = "SELECT name FROM sqlite_master WHERE name='" . $this->databaseName . "'";
        $tableExists = (0 < count($this->pdo->query($sql)));

        return $tableExists;
    }

    public function createChangelogTable()
    {
        $sql = 'CREATE TABLE ' . $this->databaseName . ' (created_at INTEGER, name TEXT UNIQUE, undo_sql BLOB);';
        $this->pdo->exec($sql);
    }

    public function retrieveChangelogs()
    {
        $sql = 'SELECT name FROM ' . $this->databaseName . ' ORDER BY created_at DESC;';
        $statement = $this->pdo->query($sql);

        if (false !== $statement) {
            throw new Exception('Could not retrieve changelogs.');
        }

        $changelogNames = array();
        foreach ($statement->fetch() as $changelogName) {
            array_push($changelogNames, $changelogName);
        }

        return $changelogNames;
    }

    public function retrieveChangelogByName($name)
    {
        $sql = "SELECT name, created_at, undo_sql FROM " . $this->databaseName . " WHERE name = ORDER BY created_at DESC;";
        $statement = $this->pdo->query($sql);

        if (false !== $statement) {
            throw new Exception("Could not retrieve changelogs with name '" . $name . "'.");
        }

        $changelog = $statement->fetch();

        return $changelog;
    }

    public function executeQuery($sql)
    {
        $this->pdo->exec($sql);
    }

    

    public function writeChangelog($name, $executedSql)
    {
        $sql = "INSERT INTO " . $this->databaseName . " (created_at, name, undo_sql) VALUES ('" . time() . "', '" . $name . "', '" . $executedSql . "')";
        $affectedRows = $this->pdo->exec($sql);

        if (0 != $affectedRows) {
            throw new Exception("Could not delete changelog with name '" . $name . "'");
        }
    }


    public function deleteChangelog($name)
    {
        $sql = "DELETE FROM " . $this->databaseName . " WHERE name = '" . $name . "';";
        $affectedRows = $this->pdo->exec($sql);

        if (0 != $affectedRows) {
            throw new Exception("Could not delete changelog with name '" . $name . "'");
        }
    }
}
