<?php
/**
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 iP.1 Networks AB
* @license https://www.gnu.org/licenses/lgpl-3.0.txt LGPL-3.0
* @version 0.2.0-beta
* @since File available since Release 0.2.0-beta
* @link http://api.ip1sms.com/Help
* @link https://github.com/iP1SMS/ip1-php-sdk
*/
namespace IP1\RESTClient\Recipient;

use IP1\RESTClient\Core\ProcessableComponentInterface;

/**
* Creates a new BlacklistEntry with the given information
*/
class BlacklistEntry implements ProcessableComponentInterface
{
    /**
    * Blacklisted phone number
    * @var string $phone
    */
    protected $phone;
    /**
    * BlacklistEntry Constructor.
    * @param string $phoneNumber The phone number the BlacklistEntry should have.
    */
    public function __construct(string $phoneNumber)
    {
        $this->phone = $phoneNumber;
    }
    /**
    * Returns the phone number of the BlacklistEntry
    * @return string Phone Number
    */
    public function getPhoneNumber(): string
    {
        return $this->phone;
    }
    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative.
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {
        $array = [
            'Phone' => $this->phone,
        ];
        return $array;
    }
    /**
      * Returns the object as a JSON string.
      * @return string
      */
    public function __toString(): string
    {
        return json_encode($this->jsonSerialize);
    }
}
