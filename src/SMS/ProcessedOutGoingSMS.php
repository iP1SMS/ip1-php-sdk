<?php
/**
* Contains the ProcessedOutGoingSMS class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/

namespace IP1\RESTClient\SMS;

use IP1\RESTClient\Core\UpdatableComponent;

/**
* The response from the API when you post an SMS to the API
* @link http://api.ip1sms.com/Help/Api/PUT-api-contacts-contact
* @package \IP1\RESTClient\SMS
*/
class ProcessedOutGoingSMS extends SMS implements UpdatableComponent
{
    private $smsID;
    private $bundleID;
    private $status;
    private $statusDescription;
    private $recipient;
    private $created;
    private $updated;
    const IS_READ_ONLY = true;

    public function __construct(
        string $sender,
        string $message,
        string $recipient,
        int $smsID,
        \DateTime $created,
        \DateTime $updated,
        int $status,
        string $statusDescription = "",
        ?int $bundleID = null
    ) {

        $this->from = $sender;
        $this->message = $message;
        $this->recipient = $recipient;
        $this->smsID = $smsID;
        $this->status = $status;
        $this->statusDescription = $statusDescription;
        $this->bundleID = $bundleID;
        $this->created = $created;
        $this->updated = $updated;
    }
    /**
    * @return int Message bundle ID, if any
    */
    public function getBundleID(): ?int
    {
        return $this->bundleID;
    }
    /**
    * @return int Status Code
    * @link https://www.ip1sms.com/manuals/restful/title/sms-status-codes
    */
    public function getStatus(): int
    {
        return $this->status;
    }
    /**
    * @return string Status Description
    * @link https://www.ip1sms.com/manuals/restful/title/sms-status-codes
    */
    public function getStatusDescription(): string
    {
        return $this->statusDescription;
    }
    /**
    * @return string phone number of the recipient
    */
    public function getRecipient(): string
    {
        return $this->recipient;
    }
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
    * @return int SMS ID
    */
    public function getID():int
    {
        return $this->smsID;
    }

    /** {@inheritDoc} */
    public function jsonSerialize(): array
    {
        $parentArray = parent::jsonSerialize();

        $returnArray = [
            'ID' => $this->smsID,
            'BundleID' => $this->bundleID,
            'Status' => $this->status,
            'StatusDescription' => $this->statusDescription,
            'To' => $this->recipient,
            'ModifiedDate' => $this->updated->format("Y-m-d\TH:i:s.").
                substr($this->updated->format('u'), 0, 3) ?? null,
            'CreatedDate' => $this->created->format("Y-m-d\TH:i:s.").
                substr($this->updated->format('u'), 0, 3) ?? null,
        ];
        return array_filter(array_merge($parentArray, $returnArray));
    }
}
