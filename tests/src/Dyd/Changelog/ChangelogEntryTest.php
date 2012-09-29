<?php

namespace Dyd\Changelog;

/**
 * Test class for ChangelogEntry.
 * Generated by PHPUnit on 2011-09-23 at 22:57:00.
 */
class ChangelogEntryTest extends \PHPUnit_Framework_TestCase
{
    public function testSettingValues()
    {
        $entry = new ChangelogEntry();

        $name = "Testname";
        $rollbackSql = "DELETE 1";
        $createdAt = "2011-12-01 00:00:11";

        $entry->setName($name);
        $entry->setRollbackSql($rollbackSql);
        $entry->setCreatedAt($createdAt);

        $this->assertEquals($name, $entry->getName());
        $this->assertEquals($rollbackSql, $entry->getRollbackSql());
        $this->assertEquals($createdAt, $entry->getCreatedAt());
    }

}
