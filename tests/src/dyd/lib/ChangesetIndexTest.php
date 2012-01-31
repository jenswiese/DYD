<?php

use dyd\lib\ChangesetIndex;

/**
 * Test class for ChangesetIndex.
 * Generated by PHPUnit on 2011-09-22 at 22:37:06.
 */
class ChangesetIndexTest extends PHPUnit_Framework_TestCase
{
    public function testGetChangesetNames()
    {
        $expectedChangesetNames = array('TestChangeset1', 'TestChangeset2', 'TestChangeset3');
        $testIndexXml = $this->getTestIndexXml($expectedChangesetNames);

        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue($testIndexXml));

        $changesetIndex = new ChangesetIndex('index.xml', $filesystemStub);
        $actualChangesetNames = $changesetIndex->getChangesetNames();

        $this->assertEquals($expectedChangesetNames, $actualChangesetNames);
    }

    public function testGetChangesetNamesWithDuplicateEntries()
    {
        $expectedChangesetNames = array('TestChangeset1', 'TestChangeset1');
        $testIndexXml = $this->getTestIndexXml($expectedChangesetNames);

        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue($testIndexXml));

        $changesetIndex = new ChangesetIndex('index.xml', $filesystemStub);

        try {
            $changesetIndex->getChangesetNames();
        } catch (Exception $e) {
            $this->assertEquals(
                "Could not read index due to duplicate entries.",
                $e->getMessage(),
                'Duplicate entries in index-file should cause appropriate exception'
            );
            return;
        }

        $this->fail('Duplicate entries in index-file should cause exception.');
    }

    public function testGetChangesetNamesWithEmptyEntry()
    {
        $expectedChangesetNames = array('TestChangeset1', '');
        $testIndexXml = $this->getTestIndexXml($expectedChangesetNames);

        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue($testIndexXml));

        $changesetIndex = new ChangesetIndex('index.xml', $filesystemStub);

        try {
            $changesetIndex->getChangesetNames();
        } catch (Exception $e) {
            $this->assertEquals(
                "Could not read index due to empty entry.",
                $e->getMessage(),
                'Empty entry in index-file should cause appropriate exception'
            );
            return;
        }

        $this->fail('Empty entry in index-file should cause exception.');
    }

    public function testGetChangesetNamesWithInvalidXml()
    {
        $xmlContent = '<foo><changeset></bar>';

        $filesystemStub = $this->getMock('dyd\lib\util\Filesystem');
        $filesystemStub
            ->expects($this->any())
            ->method('readFromFile')
            ->will($this->returnValue($xmlContent)
        );

        try {
            $changesetConfig = new ChangesetIndex('filename', $filesystemStub);
            $actualChangeset = $changesetConfig->getChangesetNames();
        } catch (Exception $e) {
            $expectedMessage = "Could not read xml-string.";
            $this->assertEquals(
                $expectedMessage,
                $e->getMessage(),
                'Invalid changeset-xml should throw appropriate exception.'
            );
            
            return;
        }

        $this->fail('Invalid xml-format should cause an exception.');
    }


    /**
     * constructs and return xml-data for use in tests
     *
     * @param array $changesetValues
     * @return string xml
     */
    private function getTestIndexXml(array $changesetValues)
    {
        $xmlContent = '<?xml version="1.0" standalone="yes"?><changesets>';
        foreach ($changesetValues as $value) {
            $xmlContent .= '<changeset>' . $value . '</changeset>';
        }
        $xmlContent .= '</changesets>';

        return $xmlContent;
    }


}
