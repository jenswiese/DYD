<?php

namespace Dyd\Changeset;

use \Dyd\Util\Filesystem;

/**
 * Class represents index file
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class IndexFile
{
    protected $filesystem;
    protected $changesetNames = array();

    /**
     * Constructor of the class
     *
     * @param string $filename
     * @param Filesystem $filesystem
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->filesystem = \Dyd\Util\ServiceLocator::getFilesystem();
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
        // @todo: Implement handling of simple textfiles instead of xml

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
