<?php

namespace Dyd\Util\Database\Driver;

use Dyd\Util\Database\DatabaseInterface;

/**
 * MySQL Database Driver
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class Mysql implements DatabaseInterface
{
    protected $pdo;
    protected $tableName = 'dyd_changelog';

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Checks whether or not changelog table exists
     *
     * @return bool
     */
    public function hasChangelogTable()
    {
        $sql = "SHOW TABLES LIKE '" . $this->tableName . "';";
        $tableExists = (0 < $this->pdo->query($sql)->rowCount());

        return $tableExists;
    }

    /**
     * Creates changelog table
     */
    public function createChangelogTable()
    {
        $sql = <<< EOT
CREATE TABLE IF NOT EXISTS $this->tableName (
    name VARCHAR(255) NOT NULL,
    created_at DATETIME,
    undo_sql TEXT,
    checksum VARCHAR(255),
    UNIQUE(name)
) ENGINE = MYISAM;
EOT;

        $this->pdo->exec($sql);
    }

    /**
     * Retrieves all changelog names from database
     *
     * @return array
     * @throws \Exception
     */
    public function retrieveChangelogs()
    {
        $sql = 'SELECT name FROM ' . $this->tableName . ' ORDER BY created_at DESC;';
        $statement = $this->pdo->query($sql);

        if (false === $statement) {
            throw new \Exception('Could not retrieve changelogs.');
        }

        $changelogNames = array();
        while ($changelog = $statement->fetchObject()) {
            array_push($changelogNames, $changelog->name);
        }

        return $changelogNames;
    }

    /**
     * Retrieves one changelog by name
     *
     * @param $name
     * @return array
     * @throws \Exception
     */
    public function retrieveChangelogByName($name)
    {
        $sql = <<< EOT
SELECT
    name,
    created_at,
    undo_sql,
    checksum
FROM
    $this->tableName
WHERE
    name = '$name';
EOT;

        $statement = $this->pdo->query($sql);

        if (false === $statement) {
            throw new \Exception("Could not retrieve changelogs with name '" . $name . "'.");
        }

        $changelog = $statement->fetch(\PDO::FETCH_ASSOC);

        return $changelog;
    }

    /**
     * Executes query
     *
     * @param $sql
     */
    public function executeQuery($sql)
    {
        $this->pdo->exec($sql);
    }

    /**
     * Writes changelog to database
     *
     * @param $name
     * @param $executedSql
     * @throws \Exception
     */
    public function writeChangelog($name, $executedSql)
    {
        $created_at = time();
        $checksum = sha1($executedSql);

        $sql = <<< EOT
INSERT INTO
    $this->tableName
VALUES (
    '$name', '$created_at', '$executedSql', '$checksum'
);
EOT;


        $affectedRows = $this->pdo->exec($sql);

        if (0 == $affectedRows) {
            throw new \Exception("Could not write changelog with name '" . $name . "'");
        }
    }

    /**
     * Deletes changelog from database
     *
     * @param $name
     * @throws \Exception
     */
    public function deleteChangelog($name)
    {
        $sql = "DELETE FROM " . $this->tableName . " WHERE name = '" . $name . "';";
        $affectedRows = $this->pdo->exec($sql);

        if (0 == $affectedRows) {
            throw new \Exception("Could not delete changelog with name '" . $name . "'");
        }
    }
}
