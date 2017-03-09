<?php
/**
* Contains the LoggedOutGoingSMS class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
use IP1\RESTClient\Core\UpdatableComponent;

namespace IP1\RESTClient\SMS;

/**
* The response you will get when sending an OutGoingSMS. One instance per recipient.
* @link http://api.ip1sms.com/Help/Api/PUT-api-contacts-contact
* @package \IP1\RESTClient\SMS;
*/
class LoggedOutGoingSMS extends ProcessedOutGoingSMS implements UpdatableComponent
{
    private $updated;
    private $created;
    const IS_READ_ONLY = true;


    public function getReadOnly(): bool
    {
        return IS_READ_ONLY;
    }
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }
    /**
    * @param  DateTimeZone $timezone (optional) The timezone that the user wants to get the DateTime in. Default is UTC
    * @return DateTime  When the Component was added
    */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }
    /** {@inheritDoc} */
    public function jsonSerialize(): \stdClass
    {
        $returnObject = parent::jsonSerialize();
        $returnObject->UpdatedDate = $this->updated;
        $returnObject->CreatedDate = $this->created;
        return $returnObject;
    }
}
