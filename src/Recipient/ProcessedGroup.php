<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\Communicator;
use IP1\RESTClient\Core\UpdatableComponentInterface;
use IP1\RESTClient\Core\ClassValidationArray;
use IP1\RESTClient\Recipient\ProcessedMembership;
use IP1\RESTClient\Core\OwnableInterface;

/**
*
*/
class ProcessedGroup extends Group implements UpdatableComponentInterface, MembershipRelationInterface, OwnableInterface
{
    /**
    * The ID of the Group given by the API.
    * @var integer $groupID
    */
    private $groupID;
    /**
    * When the Group was created.
    * @var \DateTime $created
    */
    private $created;
    /**
    * When the Group was last updated.
    * @var \DateTime $updated
    */
    private $updated;
    /**
    * ID of account owning the Group
    * @var string $ownerID
    */
    private $ownerID;
    /**
    * An array of memberships that the Group has.
    *
    * It is empty by default but is filled when the function getMemberships() is called if a Communicator is given
    *   as an argument.
    *
    * @var ClassValidationArray $membership
    */
    protected $memberships = [];
    /**
    * Tells whether memberships has been fetched from the API.
    * @var boolean $fetchedMemberships Defaults to false.
    */
    protected $fetchedMemberships = false;
    /**
    * An array of Contact that the Group has.
    *
    * It is empty by default but is filled when the function getContacts() is called if a Communicator is given
    *   as an argument.
    *
    * @var ClassValidationArray $contacts Default empty array.
    */
    protected $contacts = [];
    /**
    * Tells wheter contacts has been fetched from the API.
    * @var boolean $contactsFetched Defaults to false.
    */
    protected $contactsFetched = false;
    const IS_READ_ONLY = false;
    /**
    * ProcessedGroup Contstructor.
    * @param string    $name    Name of the Group.
    * @param string    $color   A hexadecimal color.
    * @param integer   $groupID An ID generated by the API.
    * @param string    $ownerID ID of account owning the Group.
    * @param \DateTime $created When the Group was initially created.
    * @param \DateTime $updated When the Group was last updated.
    */
    public function __construct(
        string $name,
        string $color,
        int $groupID,
        string $ownerID,
        \DateTime $created,
        \DateTime $updated
    ) {

        parent::__construct($name, $color);
        $this->groupID = $groupID;
        $this->ownerID = $ownerID;
        $this->created = $created;
        $this->updated = $updated;
        $this->memberships = new ClassValidationArray();
        $this->contacts = new ClassValidationArray();
    }
    /**
    * @return integer Group ID.
    */
    public function getID(): int
    {
        return $this->groupID;
    }
    /**
    * Returns ID of account owning the Group.
    * @return string
    */
    public function getOwnerID(): string
    {
        return $this->ownerID;
    }
    /**
    * Returns whether the object is read only or not.
    * @return boolean Whether the object is read only or not.
    */
    public function isReadOnly(): bool
    {
        return self::IS_READ_ONLY;
    }
    /**
    * Returns an array of all the memberships the group is referenced in.
    * If a communicator is not provided it will not fetch memberships from the API
    *               but return those that has been fetched, if any.
    * @param Communicator $communicator Used to fetch memberships from the API.
    * @return array An array of Membership objects
    */
    public function getMemberships(Communicator $communicator = null): ClassValidationArray
    {
        if ($communicator !== null) {
            $membershipJSON = $communicator->get("api/groups/".$this->groupID."/memberships");
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
    * Tells whether memberships has been fetched from the API or not.
    * @return boolean Whether the memberships has been fetched from the API or not.
    */
    public function memberShipsFetched(): bool
    {
        return $this->fetchedMemberships;
    }
    /**
    * Returns an array of all the Contacts that belong to the Group.
    * If a communicator is not provided it will not fetch Contacts from the API
    *               but return those that has been fetched, if any.
    * @param Communicator $communicator Used to fetch Contacts from the API.
    * @return ClassValidationArray An array of ProcessedContact objects.
    */
    public function getContacts(Communicator $communicator = null): ClassValidationArray
    {
        if ($communicator !== null) {
            $contactStd = $communicator->get('api/groups/'.$this->groupID. '/contacts');
            $contactStd = json_decode($contactStd);
            $contacts = RecipientFactory::createProcessedGroupsFromStdClassArray($contactStd);
            $this->contacts = $contacts;
            $this->contactsFetched = true;
        }
        return $this->contacts;
    }
    /**
    * Tells whether contacts has been fetched from the API or not.
    * @return boolean Whether the contacts has been fetched from the API or not.
    */
    public function contactsFetched(): bool
    {
        return $this->contactsFetched;
    }
    /**
    * @param Communicator     $communicator Used to add the membership to the API.
    * @param ProcessedContact $contact      The contact that is to be added to the Group.
    * @return ProcessedMembership
    */
    public function addMember(Communicator $communicator, ProcessedContact $contact): ProcessedMembership
    {
        $membership = new Membership($this->groupID, $contact->getID());
        $response = $communicator->post('api/memberships', $membership);
        $returnValue = ProcessedMembership(json_decode($response));
        if ($this->memberShipsFetched()) {
            $this->memberships[] = $returnValue;
        }
        return $returnValue;
    }

    /**
    * @param  \DateTimeZone $timezone The timezone that the user wants to get the DateTime in. Default is UTC.
    * @return \DateTime When the Component was added.
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
    * Returns when the component was updated last.
    * @param  \DateTimeZone $timezone The timezone that the user wants to get the DateTime in. Default is UTC.
    * @return \DateTime When the contact was updated/modified last.
    */
    public function getUpdated(\DateTimeZone $timezone = null) : ?\DateTime
    {
        if (!is_null($timezone)) {
            $returnDate = clone $this->updated;
            $returnDate->setTimeZone($timezone);
            return $returnDate;
        }
        return $this->updated ?? null;
    }
    /**
   * Serializes the object to a value that can be serialized natively by json_encode().
   * @return array Associative.
   * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
   */
    public function jsonSerialize(): array
    {
        $parentArray = parent::jsonSerialize();
        $parentArray['Created'] = isset($this->created) ? $this->updated->format("Y-m-d\TH:i:s.").
            substr($this->updated->format('u'), 0, 3) : null;
        $parentArray['Updated'] = isset($this->created) ? $this->updated->format("Y-m-d\TH:i:s.").
            substr($this->updated->format('u'), 0, 3) : null;
        $parentArray['ID'] = $this->groupID;
        return $parentArray;
    }
    /**
    * Takes the given argument and replaces strings such as {id} to an actual value.
    * @param string $endPoint The endpoint to be corrected.
    * @return void
    */
    public function fillEndPoint(string &$endPoint): void
    {
        $endPoint = str_replace("{group}", $this->groupID, $endPoint);
    }
}
