<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 iP.1 Networks AB
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.3.0-beta
* @since File available since Release 0.3.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Core;

interface OwnableInterface
{

    /**
    * Returns ID of account owning the implemented object.
    * @return ID of account owning the implemented object.
    */
    public function getOwnerID(): string;
}
