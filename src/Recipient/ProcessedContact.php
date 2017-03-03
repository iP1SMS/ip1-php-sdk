<?php
/**
* Contains the ProcessedContact class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Recipient;

use \IP1\RESTClient\Core\UpdatableComponent;

/**
* A Contact that has been added to the API. Has all the options that a normal Contact has.
* @link http://api.ip1sms.com/Help/Api/PUT-api-contacts-contact
* @package \IP1\RESTClient\SMS;
*/
class ProcessedContact extends Contact implements UpdatableComponent
{
    private $updated;
    private $contactID;
    private $created;
    const IS_READ_ONLY = false;
    /**
    * The ProcessedContact constructor
    *
    * @param string $firstName               The first name of the contact in question
    * @param string $phoneNumber             Contact phone number: with country code and without spaces and dashes
    * @param int    $contactID               Contact ID
    * @param string $lastName (optional)     Contact last name
    * @param string $organization (optional) Contact company or other organization
    * @param string $email (optional)        Contact email address
    * @param string $notes (optional)        Contact notes
    * @param DateTime $created (optional)    Date/time of when the contact was added
    * @param DateTime $updated (optional)    Date/time of when the contact was last updated/modified
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
    * {@inheritDoc}
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
    * @return bool Whether the object is read only or not
    */
    public function isReadOnly(): bool
    {
        return self::IS_READ_ONLY;
    }
    /**
    * @param  DateTimeZone $timezone (optional) The timezone that the user wants to get the DateTime in. Default is UTC
    * @return DateTime  When the Contact was added
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
    * @return int Contact ID
    */
    public function getID():int
    {
        return $this->contactID;
    }
    /**
    * @return array
    */
    public function jsonSerialize(): array
    {
        $contactArray = parent::jsonSerialize();
        $returnArray = array_merge(
            ['ID' => $this->contactID],
            $contactArray,
            [
                'Modified' => $this->updated->format("Y-m-d\TH:i:s.").
                  substr($this->updated->format('u'), 0, 3) ?? null,
                'Created' => $this->created->format("Y-m-d\TH:i:s.").
                  substr($this->updated->format('u'), 0, 3) ?? null,
            ]
        );
        return array_filter($returnArray);
    }
}
