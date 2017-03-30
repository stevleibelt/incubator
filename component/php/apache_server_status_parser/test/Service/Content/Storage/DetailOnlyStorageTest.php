<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-30
 */

namespace Test\Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage;

use JonasRudolph\PHPComponents\StringUtility\Implementation\StringUtility;
use Net\Bazzline\Component\ApacheServerStatusParser\Service\Content\Storage\DetailOnlyStorage;
use PHPUnit_Framework_TestCase;

class DetailOnlyStorageTest extends PHPUnit_Framework_TestCase
{
    public function testAddInformation()
    {
        $storage    = $this->getNewStorage();

        self::assertEmpty($storage->getListOfInformation());
        $storage->addInformation('tralala');
        self::assertEmpty($storage->getListOfInformation());
    }

    public function testAddScoreboard()
    {
        $storage    = $this->getNewStorage();

        self::assertEmpty($storage->getListOfScoreboard());
        $storage->addScoreboard('tralala');
        self::assertEmpty($storage->getListOfScoreboard());
    }

    public function testAddStatistic()
    {
        $storage    = $this->getNewStorage();

        self::assertEmpty($storage->getListOfStatistic());
        $storage->addStatistic('tralala');
        self::assertEmpty($storage->getListOfStatistic());
    }

    /**
     * @return DetailOnlyStorage
     */
    private function getNewStorage()
    {
        return new DetailOnlyStorage(
            new StringUtility()
        );
    }
}