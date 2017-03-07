<?php
/**
* Contains the ProcessedMembership class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\Communicator;
use IP1\RESTClient\Core\ProcessedComponent;

class ProcessedMembership extends Membership implements ProcessedComponent
{

    /**
    * The ID of the Membership.
    * @var int $id
    */
    private $id;
    /**
    * When the membership was added to the API
    * @var DateTime $created
    */
    private $created;
    /**
    * ProcessedMembership Constructor
    * @param int $groupID
    * @param int $contactID
    * @param int $id
    * @param \DateTime $created
    */
    public function __construct(int $groupID, int $contactID, int $id, \DateTime $created)
    {
        parent::__construct($groupID, $contactID);
        $this->id = $id;
        $this->created = $created;
    }

    /** {@inheritDoc} */
    public function getID(): int
    {
        return $this->id;
    }
    /** {@inheritDoc} */
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
