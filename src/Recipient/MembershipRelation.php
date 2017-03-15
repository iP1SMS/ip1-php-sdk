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
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\Communicator;
use IP1\RESTClient\Core\ClassValidationArray;

/**
* Classes that has deals with membership should implement this interface
* @link http://api.ip1sms.com/Help/Api/GET-api-memberships
* @package \IP1\RESTClient\Recipient
*/
interface MembershipRelation
{
    /**
    * Returns an array of all the memberships
    * @param Communicator $communicator Used to fetch memberships from the API.
    * @return ClassValidationArray An array of Group objects
    */
    public function getMemberships(Communicator $communicator = null): ClassValidationArray;
    /**
    * Tells whether memberships has been fetched from the API or not.
    * @return boolean Whether the memberships has been fetched from the API or not
    */
    public function memberShipsFetched(): bool;
}
