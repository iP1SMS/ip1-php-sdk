<?php
/**
* Contains the OutGoingSMS class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
use IP1\RESTClient\Recipient\Contact;
use IP1\RESTClient\Recipient\Group;

namespace IP1\RESTClient\SMS;

/**
* Class that is used when wanting to send SMSes to the API.
* @link http://api.ip1sms.com/Help/Api/PUT-api-contacts-contact
* @package \IP1\RESTClient\SMS;
*/
class OutGoingSMS extends SMS implements \JsonSerializable
{
    private $numbers = [];
    private $contacts = [];
    private $groups = [];
    private $email = false;
    /**
    * @param string $number A number that should be added to the recipient list
    */
    public function addNumber(string $number): void
    {
        $this->numbers[] = $number;
    }
    /**
    * @param Contact $contact A Contact that should be added to the recipient list
    */
    public function addContact(Contact $contact): void
    {
        $this->contacts[] = $contact;
    }
    /**
    * @param Group $group A Group that should be added to the recipient list
    */
    public function addGroup(Group $group): void
    {
        $this->groups[] = $group;
    }
    /** {@inheritDoc} */
    public function jsonSerialize(): \stdClass
    {
        $returnObject = parent::jsonSerialize();
        $returnObject->Email = $this->email;
        if (count($this->numbers) > 0) {
            $returnObject->Numbers = $this->numbers;
        }
        if (count($this->contacts) > 0) {
            $returnObject->Contacts = [];
            foreach ($this->contacts as $contact) {
                $returnObject->Contacts[] = $contact->getID();
            }
        }
        if (count($this->groups) > 0) {
            $returnObject->Groups = [];
            foreach ($this->groups as $group) {
                $returnObject->Groups[] = $group->getID();
            }
        }
        return $returnObject;
    }
}
