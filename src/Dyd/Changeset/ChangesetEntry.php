<?php

namespace Dyd\Changeset;

use Dyd\Util\Filesystem;

/**
 * Class represents entry in Changeset\Index
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class ChangesetEntry
{
    const UNDO_TOKEN = '--//@UNDO';

    const CHANGESET_SQL = 'change';
    const ROLLBACK_SQL = 'rollback';

    protected $name;
    protected $changeSql;
    protected $rollbackSql;
    protected $filesystem;

    /**
     * Constructor of the class
     *
     * @param $filename
     */
    public function __construct($filename, Filesystem $filesystem = null)
    {
        $this->name = $filename;
        $this->filesystem = is_null($filesystem)
            ? \Dyd\Util\ServiceLocator::getFilesystem()
            : $filesystem;

        $this->readSqlFromChangesetFile($filename);
    }

    /**
     * Returns name of Changeset file
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns changeset sql
     *
     * @return string
     */
    public function getChangeSql()
    {
        return $this->changeSql;
    }

    /**
     * Returns rollback sql
     *
     * @return string
     */
    public function getRollbackSql()
    {
        return $this->rollbackSql;
    }

    /**
     * Reads sql parts from file
     *
     * @param $filename
     * @throws \Exception
     */
    private function readSqlFromChangesetFile($filename)
    {
        $content = $this->filesystem->readFromFile($filename);
        $contentToken = $this->splitFileContent($content);

        if ('' == $contentToken[self::CHANGESET_SQL]) {
            throw new \Exception("'" . $filename . "' doesn't contain change sql.");
        }

        if ('' == $contentToken[self::ROLLBACK_SQL]) {
            throw new \Exception("'" . $filename . "' doesn't contain rollback sql.");
        }

        $this->changeSql = $contentToken[self::CHANGESET_SQL];
        $this->rollbackSql = $contentToken[self::ROLLBACK_SQL];
    }

    /**
     * Splits file content by UNDO-token
     *
     * @param string $content
     * @return array with two elements:
     *         self::CHANGE_TYPE_FORWARD,
     *         self::CHANGE_TYPE_UNDO
     */
    private function splitFileContent($content)
    {
        $content = strtok($content, self::UNDO_TOKEN);

        $token = array();
        $token[self::CHANGESET_SQL] = isset($content[0]) ? trim($content[0]) : '';
        $token[self::ROLLBACK_SQL] = isset($content[1]) ? trim($content[1]) : '';;

        return $token;
    }
}
