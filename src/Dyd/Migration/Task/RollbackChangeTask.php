<?php

namespace Dyd\Migration\Task;

/**
 * Description of MigrationTask
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class RollbackChangeTask implements TaskInterface
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
