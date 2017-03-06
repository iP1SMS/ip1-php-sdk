<?php
/**
* Contains the ProcessedComponent interface
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
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
    * @param  DateTimeZone $timezone (optional) The timezone that the user wants to get the DateTime in. Default is UTC
    * @return DateTime When the Component was added
    */
    public function getCreated(\DateTimeZone $timezone = null): ?\DateTime;
}
