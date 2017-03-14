<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
use PHPUnit\Framework\TestCase;
use IP1\RESTClient\Recipient\RecipientFactory;
use IP1\RESTClient\Recipient\ProcessedContact;

class ProcessedContactTest extends TestCase
{
    private $completeContactString;
    private $listContactString;
    private $completeContactStd;
    private $listContactStd;
    private $minimalContactString;
    private $minimalContactStd;

    public function __construct()
    {
        parent::__construct();
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
}
