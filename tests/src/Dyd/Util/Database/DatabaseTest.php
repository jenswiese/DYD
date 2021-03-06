<?php

namespace Dyd\Util\Database;

/**
 * Test class for Database.
 * Generated by PHPUnit on 2011-11-04 at 20:46:46.
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateWithValidDsn()
    {
        $dsn = 'sqlite::memory:';
        $database = new Database($dsn);

        $this->assertEquals('sqlite', $database->getDriver());
    }

    public function testCreateWithInvalidDsn()
    {
        $dsn = 'invalid';

        try {
            new Database($dsn);
        } catch (\PDOException $e) {
            $this->assertEquals('invalid data source name', $e->getMessage());
            return;
        }

        $this->fail('Invalid dsn should cause exception.');
    }

    public function testCreateWithUnknownPdoDriver()
    {
        $dsn = 'unknown:/database';

        try {
            new Database($dsn);
        } catch (\PDOException $e) {
            $this->assertEquals('could not find driver', $e->getMessage());
            return;
        }

        $this->fail('Unknown driver should cause exception.');
    }
}

