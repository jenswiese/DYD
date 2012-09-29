<?php

namespace Dyd\Util;

/**
 * Class provides access to the filesystem
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class Filesystem
{
    /**
     * Constructor of the class
     */
    public function __construct()
    {
    }

    /**
     * Reads and returns file content
     *
     * @param string $filename
     * @throws \Exception
     * @return string
     */
    public function readFromFile($filename)
    {
        if (!file_exists($filename)) {
            throw new \Exception('File "' . $filename . '" does not exist.');
        }

        $content = file_get_contents($filename);

        return $content;
    }

}

