<?php

use dyd\lib\ChangelogEntry;

/**
 * Test class for ChangelogEntry.
 * Generated by PHPUnit on 2011-09-23 at 22:57:00.
 */
class ChangelogEntryTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp() {
        $this->object = new ChangelogEntry();
    }

    public function testSettingValues()
    {
        $name = "Testname";
        $backwardSql = "DELETE 1";
        $createdAt = "2011-12-01 00:00:11";

        $this->object->setName($name);
        $this->object->setBackwardSql($backwardSql);
        $this->object->setCreatedAt($createdAt);

        $this->assertEquals($name, $this->object->getName());
        $this->assertEquals($backwardSql, $this->object->getBackwardSql());
        $this->assertEquals($createdAt, $this->object->getCreatedAt());
    }

}
