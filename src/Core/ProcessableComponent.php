<?php
/**
* Contains the ProcessedComponent class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @version 0.1.0-beta
* @package IP1\RESTClient\Core
*/

namespace IP1\RESTClient\Core;

/**
* All objects that are possible to send to the Communicator implement this or any child class.
* @package \IP1\RESTClient\Core
*/
interface ProcessableComponent extends \JsonSerializable
{

  /**
   * Serializes the object to a value that can be serialized natively by json_encode().
   * @return array Associative.
   * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
   */
    public function jsonSerialize(): array;
    /**
      * Returns the object as a JSON string.
      * @return string
      */
    public function __toString(): string;
}
