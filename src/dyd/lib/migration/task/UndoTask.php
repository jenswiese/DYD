<?php
namespace dyd\lib\migration\task;

/**
 * Description of MigrationTask
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class UndoTask implements TaskInterface
{
    protected $changelogName;

    public function __construct($changelogName) {
        $this->changelogName = $changelogName;
    }

    public function getName()
    {
        return $this->changelogName;
    }

    public function getSql()
    {
//        $this->changelogName->getBackwardSql();
    }
}
