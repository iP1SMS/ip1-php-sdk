<?php
/**
* Contains the UpdatableComponent interface
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Core;

/**
* If an entity can be changed by the user or the API after it has been added to the API
*   that class implements this interface.
* @package \IP1\RESTClient\Core
*/
interface UpdatableComponent extends ProcessedComponent
{
    /**
    * @param  DateTimeZone $timezone (optional) The timezone that the user wants to get the DateTime in. Default is UTC
    * @return DateTime When the contact was updated/modified last
    */
    public function getUpdated(\DateTimeZone $timezone = null): ?\DateTime;
    /**
    * @return bool Whether the object is read only or not
    */
    public function isReadOnly(): bool;
}
