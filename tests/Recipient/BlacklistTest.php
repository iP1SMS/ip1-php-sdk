<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 iP.1 Networks AB
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.2.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
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
        $this->assertEquals("12025550125", $pbl->getPhoneNumber());
        $this->assertEquals(\DateTime::class, get_class($pbl->getCreated()));
    }
    /**
    * @group api
    */
    public function testAPI()
    {
        $blackListEntry = new BlacklistEntry("12025550125");
        $processed = $this->addBlacklistEntryToAPI($blackListEntry);
        $deleted = $this->removeBlacklistEntryToAPI($processed);
        $this->assertEquals($blackListEntry->getPhoneNumber(), $deleted->getPhoneNumber());
    }
    public function addBlacklistEntryToAPI(BlacklistEntry $entry): ProcessedBlacklistEntry
    {
        $blackListEntry = $this->getCommunicator()->add($entry);
        $this->assertEquals($entry->getPhoneNumber(), $blackListEntry->getPhoneNumber());
        return $blackListEntry;
    }
    public function removeBlacklistEntryToAPI(ProcessedBlacklistEntry $entry): ProcessedBlacklistEntry
    {
        $blackListEntry = $this->getCommunicator()->remove($entry);
        $this->assertEquals($entry->getID(), $blackListEntry->getID());
        $this->assertEquals($entry->getCreated(), $blackListEntry->getCreated());
        $this->assertEquals($entry->getPhoneNumber(), $blackListEntry->getPhoneNumber());
        return $blackListEntry;
    }
    public function tearDown()
    {
        if ($com = $this->getCommunicator()) {
            $arrayResponse = json_decode($com->get("api/blacklist"));
            foreach ($arrayResponse as $value) {
                $com->delete('api/blacklist/'.$value->ID);
            }
        }
    }
}
