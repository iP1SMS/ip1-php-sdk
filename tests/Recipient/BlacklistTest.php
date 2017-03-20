<?php

namespace IP1\RESTClient\Test\Recipient;

use IP1\RESTClient\Test\Core\AbstractEnviromentProvider;
use IP1\RESTClient\Recipient\BlacklistEntry;
use IP1\RESTClient\Recipient\ProcessedBlacklistEntry;
use IP1\RESTClient\Test\Util\Util;

class BlacklistTest extends AbstractEnviromentProvider
{
    public function testConstructor()
    {
        $bl = new BlacklistEntry("12025550125");
        $this->assertEquals(BlacklistEntry::class, get_class($bl));
        $dateTime = Util::getRandomDateTime();
        $pbl = new ProcessedBlacklistEntry("12025550125", random_int(0, PHP_INT_MAX), $dateTime);
        $this->assertTrue(is_int($pbl->getID()));
        $this->assertTrue(0 < $pbl->getID());
    }
}
