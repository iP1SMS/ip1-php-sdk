<?php
/**
* Contains the Membership class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Recipient;

/**
*
*/
class Membership implements \JsonSerializable
{

    /**
    * A Group ID
    * @var int $groupID
    */
    protected $groupID;
/**
    * A Contact ID
    * @var int $contactID
    */
    protected $contactID;
/**
    * Membership Constructor
    * @param int $groupID A Group ID
    * @param int $contactID A Contact ID
    */
    public function __construct(int $groupID, int $contactID)
    {
        $this->groupID = $groupID;
        $this->contactID = $contactID;
    }
    /**
    * Returns Group ID
    * @return int
    */
    public function getGroupID(): int
    {
        return $this->groupID;
    }
    /**
    * Returns Contact ID
    * @return int
    */
    public function getContactID(): int
    {
        return $this->contactID;
    }
    public function jsonSerialize(): array
    {
        $returnArray = [
        'Group' => $this->groupID,
        'Contact' => $this->ContactID,
        ];
        return $returnArray;
    }
}
