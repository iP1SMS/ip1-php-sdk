<?php
/**
* Contains the ProcessedOutGoingSMS class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/

namespace IP1\RESTClient\SMS;

/**
* The response from the API when you post an SMS to the API
* @link http://api.ip1sms.com/Help/Api/PUT-api-contacts-contact
* @package \IP1\RESTClient\SMS
*/
class ProcessedOutGoingSMS extends OutGoingSMS
{
    private $bundleID;
    private $status;
    private $statusDescription;
    private $recipient;
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
    /** {@inheritDoc} */
    public function jsonSerialize(): \stdClass
    {
        $returnObject = parent::jsonSerialize();
        if (!empty($this->bundleID)) {
            $returnObject->BundleID = $this->bundleID;
        }
        if (!empty($this->status)) {
            $returnObject->Status = $this->status;
        }
        if (!empty($this->statusDescription)) {
            $returnObject->StatusDescription = $this->statusDescription;
        }
        if (!empty($this->recipient)) {
            $returnObject->Recipient = $this->recipient;
        }
        return $returnObject;
    }
}
