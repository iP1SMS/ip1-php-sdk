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
namespace IP1\RESTClient\Core;

/**
* All responses from the API implements this class.
* @package \IP1\RESTClient\Core
*/
interface ProcessedComponentInterface extends ProcessableComponentInterface
{

    /**
    * Returns the component ID.
    * @return integer Component ID from the API
    */
    public function getID(): int;
    /**
    * @param  \DateTimeZone $timezone The timezone that the user wants to get the DateTime in. Default is UTC.
    * @return ?\DateTime When the Component was added.
    */
    public function getCreated(\DateTimeZone $timezone = null): ?\DateTime;
    /**
    * Takes the given argument and replaces strings such as {id} to an actual value.
    * @param string $endPoint The endpoint to be corrected.
    * @return void
    */
    public function fillEndPoint(string &$endPoint): void;
}
