<?php

namespace Dyd\Migration\Task;

/**
 * Interface for Migration tasks
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
interface TaskInterface
{
    public function getName();
    public function getSql();
}
