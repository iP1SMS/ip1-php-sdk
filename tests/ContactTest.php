<?php


use \IP1\RESTClient\Recipient\Contact;
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
        $this->completeContactString = trim(file_get_contents("tests/resources/contact.json"));
        $this->incompleteContactString = trim(file_get_contents("tests/resources/incomplete_contact.json"));
        $this->minimalContactString = trim(file_get_contents("tests/resources/minimal_contact.json"));
        $this->completeContactStd = json_decode($this->completeContactString);
        $this->incompleteContactStd = json_decode($this->incompleteContactString);
        $this->minimalContactStd = json_decode($this->minimalContactString);
    }
    public function testCreateFromStdClass()
    {
        $contact = Contact::createFromStdClass($this->completeContactStd);
        $this->assertEquals($this->completeContactString, json_encode($contact));
    }
    public function testCreateFromJSON()
    {
        $contact = Contact::createFromJSON($this->completeContactString);
        $this->assertEquals($this->completeContactString, json_encode($contact));
    }
    public function testCreateFromAttributes()
    {
        $contact = Contact::createFromAttributes(
            $this->completeContactStd->FirstName,
            $this->completeContactStd->Phone,
            $this->completeContactStd->LastName,
            $this->completeContactStd->Title,
            $this->completeContactStd->Organization,
            $this->completeContactStd->Email,
            $this->completeContactStd->Notes
        );
        $this->assertEquals($this->completeContactString, json_encode($contact));
    }
    public function testCreateFromIncompleteAttributes()
    {
        $jsonContact = trim(file_get_contents("tests/resources/incomplete_contact.json"));
        $this->completeContactStd = json_decode($jsonContact);

        $contact = Contact::createFromAttributes(
            $this->completeContactStd->FirstName,
            $this->completeContactStd->Phone,
            isset($this->completeContactStd->LastName) ? $this->completeContactStd->LastName : null,
            isset($this->completeContactStd->Title) ?  $this->completeContactStd->Title : null,
            isset($this->completeContactStd->Organization) ? $this->completeContactStd->Organization : null,
            isset($this->completeContactStd->Email) ? $this->completeContactStd->Email : null,
            isset($this->completeContactStd->Notes) ? $this->completeContactStd->Notes : null
        );
        $this->assertEquals($jsonContact, json_encode($contact));
    }
    public function testCreateFromIncompleteJSON()
    {
        $contact = Contact::createFromJSON($this->incompleteContactString);
        $this->assertEquals($this->incompleteContactString, json_encode($contact));
    }
    public function testCreateFromIncompleteStdClass()
    {
        $contact = Contact::createFromStdClass($this->incompleteContactStd);
        $this->assertEquals($this->incompleteContactString, json_encode($contact));
    }
    /**
    * @expectedException InvalidArgumentException
    */
    public function testPrivateConstructorWithInvalidArguments()
    {
        Contact::createFromAttributes("", $this->completeContactStd->Phone);
        Contact::createFromAttributes($this->completeContactStd->FirstName, "");
    }
    public function testGettersWithMembersSet()
    {
        $contact = Contact::createFromJSON($this->completeContactString);
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
        $contact = Contact::createFromJSON($this->minimalContactString);
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
        $contact = Contact::createFromJSON($this->minimalContactString);

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
