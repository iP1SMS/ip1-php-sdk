<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/

use IP1\RESTClient\Recipient\RecipientFactory;
use PHPUnit\Framework\TestCase;

/**
* @covers Contact
*/
class ContactTest extends TestCase
{

    private $completeContactString;
    private $incompleteContactString;
    private $completeContactStd;
    private $incompleteContactStd;
    private $minimalContactString;
    private $minimalContactStd;

    public function __construct()
    {
        parent::__construct();
        $this->completeContactString = trim(file_get_contents("tests/resources/contact/contact.json"));
        $this->incompleteContactString = trim(file_get_contents("tests/resources/contact/incomplete_contact.json"));
        $this->minimalContactString = trim(file_get_contents("tests/resources/contact/minimal_contact.json"));
        $this->completeContactStd = json_decode($this->completeContactString);
        $this->incompleteContactStd = json_decode($this->incompleteContactString);
        $this->minimalContactStd = json_decode($this->minimalContactString);
    }
    public function testCreateFromStdClass()
    {
        $contact = RecipientFactory::createContactFromStdClass($this->completeContactStd);
        $this->assertEquals($this->completeContactStd, json_decode(json_encode($contact)));
    }
    public function testCreateFromJSON()
    {
        $contact = RecipientFactory::createContactFromJSON($this->completeContactString);
        $this->assertEquals($this->completeContactStd, json_decode(json_encode($contact)));
    }
    public function testCreateFromAttributes()
    {
        $contact = RecipientFactory::createContactFromAttributes(
            $this->completeContactStd->FirstName,
            $this->completeContactStd->Phone,
            $this->completeContactStd->LastName,
            $this->completeContactStd->Title,
            $this->completeContactStd->Organization,
            $this->completeContactStd->Email,
            $this->completeContactStd->Notes
        );
        $this->assertEquals($this->completeContactStd, json_decode(json_encode($contact)));
    }
    public function testCreateFromIncompleteAttributes()
    {
        $contact = RecipientFactory::createContactFromAttributes(
            $this->incompleteContactStd->FirstName,
            $this->incompleteContactStd->Phone,
            $this->incompleteContactStd->LastName ?? null,
            $this->incompleteContactStd->Title ?? null,
            $this->incompleteContactStd->Organization ?? null,
            $this->incompleteContactStd->Email ?? null,
            $this->incompleteContactStd->Notes ?? null
        );
          $this->assertEquals($this->incompleteContactStd, json_decode(json_encode($contact)));
    }
    public function testCreateFromIncompleteJSON()
    {
        $contact = RecipientFactory::createContactFromJSON($this->incompleteContactString);
          $this->assertEquals($this->incompleteContactStd, json_decode(json_encode($contact)));
    }
    public function testCreateFromIncompleteStdClass()
    {
        $contact = RecipientFactory::createContactFromStdClass($this->incompleteContactStd);
          $this->assertEquals($this->incompleteContactStd, json_decode(json_encode($contact)));
    }
    /**
    * @expectedException InvalidArgumentException
    */
    public function testPrivateConstructorWithInvalidArguments()
    {
        RecipientFactory::createContactFromAttributes("", $this->completeContactStd->Phone);
        RecipientFactory::createContactFromAttributes($this->completeContactStd->FirstName, "");
    }
    public function testGettersWithMembersSet()
    {
        $contact = RecipientFactory::createContactFromJSON($this->completeContactString);
        $this->assertEquals($this->completeContactStd->FirstName, $contact->getFirstName());
        $this->assertEquals($this->completeContactStd->LastName, $contact->getLastName());
        $this->assertEquals($this->completeContactStd->Phone, $contact->getPhoneNumber());
        $this->assertEquals($this->completeContactStd->Email, $contact->getEmail());
        $this->assertEquals($this->completeContactStd->Title, $contact->getTitle());
        $this->assertEquals($this->completeContactStd->Organization, $contact->getOrganization());
        $this->assertEquals($this->completeContactStd->Notes, $contact->getNotes());
    }
    public function testGettersWithMembersNotSet()
    {
        $contact = RecipientFactory::createContactFromJSON($this->minimalContactString);
        $this->assertEquals($this->minimalContactStd->FirstName, $contact->getFirstName());
        $this->assertEquals("", $contact->getLastName());
        $this->assertEquals($this->minimalContactStd->Phone, $contact->getPhoneNumber());
        $this->assertEquals("", $contact->getEmail());
        $this->assertEquals("", $contact->getTitle());
        $this->assertEquals("", $contact->getOrganization());
        $this->assertEquals("", $contact->getNotes());
    }
    public function testSetters()
    {
        $contact = RecipientFactory::createContactFromJSON($this->minimalContactString);

        $contact->setFirstName("Lorem");
        $contact->setLastName("Ipsum");
        $contact->setTitle("dolor");
        $contact->setOrganization("sit");
        $contact->setPhoneNumber("12025550148");
        $contact->setEmail("amet");
        $contact->setNotes("Facilis dolores mea ut.");

        $this->assertEquals("Lorem", $contact->getFirstName());
        $this->assertEquals("Ipsum", $contact->getLastName());
        $this->assertEquals("dolor", $contact->getTitle());
        $this->assertEquals("sit", $contact->getOrganization());
        $this->assertEquals("12025550148", $contact->getPhoneNumber());
        $this->assertEquals("amet", $contact->getEmail());
        $this->assertEquals("Facilis dolores mea ut.", $contact->getNotes());
    }
}
