<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 iP.1 Networks AB
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.1.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/

namespace IP1\RESTClient\SMS;

use IP1\RESTClient\Core\UpdatableComponentInterface;

/**
* The response from the API when you post an SMS to the API
*/
class ProcessedOutGoingSMS extends SMS implements UpdatableComponentInterface
{
    /**
    * The ID of the SMS provided by the API.
    * @var integer $smsID
    */
    private $smsID;
    /**
    * An ID that groups SMSes together if they where sent by the same request.
    * @var int|null $bundleID
    */
    private $bundleID;
    /**
    * The status code of the SMS.
    * @var integer $status
    */
    private $status;
    /**
    * Describes what $status means.
    * @var string $statusDescription
    */
    private $statusDescription;
    /**
    * The phone number that the SMS was sent to.
    * @var string $recipient
    */
    private $recipient;
    /**
    * Stores when the sms was created in UTC.
    * @var DateTime $created
    */
    private $created;
    /**
    * Stores when the sms was last updated in UTC.
    * @var DateTime $created
    */
    private $updated;
    const IS_READ_ONLY = true;
    /**
    * ProcessedOutGoingSMS Constructor
    * @param string       $sender            Phone number or name of the sender.
    * @param string       $message           Message content.
    * @param string       $recipient         The phone number that the SMS was sent to.
    * @param integer      $smsID             The ID of the SMS provided by the API.
    * @param \DateTime    $created           When the SMS was created.
    * @param \DateTime    $updated           When the SMS was last updated (With a new status).
    * @param integer      $status            What status code the SMS has.
    * @param string       $statusDescription A describing sentence about the status code.
    * @param integer|null $bundleID          An ID that groups SMSes together if they where sent by the same request.
    */
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
    * @return integer Message bundle ID, if any
    */
    public function getBundleID(): ?int
    {
        return $this->bundleID;
    }
    /**
    * @return integer Status Code
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
    /**
    * Returns when the component was updated last.
    * @param  \DateTimeZone $timezone The timezone that the user wants to get the DateTime in.
    *       Default is UTC.
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
    * Returns whether the object is read only or not.
    * @return boolean Whether the object is read only or not
    */
    public function isReadOnly(): bool
    {
        return self::IS_READ_ONLY;
    }
    /**
    * @param \DateTimeZone $timezone The timezone that the user wants to get the DateTime in.
    *           Default is UTC.
    * @return \DateTime|null  When the Contact was added.
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
    * @return integer SMS ID.
    */
    public function getID():int
    {
        return $this->smsID;
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative .
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
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
    /**
    * Takes the given argument and replaces strings such as {id} to an actual value.
    * @param string $endPoint The endpoint to be corrected.
    * @return void
    */
    public function fillEndPoint(string &$endPoint): void
    {
        $endPoint = str_replace("{sms}", $this->smsID, $endPoint);
        $endPoint = str_replace("{bundle}", $this->bundleID ?? "", $endPoint);
    }
}
