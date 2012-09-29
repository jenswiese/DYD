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
    protected $rollbackSql;
    protected $createdAt;

    public function __construct()
    {
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRollbackSql($rollbackSql)
    {
        $this->rollbackSql = $rollbackSql;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRollbackSql()
    {
        return $this->rollbackSql;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
