<?php

namespace Dyd\Changelog;

/**
 * Class represents entry in database log
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class ChangelogEntry
{
    protected $name;
    protected $backwardSql;
    protected $createdAt;

    public function __construct() {
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setBackwardSql($backwardSql)
    {
        $this->backwardSql = $backwardSql;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBackwardSql()
    {
        return $this->backwardSql;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
