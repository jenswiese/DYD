<?php

namespace Dyd\Changeset;

use Dyd\Util\Filesystem;

/**
 * Class represents entry in Changeset\Index
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class Entry
{
    const CHANGE_TYPE_FORWARD = 'sql';
    const CHANGE_TYPE_UNDO = 'undo';

    protected $name;
    protected $sql;
    protected $undoSql;
    protected $filesystem;

    public function __construct($filename)
    {
        $this->name = $filename;
        $this->filesystem = \Dyd\Util\ServiceLocator::getFilesystem();
        $this->sql = $this->readSqlFromChangesetFile($filename, self::CHANGE_TYPE_FORWARD);
        $this->undoSql = $this->readSqlFromChangesetFile($filename, self::CHANGE_TYPE_UNDO);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function getUndoSql()
    {
        return $this->undoSql;
    }

    private function readSqlFromChangesetFile($filename, $sqlType)
    {
        $content = $this->filesystem->readFromFile($filename);
        $domXml = new \DOMDocument();
        if (!@$domXml->loadXML($content)) {
            throw new \Exception('Could not read xml-string.');
        }

        $domXpath = new \DOMXPath($domXml);
        $sqlNodes = $domXpath->query('/changeset/' . $sqlType);

        $nodeDoesNotExists = is_null($sqlNodes->item(0));
        if ($nodeDoesNotExists) {
            throw new \Exception("Node '/changeset/" . $sqlType . "' does not exists.");
        }

        $sqlQueries = array();
        foreach ($sqlNodes as $node) {
            $nodeIsEmpty = ('' == $node->nodeValue);
            if ($nodeIsEmpty) {
                throw new \Exception("Node '/changeset/" . $sqlType . "' is empty.");
            }

            array_push($sqlQueries, trim($node->nodeValue));
        }

        return implode(';', $sqlQueries);
    }
}
