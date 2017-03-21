<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.2.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Test\Recipient;

use IP1\RESTClient\Recipient\RecipientFactory;
use IP1\RESTClient\Recipient\ProcessedGroup;
use IP1\RESTClient\Recipient\Group;
use IP1\RESTClient\Test\Core\AbstractEnviromentProvider;
use IP1\RESTClient\Test\Util\Util;
use \DateTime;
use \DateTimeZone;
use PHPUnit\Framework\TestCase;

class ProcessedGroupTest extends AbstractEnviromentProvider
{
    /**
    * @dataProvider getProcessedGroups
    */
    public function testGetters($group)
    {
        $this->assertTrue(is_int($group->getID()));
        $this->assertTrue(0 < $group->getID());
        $this->assertEquals(\DateTime::class, get_class($group->getCreated()));
        $this->assertEquals(\DateTime::class, get_class($group->getUpdated()));
        $this->assertStringStartsWith("ip1-", $group->getOwnerID());
        $this->assertEquals($group->getCreated(), $group->getCreated(new \DateTimeZone("UTC")));
        $this->assertEquals($group->getUpdated(), $group->getUpdated(new \DateTimeZone("UTC")));
        if ($group->getCreated(new \DateTimeZone("Indian/Reunion")) !== $group->getCreated()) {
            $this->addToAssertionCount(1);
        } else {
            $this->fail();
        }
        if ($group->getUpdated(new \DateTimeZone("Indian/Reunion")) !== $group->getCreated()) {
            $this->addToAssertionCount(1);
        } else {
            $this->fail();
        }
    }
    public static function getProcessedGroups(): array
    {
        $retval = [];
        for ($i = 0; $i < 50; $i++) {
            $retval[] = new ProcessedGroup(
                Util::getRandomAlphaString(),
                Util::getRandomHex(),
                random_int(1, PHP_INT_MAX),
                Util::getRandomAccountID(),
                Util::getRandomDateTime(),
                Util::getRandomDateTime()
            );
        }
        return [$retval];
    }
    /**
    * @group api
    */
    public function testAPI()
    {
        for ($i=0; $i < 50; $i++) {
          //
            $group = new Group(Util::getRandomAlphaString(), Util::getRandomHex());
            $processedGroup = $this->addGroupToAPI($group);

            $processedGroup->setName(Util::getRandomAlphaString());
            $processedGroup->setColor(Util::getRandomHex());

            $editedGroup = $this->editGroupToAPI($processedGroup);
            $this->removeGroupToAPI($editedGroup);
        }
    }
    public function addGroupToAPI(Group $group): ProcessedGroup
    {
        $processedGroup = $this->getCommunicator()->add($group);
        $this->assertEquals($group->getName(), $processedGroup->getName());
        $this->assertEquals($group->getColor(), $processedGroup->getColor());
        $this->assertStringStartsWith("ip1-", $processedGroup->getOwnerID());
        $this->assertTrue(is_int($processedGroup->getID()));
        $this->assertTrue(0 < $processedGroup->getID());

        return $processedGroup;
    }
    public function editGroupToAPI(ProcessedGroup $processedGroup): ProcessedGroup
    {
        $editedGroup = $this->getCommunicator()->edit($processedGroup);
        $this->assertEquals($processedGroup->getOwnerID(), $editedGroup->getOwnerID());
        $this->assertEquals($processedGroup->getName(), $editedGroup->getName());
        $this->assertEquals($processedGroup->getColor(), $editedGroup->getColor());
        if ($editedGroup->getUpdated() !== $processedGroup->getUpdated()) {
            $this->addToAssertionCount(1);
        } else {
            $this->fail();
        }
        $this->assertEquals($processedGroup->getCreated(), $editedGroup->getCreated());
        return $editedGroup;
    }
    public function removeGroupToAPI(ProcessedGroup $editedGroup): ProcessedGroup
    {
        $removedGroup = $this->getCommunicator()->remove($editedGroup);
        $this->assertEquals($editedGroup->getID(), $removedGroup->getID());
        $this->assertEquals($editedGroup->getName(), $removedGroup->getName());
        $this->assertEquals($editedGroup->getColor(), $removedGroup->getColor());
        $this->assertEquals($editedGroup->getCreated(), $removedGroup->getCreated());
        $this->assertEquals($editedGroup->getUpdated(), $removedGroup->getUpdated());
        $this->assertEquals($editedGroup->getOwnerID(), $removedGroup->getOwnerID());
        $this->assertEquals($editedGroup->getContacts(), $removedGroup->getContacts());
        $this->assertEquals($editedGroup->getMemberships(), $removedGroup->getMemberships());
        $this->assertEquals($editedGroup->memberShipsFetched(), $removedGroup->memberShipsFetched());
        $this->assertEquals($editedGroup->contactsFetched(), $removedGroup->contactsFetched());
        return $removedGroup;
    }
}
