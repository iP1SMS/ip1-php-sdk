<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 iP.1 Networks AB
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.3.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\ProcessedComponentInterface;
use IP1\RESTClient\Core\OwnableInterface;

/**
* ProcessedMembership class.
* Is the relation between contacts and groups.
*/
class ProcessedMembership extends Membership implements ProcessedComponentInterface, OwnableInterface
{

    /**
    * The ID of the Membership.
    * @var integer $membershipID
    */
    private $membershipID;
    /**
    * When the membership was added to the API
    * @var DateTime $created
    */
    private $created;
    /**
    * ID of account owning the membership
    * @var string $ownerID
    */
    private $ownerID;
    /**
    * ProcessedMembership Constructor
    * @param integer   $groupID      The ID of the group.
    * @param integer   $contactID    The ID of the contact.
    * @param integer   $membershipID The ID of the membership.
    * @param string    $ownerID      ID of account owning the membership.
    * @param \DateTime $created      When the Membership was created.
    */
    public function __construct(int $groupID, int $contactID, int $membershipID, string $ownerID, \DateTime $created)
    {
        parent::__construct($groupID, $contactID);
        $this->membershipID = $membershipID;
        $this->ownerID = $ownerID;
        $this->created = $created;
    }

    /**
    * Returns id of the Membership given by the API.
    * @return integer Membership ID given by the API.
    */
    public function getID(): int
    {
        return $this->membershipID;
    }
    /**
    * Returns ID of account owning the Membership
    * @return string ID of account owning the Membership
    */
    public function getOwnerID(): string
    {
        return $this->ownerID;
    }
    /**
    * @param \DateTimeZone $timezone The timezone that the user wants to get the DateTime in. Default is UTC.
    * @return \DateTime|null When the Component was added.
    */
    public function getCreated(\DateTimeZone $timezone = null): ?\DateTime
    {
        if (!is_null($timezone)) {
            $returnDate = clone $this->created;
            $returnDate->setTimeZone($timezone);
            return $returnDate;
        }
        return $this->created ?? null;
    }
    /**
    * Takes the given argument and replaces strings such as {id} to an actual value.
    * @param string $endPoint The endpoint to be corrected.
    * @return void
    */
    public function fillEndPoint(string &$endPoint): void
    {
        $endPoint = str_replace("{membership}", $this->membershipID, $endPoint);
    }
}
