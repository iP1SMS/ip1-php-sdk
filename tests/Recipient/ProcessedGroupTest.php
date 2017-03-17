<?php

namespace IP1\RESTClient\Test\Recipient;

use PHPUnit\Framework\TestCase;
use IP1\RESTClient\Recipient\ProcessedGroup;
use IP1\RESTClient\Test\Util\Util;

class ProcessedGroupTest extends TestCase
{
    /**
    * @dataProvider getProcessedGroups
    */
    public function testGetters(ProcessedGroup $group)
    {
        $this->assertTrue(is_int($group->getID()));
        $this->assertTrue(0 < $group->getID());
    }
    public static function getProcessedGroups(): array
    {
        $retval = [];
        for ($i = 0; $i < 50; $i++) {
            $retval[] = new ProcessedGroup(
                Util::getRandomAlphaString(),
                Util::getRandomHex(),
                random_int(1, PHP_INT_MAX),
                Util::getRandomDateTime(),
                Util::getRandomDateTime()
            );
        }
        return [$retval];
    }
}
