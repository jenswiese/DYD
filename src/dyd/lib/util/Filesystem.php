<?php

namespace dyd\lib\util;

/**
 * class provides accesses to the filesystem
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
class Filesystem
{
    public function __construct() {
    }

    /**
     * reads and returns file content
     *
     * @param string $filename
     * @throws Exception
     * @return string
     */
    public function readFromFile($filename)
    {
        if(!file_exists($filename)) {
            throw new \Exception('File "' . $filename . '" does not exist.');
        }
        $content = file_get_contents($filename);

        return $content;
    }

}

