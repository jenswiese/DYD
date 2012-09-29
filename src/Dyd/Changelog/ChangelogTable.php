<?php

namespace Dyd\Changelog;

use \Dyd\Util\Database;

/**
 * Class represents changelog of database
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class ChangelogTable
{
    protected $database;

    /**
     * Constructor of the class
     *
     * @param \Dyd\Util\Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Returns array of ChangelogEntry names
     *
     * @return array of Changelog-names
     */
    public function getChangelogNames()
    {
        $names = array();
        foreach ($this->database->retrieveChangelogs() as $changelog) {
            $names[] = $changelog['name'];
        }

        return $names;
    }

    /**
     * Returns ChangelogEntry for given name
     *
     * @param string name
     * @return ChangelogEntry
     * @throws \Exception
     */
    public function getChangelog($name)
    {
        $changelogEntry = $this->database->retrieveChangelogByName($name);

        if (empty($changelogEntry)) {
            throw new \Exception("No changelog entry with name '" . $name . "'.");
        }

        $entry = new ChangelogEntry();
        $entry->setName($changelogEntry['name']);
        $entry->setRollbackSql($changelogEntry['rollback_sql']);
        $entry->setCreatedAt($changelogEntry['created_at']);
        
        return $entry;
    }
}
