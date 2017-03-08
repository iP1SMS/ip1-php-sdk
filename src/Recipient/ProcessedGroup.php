<?php
/**
* Contains the ProcessedGroup class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\Communicator;
use IP1\RESTClient\Core\UpdatableComponent;
use IP1\RESTClient\Recipient\RecipientFactory;

class ProcessedGroup extends Group implements UpdatableComponent, MembershipRelation
{

    private $groupID;
    private $created;
    private $updated;
    protected $memberships = [];
    protected $fechedMemberships = false;
    protected $contacts = [];
    protected $contactsFetched = false;
    const IS_READ_ONLY = false;

    public function __construct(string $name, string $color, int $groupID, \DateTime $created, \DateTime $updated)
    {
        parent::__construct($name, $color);
        $this->groupID = $groupID;
        $this->created = $created;
        $this->updated = $updated;
    }
    /** {@inheritDoc} */
    public function getID(): int
    {
        return $this->groupID;
    }
    /** {@inheritDoc} */
    public function isReadOnly(): bool
    {
        return self::IS_READ_ONLY;
    }
    public function getMemberships(Communicator $communicator = null): array
    {
        if ($communicator != null) {
            $membershipJSON = $communicator->get("api/groups/".$this->groupID."/memberships");
            $membershipStd = json_decode($membershipJSON);
            $memberships = [];
            foreach ($membershipStd as $value) {
                $memberships[] = RecipientFactory::createProcessedMembershipFromStdClass($value);
            }
            $this->memberships = $memberships;
            $this->fetchedMemberships = true;
        }
        //TODO: Add functionality for fetching from the API
        return $this->memberships;
    }
    public function memberShipsFetched(): bool
    {
        return $this->fetchedMemberships;
    }
    public function getGroups(Communicator $communicator = null): array
    {
        if ($communicator != null) {
            $contactStd = $communicator->get('api/groups/'.$this->groupID. '/contacts');
            $contactStd = json_decode($contactStd);
            $contacts = RecipientFactory::createProcessedGroupsFromStdClassArray($contactStd);
            $this->contacts = $contacts;
            $this->contactsFetched = true;
        }
        return $this->contacts;
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
    /** {@inheritDoc} */
    public function getUpdated(\DateTimeZone $timezone = null) : ?\DateTime
    {
        if (!is_null($timezone)) {
            $returnDate = clone $this->updated;
            $returnDate->setTimeZone($timezone);
            return $returnDate;
        }
        return $this->updated ?? null;
    }
}
