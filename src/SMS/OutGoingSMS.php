<?php
/**
* Contains the OutGoingSMS class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/

namespace IP1\RESTClient\SMS;

use IP1\RESTClient\Recipient\ProcessedContact;
use IP1\RESTClient\Recipient\Group;

/**
* Class that is used when wanting to send SMSes to the API.
* @link http://api.ip1sms.com/Help/Api/PUT-api-contacts-contact
* @package \IP1\RESTClient\SMS;
*/
class OutGoingSMS extends SMS implements \JsonSerializable
{
    /**
    * Contains all the phone numbers the SMS should be sent to
    * @var array $numbers phone numbers
    */
    protected $numbers = [];
    /**
    * Contains all the ProcessedContact the SMS should be sent to.
    * @var array $contacts
    */
    protected $contacts = [];
    /**
    * Contains all the Group the SMS should be sent to.
    * @var array $groups
    */
    protected $groups = [];
    /**
    * If emails should be sent to the recipients aswell.
    * @var bool $email
    */
    protected $email = false;

    /**
    * Adds the number to the recipient list.
    * @param string $number A number that should be added to the recipient list
    */
    public function addNumber(string $number): void
    {
        $this->numbers[] = $number;
    }
    /**
    * Adds the given array of numbers to the recipient list.
    * @param array $numbers An array of numbers(string)
    */
    public function addAllNumbers(array $numbers): void
    {
        $this->numbers = array_merge($this->numbers, $numbers);
    }
    /**
    * Removes the given index from the number recipient list
    * @param int $index
    */
    public function removeNumber(int $index)
    {
        unset($this->numbers[$index]);
        $this->numbers = array_values($this->numbers);
    }
    /**
    * Returns all the number recipient list.
    * @return array
    */
    public function getAllNumbers(): array
    {
        return $this->numbers;
    }
    /**
    * Adds the ProcessedContact to the recipient list.
    * @param ProcessedContact $contact A ProcessedContact that should be added to the recipient list
    */
    public function addContact(ProcessedContact $contact): void
    {
        $this->contacts[] = $contact;
    }
    /**
    * Removes the Contact in the given index and reindexes the array
    * @param int $index
    */
    public function removeContact(int $index): void
    {
        unset($this->contacts[$index]);
        $this->contacts = array_values($this->contacts);
    }
    /**
    * Adds the given array of contacts to the Contact recipient list.
    * @param array An array of Contact
    */
    public function addAllContacts(array $contacts): void
    {
        $this->contacts = array_merge($this->contacts, $contacts);
    }
    /**
    * Adds the given Group to the recipient list.
    * @param Group $group A Group that should be added to the recipient list
    */
    public function addGroup(Group $group): void
    {
        $this->groups[] = $group;
    }
    /**
    * Adds the given array of Groups to the recipient list.
    * @param array $groups An array of Groups
    */
    public function addAllGroups(array $groups): void
    {
        $this->groups = array_merge($this->groups, $groups);
    }
    /**
    * Removes the Group in the given index and reindexes the array
    * @param int $index
    */
    public function removeGroup(int $index): void
    {
        unset($this->groups[$index]);
        $this->groups = array_values($this->groups);
    }
    /**
    * Returns the group in the given index.
    * @param int $index
    * @return Group
    */
    public function getGroup(int $index): Group
    {
        return $this->groups[$index];
    }
    /**
    * Returns the Group recipient list.
    * @return array An array of Group.
    */
    public function getAllGroups(): array
    {
        return $this->groups;
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
