<?php

/**
 * Test class for Filesystem.
 * Generated by PHPUnit on 2011-09-22 at 21:11:29.
 */
class FilesystemTest extends \PHPUnit_Framework_TestCase
{
    protected $filesystem;
    protected $filename;

    protected function setUp() {
        $this->filesystem = new dyd\lib\util\Filesystem;
        $this->filename = "/tmp/" . uniqid();
    }

    protected function tearDown() 
    {
        if(file_exists($this->filename)) {
            unlink($this->filename);
        }
    }

    public function testReadNonExistentFile()
    {
        try {
            $filename = "/tmp/nonexistent";
            $content = $this->filesystem->readFromFile($filename);
        } catch(Exception $e) {
            $this->assertEquals(
                'File "' . $filename . '" does not exist.',
                $e->getMessage()
            );
            
            return;
        }

        $this->fail('Reading the non-existent file "' . $filename . '" should throw an exception.');
    }

    public function testReadFromFile()
    {
        $testContent = '<data>testdata</data>';
        file_put_contents($this->filename, $testContent);
        $content = $this->filesystem->readFromFile($this->filename);

        $this->assertEquals($testContent, $content, 'The read content did not match the expected string');
    }

}
