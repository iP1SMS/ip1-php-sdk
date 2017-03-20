<?php

namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\ProcessedComponentInterface;

/**
* A BlacklistEntry that has been processed by the API.
*/
class ProcessedBlacklistEntry implements ProcessedComponentInterface
{
    /**
    * The ID of the BlacklistEntry
    * @var int $blacklistEntryID
    */
    private $blacklistEntryID;
    /**
    * When the blacklist entry was created. Saved in UTC.
    * @var \DateTime $created
    */
    private $created;
    /**
    * ProcessedBlacklistEntry Constructor
    * @param string    $phoneNumber      The phone number the BlacklistEntry should have.
    * @param integer   $blacklistEntryID The ID of the BlacklistEntry.
    * @param \DateTime $created          When the BlacklistEntry was added to the API.
    */
    public function __construct(string $phoneNumber, int $blacklistEntryID, \DateTime $created)
    {
        $this->phone = $phoneNumber;
        $this->blacklistEntryID = $blacklistEntryID;
        $this->created = $created;
    }
    /**
    * Returns the ID of the ProcessedBlacklistEntry
    * @return int ID of the ProcessedBlacklistEntry
    */
    public function getID(): int
    {
        return $this->blacklistEntryID;
    }
    /**
    * @param  \DateTimeZone $timezone The timezone that the user wants to get the DateTime in. Default is UTC.
    * @return ?\DateTime When the ProcessedContact was added.
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
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative.
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {
        $array = parent::jsonSerialize();
        $array['ID'] = $this->blacklistEntryID;
        $array['Created'] =  isset($this->created) ? $this->created->format("Y-m-d\TH:i:s.").
            substr($this->updated->format('u'), 0, 3) : null;
        return array_filter($array);
    }
    /**
      * Returns the object as a JSON string.
      * @return string
      */
    public function __toString(): string
    {
        return json_encode($this->jsonSerialize);
    }
    /**
    * Takes the given argument and replaces strings such as {id} to an actual value.
    * @param string $endPoint The endpoint to be corrected.
    * @return void
    */
    public function fillEndPoint(string &$endPoint): void
    {
        str_replace("{entry}", $this->blacklistEntryID, $endPoint);
    }
}
