<?php
/**
* Contains the Membership class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @package IP1\RESTClient\Recipient
*/
namespace IP1\RESTClient\Recipient;

/**
* Membership is the bridge between ProcessedGroup and ProcessedContact.
*/
class Membership implements \JsonSerializable
{

    /**
    * A Group ID.
    * @var integer $groupID
    */
    protected $groupID;
/**
    * A Contact ID.
    * @var integer $contactID
    */
    protected $contactID;
/**
    * Membership Constructor.
    * @param integer $groupID   A Group ID.
    * @param integer $contactID A Contact ID.
    */
    public function __construct(int $groupID, int $contactID)
    {
        $this->groupID = $groupID;
        $this->contactID = $contactID;
    }
    /**
    * Returns Group ID.
    * @return integereger
    */
    public function getGroupID(): int
    {
        return $this->groupID;
    }
    /**
    * Returns Contact ID.
    * @return integereger
    */
    public function getContactID(): int
    {
        return $this->contactID;
    }
    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative.
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {
        $returnArray = [
        'Group' => $this->groupID,
        'Contact' => $this->ContactID,
        ];
        return $returnArray;
    }
}
