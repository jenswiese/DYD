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
     * Sets instance of Filesystem
     *
     * @param Dyd\Util\Filesystem $filesystem
     */
    public static function setFilesystem(Filesystem $filesystem)
    {
        self::$instances['filesystem'] = $filesystem;
    }

    /**
     * Returns instance of Filesystem
     *
     * @return \Dyd\Util\Filesystem
     */
    public static function getFilesystem()
    {
        if (!self::$instances['filesystem'] instanceof Filesystem) {
            self::$instances['filesystem'] = new Filesystem();
        }

        return self::$instances['filesystem'];
    }

    /**
     * Sets instance of Database
     *
     * @param Dyd\Util\Database $database
     */
    public static function setDatabase(Database $database)
    {
        self::$instances['database'] = $database;
    }

    /**
     * Returns instance of Filesystem
     *
     * @return \Dyd\Util\Filesystem
     */
    public static function getDatabase()
    {
        if (!self::$instances['database'] instanceof Database) {
            throw new \RuntimeException('Could not retrieve Database.');
        }

        return self::$instances['database'];
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
