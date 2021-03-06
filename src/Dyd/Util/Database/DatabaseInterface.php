<?php

namespace Dyd\Util\Database;

/**
 * Interface for Database representations
 *
 * @author Jens Wiese <jens@dev.lohering.de>
 */
interface DatabaseInterface
{
    public function hasChangelogTable();

    public function createChangelogTable();

    public function retrieveChangelogs();

    public function retrieveChangelogByName($name);

    public function executeQuery($sql);

    public function writeChangelog($name, $sql);

    public function deleteChangelog($name);
}
