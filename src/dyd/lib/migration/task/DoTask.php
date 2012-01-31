<?php
namespace dyd\lib\migration\task;

use dyd\lib\ChangesetEntry;

/**
 * Description of MigrationTask
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class DoTask implements TaskInterface
{
    protected $changesetName;

    public function __construct($name)
    {
        $this->changesetName = $name;
    }

    public function getName()
    {
        return $this->changesetName;
    }

    public function getSql()
    {

    }
}
