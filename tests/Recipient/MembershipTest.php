<?php
namespace IP1\RESTClient\Test\Recipient;

use IP1\RESTClient\Recipient\Group;
use IP1\RESTClient\Recipient\Contact;
use IP1\RESTClient\Recipient\Membership;
use IP1\RESTClient\Test\Core\AbstractEnviromentProvider;
use IP1\RESTClient\Test\Util\Util;
use IP1\RESTClient\Core\ClassValidationArray;

class MembershipTest extends AbstractEnviromentProvider
{

    /**
    * @dataProvider getMembershipArguments
    */
    public function testConstructor($groupID, $contactID)
    {
        $m = new Membership($groupID, $contactID);
        $this->assertEquals($groupID, $m->getGroupID());
        $this->assertEquals($contactID, $m->getContactID());
    }
    public function getMembershipArguments(): array
    {
        $argumentArray = [];
        for ($i = 0; $i < 50; $i++) {
            $argumentArray[] = [random_int(0, PHP_INT_MAX), random_int(0, PHP_INT_MAX)];
        }
        return $argumentArray;
    }
    /**
    * @group api
    */
    public function testAPI()
    {
        $contacts = [];
        $groups = [];
        $memberships = [];
        for ($i = 0; $i < 10; $i++) {
            $c = new Contact(Util::getRandomAlphaString(), Util::getRandomPhoneNumber());
            $contacts[] =  $this->getCommunicator()->add($c);
            $g = new Group(Util::getRandomAlphaString(), Util::getRandomHex());
            $groups[] = $this->getCommunicator()->add($g);
            $m = new Membership($groups[$i]->getID(), $contacts[$i]->getID());
            $memberships[] = $this->getCommunicator()->add($m);
        }
        $this->assertEquals(10, count($contacts));
        $this->assertEquals(10, count($groups));
        $this->assertEquals(10, count($memberships));
        for ($i = 0; $i < count($memberships); $i++) {
            $contactMemberships = $contacts[$i]->getMemberships($this->getCommunicator());
            $this->assertEquals(1, count($contactMemberships));
            $this->assertEquals($contactMemberships[0]->getContactID(), $contacts[$i]->getID());
            $this->assertEquals($contactMemberships[0]->getGroupID(), $groups[$i]->getID());

            $contactGroups = $contacts[$i]->getGroups($this->getCommunicator());
            $this->assertEquals(1, count($contactGroups));
            $this->assertEquals(new ClassValidationArray($groups[$i]), $contactGroups);
        }
    }
    public function tearDown()
    {
        if ($this->isCommunicatorEnabled()) {
            $memberships = json_decode($this->getCommunicator()->get('api/memberships'));
            foreach ($memberships as $key => $value) {
                $this->getCommunicator()->delete('api/memberships/'.$value->ID);
            }

            $contacts = json_decode($this->getCommunicator()->get('api/memberships'));
            foreach ($contacts as $key => $value) {
                $this->getCommunicator()->delete('api/memberships/'.$value->ID);
            }
            $groups = json_decode($this->getCommunicator()->get('api/groups'));
            foreach ($groups as $key => $value) {
                $this->getCommunicator()->delete('api/groups/'.$value->ID);
            }
        }
    }
}
