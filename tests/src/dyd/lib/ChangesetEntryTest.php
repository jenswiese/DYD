<?php

use dyd\lib\ChangesetEntry;

/**
 * Test class for ChangesetEntry.
 * Generated by PHPUnit on 2011-09-23 at 22:49:59.
 */
class ChangesetEntryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateChangeset()
    {
        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue($this->getTestChangesetXml('SELECT 1', 'DELETE 1')));

        $actualChangeset = new ChangesetEntry('TestChangeset1', $filesystemStub);

        $this->assertEquals('TestChangeset1', $actualChangeset->getName());
        $this->assertEquals('SELECT 1', $actualChangeset->getSql());
        $this->assertEquals('DELETE 1', $actualChangeset->getUndoSql());
    }

    public function testCreateChangesetFromEmptyFile()
    {
        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue(''));

        try {
            $actualChangeset = new ChangesetEntry('TestChangeset1', $filesystemStub);
        } catch (Exception $e) {
            $this->assertEquals(
                'Could not read xml-string.',
                $e->getMessage(),
                'Empty file should cause appropriate exception.'
            );
            return;
        }

        $this->fail('Empty file should throw exception.');
    }

    public function testCreateChangesetFromInvalidXml()
    {
        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue('<changeset></changeset>'));

        try {
            $actualChangeset = new ChangesetEntry('TestChangeset1', $filesystemStub);
        } catch (Exception $e) {
            $this->assertEquals(
                "Node '/changeset/sql' does not exists.",
                $e->getMessage(),
                'Invalid xml-file should cause appropriate exception.'
            );
            return;
        }

        $this->fail('Empty file should throw exception.');
    }

    public function testCreateChangesetWithEmptySqlNode()
    {
        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue($this->getTestChangesetXml('', '')));

        try {
            $actualChangeset = new ChangesetEntry('TestChangeset1', $filesystemStub);
        } catch (Exception $e) {
            $this->assertEquals(
                "Node '/changeset/sql' is empty.",
                $e->getMessage(),
                'Empty sql-node should cause appropriate exception.'
            );
            return;
        }

        $this->fail('Empty file should throw exception.');
    }

    public function testTrimmingOfSqlString()
    {
        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue($this->getTestChangesetXml(' SELECT 1 ', '      DELETE 1   ')));

        $actualChangeset = new ChangesetEntry('TestChangeset1', $filesystemStub);

        $this->assertEquals('SELECT 1', $actualChangeset->getSql());
        $this->assertEquals('DELETE 1', $actualChangeset->getUndoSql());
    }

    /**
     * constructs and return xml-data for use in tests
     *
     * @param array $changesetValues
     * @return string xml
     */
    private function getTestChangesetXml($sql, $undoSql)
    {
        $xmlContent  = '<?xml version="1.0" standalone="yes"?>';
        $xmlContent .= '<changeset>';
        $xmlContent .= '<sql>' . $sql . '</sql>';
        $xmlContent .= '<undo>' . $undoSql . '</undo>';
        $xmlContent .= '</changeset>';

        return $xmlContent;
    }

}

