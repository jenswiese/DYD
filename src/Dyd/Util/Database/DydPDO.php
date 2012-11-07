<?php

namespace Dyd\Util\Database;

/**
 * Created by JetBrains PhpStorm.
 * User: jens
 * Date: 10/1/12
 * Time: 7:11 PM
 * To change this template use File | Settings | File Templates.
 */
class DydPDO extends \PDO
{
    /**
     * @param $dsn
     * @param $username
     * @param $passwd
     * @param $options
     */
    public function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        parent::__construct($dsn, $username, $passwd, $options);
    }




}
