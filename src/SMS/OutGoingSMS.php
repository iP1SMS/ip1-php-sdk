<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 iP.1 Networks AB
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.1.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/

namespace IP1\RESTClient\SMS;

use IP1\RESTClient\Recipient\ProcessedContact;
use IP1\RESTClient\Recipient\Group;
use IP1\RESTClient\Core\ProcessableComponentInterface;

/**
* Class that is used when wanting to send SMSes to the API.
*/
class OutGoingSMS extends SMS implements ProcessableComponentInterface
{
    /**
    * Contains all the phone numbers the SMS should be sent to.
    * @var array $numbers Phone numbers
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
    * @var boolean $email
    */
    protected $email = false;

    /**
    * Adds the number to the recipient list.
    * @param string $number A number that should be added to the recipient list.
    * @return void
    */
    public function addNumber(string $number): void
    {
        $this->numbers[] = $number;
    }
    /**
    * Adds the given array of numbers to the recipient list.
    * @param array $numbers An array of numbers(string).
    * @return void
    */
    public function addAllNumbers(array $numbers): void
    {
        $this->numbers = array_merge($this->numbers, $numbers);
    }
    /**
    * Removes the given index from the number recipient list.
    * @param integer $index The index being requested for deletion.
    * @return void
    */
    public function removeNumber(int $index): void
    {
        unset($this->numbers[$index]);
        $this->numbers = array_values($this->numbers);
    }
    /**
    * Returns the number in the given index.
    * @param integer $index The index being requested.
    * @return string    Phone number.
    * @throws \UndefinedOffsetException Thrown when the index requested does not exist.
    */
    public function getNumber(int $index): string
    {
        if ($index >= count($this->numbers)) {
            throw new \UndefinedOffsetException();
        }
        return $this->numbers[$index];
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
    * @param ProcessedContact $contact A ProcessedContact that should be added to the recipient list.
    * @return void
    */
    public function addContact(ProcessedContact $contact): void
    {
        $this->contacts[] = $contact;
    }
    /**
    * Removes the Contact in the given index and reindexes the array.
    * @param integer $index The index being requested for deletion.
    * @return void
    */
    public function removeContact(int $index): void
    {
        unset($this->contacts[$index]);
        $this->contacts = array_values($this->contacts);
    }
    /**
    * Adds the given array of contacts to the Contact recipient list.
    * @param array $contacts An array of Contact.
    * @return void
    */
    public function addAllContacts(array $contacts): void
    {
        $this->contacts = array_merge($this->contacts, $contacts);
    }
    /**
    * Adds the given Group to the recipient list.
    * @param Group $group A Group that should be added to the recipient list.
    * @return void
    */
    public function addGroup(Group $group): void
    {
        $this->groups[] = $group;
    }
    /**
    * Adds the given array of Groups to the recipient list.
    * @param array $groups An array of Groups.
    * @return void
    */
    public function addAllGroups(array $groups): void
    {
        $this->groups = array_merge($this->groups, $groups);
    }
    /**
    * Removes the Group in the given index and reindexes the array.
    * @param integer $index The index being requested for deletion.
    * @return void
    */
    public function removeGroup(int $index): void
    {
        unset($this->groups[$index]);
        $this->groups = array_values($this->groups);
    }
    /**
    * Returns the group in the given index.
    * @param integer $index The index being requested.
    * @return Group
    * @throws \UndefinedOffsetException Thrown when the index requested does not exist.
    */
    public function getGroup(int $index): Group
    {
        if ($index >= count($this->groups)) {
            throw new \UndefinedOffsetException();
        }
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


    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative .
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {

        $returnArray = parent::jsonSerialize();
        $returnArray['Email'] = $this->email;
        $returnArray['Numbers'] = $this->numbers;
        if (count($this->contacts) > 0) {
            $returnArray['Contacts'] = [];
            foreach ($this->contacts as $contact) {
                $returnArray['Contacts'][] = $contact->getID();
            }
        }
        if (count($this->groups) > 0) {
            $returnArray['Groups'] = [];
            foreach ($this->groups as $group) {
                $returnArray['Groups'][] = $group->getID();
            }
        }
        return $returnArray;
    }
}
