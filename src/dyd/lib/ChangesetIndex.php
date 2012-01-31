<?php

namespace dyd\lib;

use dyd\lib\util\Filesystem;

/**
 * Representation of index file
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class ChangesetIndex
{
    protected $filesystem;
    protected $changesetNames = array();

    /**
     * @param string $filename
     * @param Filesystem $filesystem
     */
    public function __construct($filename, Filesystem $filesystem = null)
    {
        $this->filename = $filename;
        $this->filesystem = is_null($filesystem) ? new Filesystem() : $filesystem;
    }

    /**
     * return array of changesetnames
     * 
     * @return array of Changesetnames
     */
    public function getChangesetNames()
    {
        if (empty($this->changesetNames)) {
            $this->changesetNames = $this->readChangesetEntriesFromFile();
        }

        return $this->changesetNames;
    }

    /**
     * reads from changeset xml and returns array of names
     *
     * @return array
     */
    private function readChangesetEntriesFromFile()
    {
        $content = $this->filesystem->readFromFile($this->filename);
        $entries = array();

        $domXml = new \DOMDocument();        
        if (!@$domXml->loadXML($content)) {
            throw new \Exception('Could not read xml-string.');
        }
        
        $changesetNodes = $domXml->getElementsByTagName('changeset');
        foreach ($changesetNodes as $node) {
            $alreadyExists = (false !== array_search($node->nodeValue, $entries));
            if ($alreadyExists) {
                throw new \Exception("Could not read index due to duplicate entries.");
            }

            $isEmptyValue = ('' == $node->nodeValue);
            if ($isEmptyValue) {
                throw new \Exception("Could not read index due to empty entry.");
            }

            $entries[] = $node->nodeValue;
        }
        
        return $entries;
    }

}
