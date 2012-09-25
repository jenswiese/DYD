<?php

namespace dyd\lib\migration;

use dyd\lib\ChangesetIndex;
use dyd\lib\ChangesetEntry;
use dyd\lib\DatabaseChangelog;
use dyd\lib\ChangelogEntry;
use dyd\lib\migration\task\DoTask;
use dyd\lib\migration\task\UndoTask;

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

    protected $doTasks = array();
    protected $undoTasks = array();
    protected $planStatus = self::STATUS_SAFE;

    public function __construct(ChangesetIndex $index, DatabaseChangelog $changelog)
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
     * returns Migration tasks
     *
     * @return array of MigrationTask
     */
    public function getMigrationTasks()
    {
// var_dump($this->undoTasks, $this->doTasks);exit;
        $migrationTasks = array();
        $migrationTasks = array_merge($this->undoTasks, $this->doTasks);

        return $migrationTasks;
    }

    /**
     * returns status:
     * - MigrationPlan::STATUS_SAFE or
     * - MigrationPlan::STATUS_UNSAFE
     *
     * @return integer status
     */
    public function getPlanStatus()
    {
       return $this->planStatus;
    }

    protected function planMigration()
    {
        foreach ($this->changesetEntries as $changesetName) {
            if ($this->isChangesetNotDeployedYet($changesetName)) {
                $this->addDoTask($changesetName);
            }
        }

        foreach ($this->changelogEntries as $changelogName) {
            if ($this->isChangelogNotInChangesetEntries($changelogName)) {
                $this->addUndoTask($changelogName);
            }
        }
    }

    protected function isChangesetDeployedInOrder($index)
    {
        if (!isset($this->changelogEntries[$index])) {
            return false;
        }

        return ($this->changesetEntries[$index] == $this->changelogEntries[$index]);
    }

    protected function isChangesetNotDeployedYet($changesetName)
    {
        return (false === array_search($changesetName, $this->changelogEntries));
    }

    protected function isChangelogNotInChangesetEntries($changelogName)
    {
        return (false === array_search($changelogName, $this->changesetEntries));
    }

    protected function addDoTask($name)
    {
        $doTask = new DoTask($name);
        array_push($this->doTasks, $doTask);
    }

    protected function addUndoTask($name)
    {
        $this->planStatus = self::STATUS_UNSAFE;
        
        $undoTask = new UndoTask($name);
        array_unshift($this->undoTasks, $undoTask);
    }

}
