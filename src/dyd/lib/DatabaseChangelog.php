<?php

namespace dyd\lib;

use dyd\lib\util\Database;

/**
 * Class represents changelog of database
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class DatabaseChangelog
{
    protected $database;

    public function __construct(Database $database = null)
    {
        $this->database = $database;
    }

    /**
     * returns array of ChangelogEntry names
     *
     * @return array of Changelog-names
     */
    public function getChangelogNames()
    {
        $names = array();
        foreach ($this->database->retrieveChangelogs() as $changelog) {
            array_push($names, $changelog['name']);
        }

        return $names;
    }

    /**
     * returns ChangelogEntry for given name
     *
     * @param string name
     * @return ChangelogEntry
     */
    public function getChangelog($name)
    {
        $changelogEntry = $this->database->retrieveChangelogByName($name);

        if (empty($changelogEntry)) {
            throw new \Exception("No changelog entry with name '" . $name . "'.");
        }

        $entry = new ChangelogEntry();
        $entry->setName($changelogEntry['name']);
        $entry->setBackwardSql($changelogEntry['backward_sql']);
        $entry->setCreatedAt($changelogEntry['created_at']);
        
        return $entry;
    }
}
