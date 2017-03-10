<?php
/**
* Contains the ProcessedMembership class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @package IP1\RESTClient\Recipient
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\Communicator;
use IP1\RESTClient\Core\ProcessedComponent;

/**
* ProcessedMembership class.
* Is the relation between contacts and groups.
*/
class ProcessedMembership extends Membership implements ProcessedComponent
{

    /**
    * The ID of the Membership.
    * @var int $membershipID
    */
    private $membershipID;
    /**
    * When the membership was added to the API
    * @var DateTime $created
    */
    private $created;
    /**
    * ProcessedMembership Constructor
    * @param integer   $groupID      The ID of the group.
    * @param integer   $contactID    The ID of the contact.
    * @param integer   $membershipID The ID of the membership.
    * @param \DateTime $created      When the Membership was created.
    */
    public function __construct(int $groupID, int $contactID, int $membershipID, \DateTime $created)
    {
        parent::__construct($groupID, $contactID);
        $this->membershipID = $membershipID;
        $this->created = $created;
    }

    /**
    * Returns id of the Membership given by the API.
    * @return int Membership ID given by the API.
    */
    public function getID(): int
    {
        return $this->membershipID;
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
}
