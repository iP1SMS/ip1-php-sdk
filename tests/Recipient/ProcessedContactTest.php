<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/


namespace IP1\RESTClient\Test\Recipient;

use IP1\RESTClient\Recipient\RecipientFactory;
use IP1\RESTClient\Recipient\ProcessedContact;
use IP1\RESTClient\Test\Core\AbstractEnviromentProvider;
use \DateTime;
use \DateTimeZone;

class ProcessedContactTest extends AbstractEnviromentProvider
{
    private $completeContactString;
    private $listContactString;
    private $completeContactStd;
    private $listContactStd;
    private $minimalContactString;
    private $minimalContactStd;

    public function setUp()
    {
        parent::setUp();
        $this->completeContactString = trim(
            file_get_contents("tests/resources/processed_contact/processed_contact.json")
        );
        $this->incompleteContactString = trim(
            file_get_contents("tests/resources/processed_contact/list_processed_contact.json")
        );
        $this->minimalContactString = trim(
            file_get_contents("tests/resources/processed_contact/minimal_processed_contact.json")
        );
        $this->completeContactStd = json_decode($this->completeContactString);
        $this->incompleteContactStd = json_decode($this->incompleteContactString);
        $this->minimalContactStd = json_decode($this->minimalContactString);
    }
    public function tearDown()
    {
        if ($this->isCommunicatorEnabled()) {
            $contacts = RecipientFactory::createProcessedContactFromStdClassArray(
                json_decode($this->getCommunicator()->get('api/contacts'))
            );
            foreach ($contacts as $c) {
                $this->getCommunicator()->remove($c);
            }
        }
    }

    public function testCreateCompleteFromStdClass()
    {
        $contact = RecipientFactory::createProcessedContactFromStdClass($this->completeContactStd);
        $this->assertEquals($this->completeContactStd, json_decode(json_encode($contact)));
    }
    public function testCreateCompleteFromJSON()
    {
        $contact = RecipientFactory::createProcessedContactFromJSON($this->completeContactString);
        $this->assertEquals($this->completeContactStd, json_decode(json_encode($contact)));
    }
    public function testGettersWithMembersSet()
    {
        $contact = RecipientFactory::createProcessedContactFromJSON($this->completeContactString);
        $this->assertEquals(
            new \DateTime($this->completeContactStd->Modified, new DateTimeZone("UTC")),
            $contact->getUpdated()
        );
        $this->assertEquals(
            new \DateTime($this->completeContactStd->Created, new DateTimeZone("UTC")),
            $contact->getCreated()
        );
        $this->assertEquals($this->completeContactStd->ID, $contact->getID());
        $this->assertEquals(ProcessedContact::IS_READ_ONLY, $contact->isReadOnly());
        $this->assertEquals(false, $contact->isReadOnly());
    }
    /**
    * @group api
    */
    public function testAPI()
    {
        $contact = RecipientFactory::createContactFromJSON($this->completeContactString);
        $newContact = $this->getCommunicator()->add($contact);
        $this->assertEquals(ProcessedContact::class, get_class($newContact));
        $this->assertEquals($contact->getEmail(), $newContact->getEmail());
        $this->assertEquals($contact->getFirstName(), $newContact->getFirstName());
        $this->assertEquals($contact->getNotes(), $newContact->getNotes());
        $this->assertEquals($contact->getLastName(), $newContact->getLastName());
        $this->assertEquals($contact->getOrganization(), $newContact->getOrganization());
        $this->assertEquals($contact->getPhoneNumber(), $newContact->getPhoneNumber());
        $this->assertEquals($contact->getTitle(), $newContact->getTitle());
        $this->assertTrue(is_int($newContact->getID()));

        $newContact->setLastName("Swann");
        $newContact->setTitle("Queen");

        $alteredContact = $this->getCommunicator()->edit($newContact);
        $this->assertEquals(ProcessedContact::class, get_class($alteredContact));
        $this->assertEquals($newContact->getEmail(), $alteredContact->getEmail());
        $this->assertEquals($newContact->getFirstName(), $alteredContact->getFirstName());
        $this->assertEquals($newContact->getNotes(), $alteredContact->getNotes());
        $this->assertEquals($newContact->getLastName(), $alteredContact->getLastName());
        $this->assertEquals($newContact->getOrganization(), $alteredContact->getOrganization());
        $this->assertEquals($newContact->getPhoneNumber(), $alteredContact->getPhoneNumber());
        $this->assertEquals($newContact->getTitle(), $alteredContact->getTitle());
        $this->assertEquals($newContact->getID(), $alteredContact->getID());

        $deletedContact = $this->getCommunicator()->remove($newContact);
        $this->assertEquals(ProcessedContact::class, get_class($deletedContact));
        $this->assertEquals($newContact->getEmail(), $deletedContact->getEmail());
        $this->assertEquals($newContact->getFirstName(), $deletedContact->getFirstName());
        $this->assertEquals($newContact->getNotes(), $deletedContact->getNotes());
        $this->assertEquals($newContact->getLastName(), $deletedContact->getLastName());
        $this->assertEquals($newContact->getOrganization(), $deletedContact->getOrganization());
        $this->assertEquals($newContact->getPhoneNumber(), $deletedContact->getPhoneNumber());
        $this->assertEquals($newContact->getTitle(), $deletedContact->getTitle());
        $this->assertEquals($newContact->getID(), $deletedContact->getID());
    }
    /**
    * @group api
    */
    public function testIsContactBookEmpty()
    {
        $contacts = RecipientFactory::createProcessedContactFromStdClassArray(
            json_decode(
                $this->getCommunicator()->get("api/contacts")
            )
        );
        $this->assertEquals([], $contacts->getArrayCopy());
    }
}
