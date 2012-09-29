<?php

namespace Dyd\Migration;

use \Dyd\Changeset\ChangesetIndexFile;
use \Dyd\Changeset\ChangesetEntry;
use \Dyd\Changelog\ChangelogTable;
use \Dyd\Migration\Task\PerformChangeTask;
use \Dyd\Migration\Task\RollbackChangeTask;

/**
 * Description of MigrationPlanner
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class MigrationPlan //implements \RecursiveIterator
{
    const STATUS_SAFE = 1;
    const STATUS_UNSAFE = 2;

    protected $changesetEntries = array();
    protected $changelogEntries = array();

    protected $performChangeTasks = array();
    protected $rollbackChangeTasks = array();
    protected $planStatus = self::STATUS_SAFE;

    /**
     * Constructor of the class
     *
     * @param \Dyd\Changeset\ChangesetIndexFile $index
     * @param \Dyd\Changelog\ChangelogTable $changelog
     */
    public function __construct(ChangesetIndexFile $index, ChangelogTable $changelog)
    {
        $this->changesetEntries = $index->getChangesetNames();
        $this->changelogEntries = $changelog->getChangelogNames();

        $isNothingTodo = (empty($this->changesetEntries) && empty($this->changelogEntries));
        if ($isNothingTodo) {
            throw new MigrationNotNeededException('');
        }

        $this->planMigration();
    }

    /**
     * Returns Migration tasks
     *
     * @return array of MigrationTask
     */
    public function getMigrationTasks()
    {
        $migrationTasks = array_merge($this->rollbackChangeTasks, $this->performChangeTasks);

        return $migrationTasks;
    }

    /**
     * Returns status:
     * - MigrationPlan::STATUS_SAFE or
     * - MigrationPlan::STATUS_UNSAFE
     *
     * @return integer status
     */
    public function getPlanStatus()
    {
        return $this->planStatus;
    }

    /**
     * Plans migration tasks
     * by checking differences between index and database
     *
     * @return void
     */
    protected function planMigration()
    {
        foreach ($this->changesetEntries as $changesetName) {
            if ($this->isChangesetNotDeployedYet($changesetName)) {
                $this->addPerformChangeTask($changesetName);
            }
        }

        foreach ($this->changelogEntries as $changelogName) {
            if ($this->isChangelogNotInChangesetEntries($changelogName)) {
                $this->addRollbackTask($changelogName);
            }
        }
    }

    /**
     * Checks whether or not Changeset is deployed in order
     *
     * @param $indexOfEntry
     * @return boolean
     */
    protected function isChangesetDeployedInOrder($indexOfEntry)
    {
        if (!isset($this->changelogEntries[$indexOfEntry])) {
            return false;
        }

        return ($this->changesetEntries[$indexOfEntry] == $this->changelogEntries[$indexOfEntry]);
    }

    /**
     * Checks whether or not Changeset is deployed already
     *
     * @param $changesetName
     * @return boolean
     */
    protected function isChangesetNotDeployedYet($changesetName)
    {
        return (false === array_search($changesetName, $this->changelogEntries));
    }

    /**
     * Checks whether a deployed Changeset is not longer in index
     *
     * @param $changelogName
     * @return bool
     */
    protected function isChangelogNotInChangesetEntries($changelogName)
    {
        return (false === array_search($changelogName, $this->changesetEntries));
    }

    /**
     * Adds PerformChangeTask to migration plan
     *
     * @param $name
     */
    protected function addPerformChangeTask($name)
    {
        $task = new PerformChangeTask($name);
        array_push($this->performChangeTasks, $task);
    }

    /**
     * Adds RollbackChangeTask to migration plan
     *
     * @param $name
     */
    protected function addRollbackTask($name)
    {
        $this->planStatus = self::STATUS_UNSAFE;

        $task = new RollbackChangeTask($name);
        array_unshift($this->rollbackChangeTasks, $task);
    }
}
