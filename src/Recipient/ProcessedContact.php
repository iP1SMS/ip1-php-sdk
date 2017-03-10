<?php
/**
* Contains the ProcessedContact class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @link http://api.ip1sms.com/Help/Api/PUT-api-contacts-contact
* @package \IP1\RESTClient\Recipient;
*/
namespace IP1\RESTClient\Recipient;

use \IP1\RESTClient\Core\UpdatableComponent;
use IP1\RESTClient\Recipient\RecipientFactory;
use IP1\RESTClient\Recipient\MembershipRelation;
use IP1\RESTClient\Core\Communicator;

/**
* A Contact that has been added to the API. Has all the options that a normal Contact has.
*/
class ProcessedContact extends Contact implements UpdatableComponent, MembershipRelation
{
    /**
    * The ID of the Contact given by the API.
    * @var int $contactID
    */
    private $contactID;
    /**
    * When the Contact was created.
    * @var \DateTime $created
    */
    private $created;
    /**
    * When the Contact was last updated.
    * @var \DateTime $updated
    */
    private $updated;
    /**
    * An array of Memberships that the Group has.
    *
    * It is empty by default but is filled when the function getMemberships() is called if a Communicator is given
    *   as an argument.
    *
    * @var array $membership
    */
    protected $memberships = [];
    /**
    * Tells whether memberships has been fetched from the API.
    * @var bool $fetchedMemberships Defaults to false.
    */
    protected $fetchedMemberships = false;
    /**
    * An array of Group that the Contact is a member of.
    *
    * It is empty by default but is filled when the function getGroups() is called if a Communicator is given
    *   as an argument.
    *
    * @var array $groups Default empty array.
    */
    protected $groups = [];
    /**
    * Tells wheter Groups has been fetched from the API.
    * @var bool $groupsFetched Defaults to false.
    */
    protected $groupsFetched = false;
    const IS_READ_ONLY = false;
    /**
    * The ProcessedContact constructor
    *
    * @param string     $firstName    The first name of the contact in question.
    * @param string     $phoneNumber  Contact phone number: with country code and without spaces and dashes.
    * @param integer    $contactID    Contact ID.
    * @param ?string    $lastName     Contact last name.
    * @param ?string    $title        The contacts title.
    * @param ?string    $organization Contact company or other organization.
    * @param ?string    $email        Contact email address.
    * @param ?string    $notes        Contact notes.
    * @param ?\DateTime $created      Date/time of when the contact was added.
    * @param ?\DateTime $updated      Date/time of when the contact was last updated/modified.
    */
    public function __construct(
        string $firstName,
        string $phoneNumber,
        int $contactID,
        ?string $lastName,
        ?string $title,
        ?string $organization,
        ?string $email,
        ?string $notes,
        ?\DateTime $created = null,
        ?\DateTime $updated = null
    ) {
        parent::__construct($firstName, $phoneNumber, $lastName, $title, $organization, $email, $notes);
        $this->contactID = $contactID;
        $this->created = $created ?? null;
        $this->updated = $updated ?? null;
    }
    /**
      * Returns an array of all the memberships the group is referenced in.
      * If a communicator is not provided it will not fetch memberships from the API
      *               but return those that has been fetched, if any.
      * @param Communicator $communicator Used to fetch memberships from the API.
      * @return array An array of Membership objects.
      */
    public function getMemberships(Communicator $communicator = null): array
    {
        if ($communicator != null) {
            $membershipJSON = $communicator->get("api/contacts/".$this->contactID."/memberships");
            $membershipStd = json_decode($membershipJSON);
            $memberships = [];
            foreach ($membershipStd as $value) {
                $memberships[] = RecipientFactory::createProcessedMembershipFromStdClass($value);
            }
            $this->memberships = $memberships;
            $this->fetchedMemberships = true;
        }
        return $this->memberships;
    }
    /**
    * Returns an array of all the Groups the group is referenced in.
    * If a communicator is not provided it will not fetch memberships from the API
    *               but return those that has been fetched, if any.
    * @param Communicator $communicator Used to fetch Groups from the API.
    * @return array An array of Group objects.
    */
    public function getGroups(Communicator $communicator = null): array
    {
        if ($communicator != null) {
            $groupsJSON = $communicator->get('api/contacts/'.$this->contactID. '/groups');
            $groupStd = json_decode($groupsJSON);
            $groups = RecipientFactory::createProcessedGroupsFromStdClassArray($groupStd);
            $this->groups = $groups;
            $this->fetchedGroups = true;
        }
        return $this->groups;
    }
    /**
    * Tells whether Groups has been fetched from the API or not.
    * @return bool Whether the Groups has been fetched from the API or not.
    */
    public function isGroupsFetched(): bool
    {
        return $this->groupsFetched;
    }
    /**
    * Tells whether Memberships has been fetched from the API or not.
    * @return bool Whether the Memberships has been fetched from the API or not.
    */
    public function memberShipsFetched(): bool
    {
        return $this->fetchedMemberships;
    }
    /**
    * Returns when the component was updated last.
    * @param  \DateTimeZone $timezone The timezone that the user wants to get the DateTime in.
    *               Default is UTC.
    * @return \DateTime When the contact was updated/modified last.
    */
    public function getUpdated(\DateTimeZone $timezone = null): ?\DateTime
    {
        if (!is_null($timezone)) {
            $returnDate = clone $this->updated;
            $returnDate->setTimeZone($timezone);
            return $returnDate;
        }
        return $this->updated ?? null;
    }
    /**
    * @return bool Whether the object is read only or not.
    */
    public function isReadOnly(): bool
    {
        return self::IS_READ_ONLY;
    }
    /**
    * @param  \DateTimeZone $timezone The timezone that the user wants to get the DateTime in. Default is UTC.
    * @return ?\DateTime When the Contact was added.
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
    * @return int Contact ID.
    */
    public function getID():int
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
        $contactArray = parent::jsonSerialize();
        $returnArray = array_merge(
            ['ID' => $this->contactID],
            $contactArray,
            [
                'Modified' => isset($this->created) ? $this->updated->format("Y-m-d\TH:i:s.").
                substr($this->updated->format('u'), 0, 3) : null,
                'Created' => isset($this->created) ? $this->created->format("Y-m-d\TH:i:s.").
                substr($this->updated->format('u'), 0, 3) : null,
            ]
        );
        return array_filter($returnArray);
    }
    /**
    * Returns the object as a JSON string.
    * @return string
    */
    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }
}
