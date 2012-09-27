<?php

namespace Dyd\Migration\Task;

use Dyd\Changeset\Entry;

/**
 * Class XXX
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class PerformChangeTask implements TaskInterface
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
