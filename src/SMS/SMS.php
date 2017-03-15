<?php
/**
* Contains the SMS class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
* @version 0.1.0-beta
* @package \IP1\RESTClient\SMS
*/

namespace IP1\RESTClient\SMS;

/**
* Abstract class that all other SMS classes extends.
*/
abstract class SMS implements \JsonSerializable
{
    /**
    * Message priority level, normal (1) or high (2).
    * @var integer $priority
    */
    protected $prio = 1;
    /**
    * Sender's name or phone number.
    * @var string $from
    */
    protected $from;
    /**
    * The message the SMS should contain.
    * @var string $message
    */
    protected $message;



    /**
    * SMS Constructor.
    * @param string $sender  Phone number or name of the sender.
    * @param string $message Message content.
    */
    public function __construct(string $sender, string $message)
    {
        $this->setSender($sender);
        $this->message = $message;
    }
    /**
    * Sets what the content/message of the SMS should be.
    * @param string $message The message the SMS should contain.
    * @return void
    */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    /**
    * Setting priority high (1) will cost 0.10SEK more than setting normal (1) for Swedish customers.
    * For customers outside sweden the priority will be overritten to normal (1) by the API.
    * @param integer $priority Message priority level, normal (1) or high (2).
    * @return void
    */
    public function setPriority(int $priority): void
    {
        $this->prio = $priority;
    }
    /**
    * Sets the sender.
    * @param string $sender Sending name or phone number.
    * @return void
    */
    public function setSender(string  $sender): void
    {

        if (preg_match("/^\+?[0-9]+$/m", $sender) && strlen($sender) > 18) {
            trigger_error(
                "Sender number too long, max length is 18 digits",
                E_USER_WARNING
            );
        } elseif (preg_match("/[a-zA-Z]+/m", $sender) && strlen($sender) > 11) {
            trigger_error(
                "Sender string too long, non numeric senders have max length of 11 characters.",
                E_USER_WARNING
            );
        }
        // We do not truncate the sender as the API will do that and the developer might request the sender string back.
        $this->from = $sender;
    }
    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return array Associative .
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize(): array
    {
        $returnArray = [
        'Prio' => $this->prio,
        'From' => $this->from,
        'Message'=> $this->message
        ];
        return $returnArray;
    }
    /**
    * Returns the object as a JSON string.
    * @return string
    */
    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }
}
