<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.1.0-beta
* @since File available since Release 0.1.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\SMS;

use IP1\RESTClient\Core\UpdatableComponent;

/**
* The response you will get when sending an OutGoingSMS. One instance per recipient.
*/
class LoggedOutGoingSMS extends ProcessedOutGoingSMS implements UpdatableComponent
{
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
    * Returns when the object was updated last. Default timezone is UTC.
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
    * Returns when the object was last updated by the API as a DateTime object. Default timexone is UTC.
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
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative .
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {
        $returnObject = parent::jsonSerialize();
        $returnObject['UpdatedDate'] = $this->updated;
        $returnObject['CreatedDate'] = $this->created;
        return $returnObject;
    }
}
