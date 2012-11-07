<?php

namespace Dyd\Util;

/**
 * Class serves global access to needed services
 * (e.g. Database, Filesystem)
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class ServiceLocator
{
    protected static $instances = array();

   /**
     * Sets instance of Database
     *
     * @param Dyd\Util\Database $database
     */
    public static function setPDO(\PDO $pdo)
    {
        self::$instances['pdo'] = $pdo;
    }

    /**
     * Returns instance of PDO
     *
     * @return \Dyd\Util\Database\DydPDO
     */
    public static function getPDO($dsn, $username = null, $passwd = null, $options = null)
    {
        if (isset(self::$instances['pdo']) && self::$instances['pdo'] instanceof \PDO) {
            return self::$instances['pdo'];
        }

        return new \Dyd\Util\Database\DydPDO($dsn, $username, $passwd, $options);
    }

    /**
     * Resets all instances
     *
     * @return void
     */
    public static function reset()
    {
        self::$instances = null;
    }
}
