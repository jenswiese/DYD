<?php
namespace dyd\lib\migration;

use dyd\lib\ChangesetIndex;
use dyd\lib\DatabaseChangelog;
use dyd\lib\migration\task\DoTask;
use dyd\lib\migration\task\Undo;

/**
 * Test class for MigrationPlan.
 * Generated by PHPUnit on 2011-10-28 at 21:09:19.
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class MigrationPlanTest extends \PHPUnit_Framework_TestCase
{
    public function testUnneededMigrationCall()
    {
        $indexEntries = array(
            'changeset1',
            'changeset2',
            'changeset3'
        );
        $changelogEntries = array(
            'changeset1',
            'changeset2',
            'changeset3'
        );
        $expectedTasks = array(
        );

        $actualTasks = $this->getMigrationTasksFromTestCandidate($indexEntries, $changelogEntries);

        $this->assertEquals($expectedTasks, $actualTasks, '$message');
    }

    public function testForwardMigrationWithEmptyDatabase()
    {
        $indexEntries = array(
            'changeset1',
            'changeset2',
            'changeset3'
        );
        $changelogEntries = array();
        $expectedTasks = array(
            'Do:changeset1',
            'Do:changeset2',
            'Do:changeset3'
        );

        $actualTasks = $this->getMigrationTasksFromTestCandidate($indexEntries, $changelogEntries);

        $this->assertEquals($expectedTasks, $actualTasks, '$message');
    }

    public function testForwardMigration()
    {
        $indexEntries = array(
            'changeset1',
            'changeset2',
            'changeset3',
            'changeset4',
            'changeset5',
            'included1/changeset1',
        );
        $changelogEntries = array(
            'changeset1',
            'changeset2',
            'changeset3'
        );
        $expectedTasks = array(
            'Do:changeset4',
            'Do:changeset5',
            'Do:included1/changeset1',
        );

        $actualTasks = $this->getMigrationTasksFromTestCandidate($indexEntries, $changelogEntries);

        $this->assertEquals($expectedTasks, $actualTasks, '$message');
    }

    public function testUndoMigration()
    {
        $indexEntries = array(
            'changeset1',
            'changeset2',
            'changeset3'
        );
        $changelogEntries = array(
            'changeset1',
            'changeset2',
            'changeset3',
            'changeset4',
            'changeset5'
        );
        $expectedTasks = array(
            'Undo:changeset5',
            'Undo:changeset4'
        );

        $actualTasks = $this->getMigrationTasksFromTestCandidate($indexEntries, $changelogEntries);

        $this->assertEquals($expectedTasks, $actualTasks, '$message');
    }

    public function testSimpleMixedMigration()
    {
        $indexEntries = array(
            'changeset1',
            'changeset2',
            'changeset3',
            'changeset5',
            'changeset6',
            'changeset7',
        );
        $changelogEntries = array(
            'changeset1',
            'changeset2',
            'changeset3',
            'changeset4',
            'changeset5'
        );
        $expectedTasks = array(
            'Undo:changeset4',
            'Do:changeset6',
            'Do:changeset7',
        );

        $actualTasks = $this->getMigrationTasksFromTestCandidate($indexEntries, $changelogEntries);

        $this->assertEquals($expectedTasks, $actualTasks, '$message');
    }

    public function testComplexMixedMigration()
    {
        $indexEntries = array(
            'changeset1',
            'changeset2',
            'changeset3',
            'changeset5',
            'changeset9'
        );
        $changelogEntries = array(
            'changeset1',
            'changeset2',
            'changeset3',
            'changeset4',
            'changeset5',
            'changeset6',
            'changeset7',
            'changeset8'
        );
        $expectedTasks = array(
            'Undo:changeset8',
            'Undo:changeset7',
            'Undo:changeset6',
            'Undo:changeset4',
            'Do:changeset9',
        );

        $actualTasks = $this->getMigrationTasksFromTestCandidate($indexEntries, $changelogEntries);

        $this->assertEquals($expectedTasks, $actualTasks, '$message');
    }

    public function testStatusIfMigrationIsSafe()
    {
        $indexEntries = array(
            'changeset1',
            'changeset2'
        );
        $changelogEntries = array(
            'changeset1'
        );

        $changesetIndexMock = $this->getMockForChangesetIndex($indexEntries);
        $databaseChangelogMock = $this->getMockForDatabaseChangelog($changelogEntries);
        $plan = new MigrationPlan($changesetIndexMock, $databaseChangelogMock);

        $this->assertEquals(MigrationPlan::STATUS_SAFE, $plan->getPlanStatus());
    }

    public function testStatusIfMigrationIsUnSafe()
    {
        $indexEntries = array(
            'changeset1',
            'changeset2'
        );
        $changelogEntries = array(
            'changeset1',
            'changeset2',
            'changeset3'
        );

        $changesetIndexMock = $this->getMockForChangesetIndex($indexEntries);
        $databaseChangelogMock = $this->getMockForDatabaseChangelog($changelogEntries);
        $plan = new MigrationPlan($changesetIndexMock, $databaseChangelogMock);

        $this->assertEquals(MigrationPlan::STATUS_UNSAFE, $plan->getPlanStatus());
    }



    private function getMigrationTasksFromTestCandidate(array $indexEntries, array $changelogEntries)
    {
        $changesetIndexMock = $this->getMockForChangesetIndex($indexEntries);
        $databaseChangelogMock = $this->getMockForDatabaseChangelog($changelogEntries);

        $plan = new MigrationPlan($changesetIndexMock, $databaseChangelogMock);

        $tasks = array();
        foreach ($plan->getMigrationTasks() as $task) {
            $taskType = ($task instanceof DoTask) ? 'Do' : 'Undo';
            $taskName = $taskType . ':' . $task->getName();
            array_push($tasks, $taskName);
        }

        return $tasks;
    }

    private function getMockForChangesetIndex(array $returnValue)
    {
        $mock = $this->getMock('Dyd\lib\ChangesetIndex', array(), array(), '', false);
        $mock
            ->expects($this->any())
            ->method('getChangesetNames')
            ->will($this->returnValue($returnValue));

        return $mock;
    }

    private function getMockForDatabaseChangelog(array $returnValue)
    {
        $mock = $this->getMock('Dyd\lib\Changeset', array(), array(), '', false);
        $mock
            ->expects($this->any())
            ->method('getChangelogNames')
            ->will($this->returnValue($returnValue));

        return $mock;
    }

}