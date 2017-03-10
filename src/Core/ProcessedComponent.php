<?php
/**
* Contains the ProcessedComponent class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @package IP1\RESTClient\Core
*/
namespace IP1\RESTClient\Core;

/**
* All responses from the API implements this class.
* @package \IP1\RESTClient\Core
*/
interface ProcessedComponent extends \JsonSerializable
{

    /**
    * Returns the component ID.
    * @return int Component ID from the API
    */
    public function getID(): int;
    /**
    * @param  \DateTimeZone $timezone The timezone that the user wants to get the DateTime in. Default is UTC.
    * @return ?\DateTime When the Component was added.
    */
    public function getCreated(\DateTimeZone $timezone = null): ?\DateTime;
    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative.
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array;
}
