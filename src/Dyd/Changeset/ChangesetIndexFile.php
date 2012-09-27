<?php

namespace Dyd\Changeset;

use \Dyd\Util\Filesystem;

/**
 * Class represents index file
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class ChangesetIndexFile
{
    protected $filesystem;
    protected $changesetNames = array();

    /**
     * Constructor of the class
     *
     * @param string $filename
     */
    public function __construct($filename, Filesystem $filesystem = null)
    {
        $this->filename = $filename;
        $this->filesystem = is_null($filesystem)
            ? \Dyd\Util\ServiceLocator::getFilesystem()
            : $filesystem;
    }

    /**
     * return array of changesetnames
     * 
     * @return array of Changesetnames
     */
    public function getChangesetNames()
    {
        if (empty($this->changesetNames)) {
            $this->changesetNames = $this->readEntriesFromFile();
        }

        return $this->changesetNames;
    }

    /**
     * Reads from changeset index and returns array of names
     *
     * @return array
     */
    private function readEntriesFromFile()
    {
        $content = $this->filesystem->readFromFile($this->filename);
        $entries = array();

        foreach (explode("\n", $content) as $entry) {
            $entry = trim($entry);

            $isEmptyValue = ('' == $entry);
            if ($isEmptyValue) {
                throw new \Exception("Could not read index due to empty entry.");
            }

            $alreadyExists = (false !== array_search($entry, $entries));
            if ($alreadyExists) {
                throw new \Exception("Could not read index due to duplicate entries.");
            }

            $entries[] = $entry;
        }

        return $entries;
    }

}
