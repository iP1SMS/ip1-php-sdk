<?php
/**
* Contains the MembershipRelation interface
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/
namespace IP1\RESTClient\Recipient;

/**
* Classes that has deals with membership should implement this interface
* @link http://api.ip1sms.com/Help/Api/GET-api-memberships
* @package \IP1\RESTClient\Recipient
*/
interface MembershipRelation
{
  /**
  * Returns an array of all the memberships
  * @return array An array of Group objects
  */
    public function getMemberShips(): array;
  /**
  * Tells whether memberships has been fetched from the API or not.
  * @return bool Whether the memberships has been fetched from the API or not
  */
    public function memberShipsFetched(): bool;
}
