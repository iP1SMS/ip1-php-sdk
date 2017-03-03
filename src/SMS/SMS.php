<?php
/**
* Contains the SMS class
* PHP version 7.1.1
* @author Hannes Kindströmmer <hannes@kindstrommer.se>
* @copyright 2017 IP1 SMS
*/

namespace IP1\RESTClient\SMS;

/**
* Abstract class that all other SMS classes extends.
* @package \IP1\RESTClient\SMS;
*/
abstract class SMS implements \JsonSerializable
{
    /**
    * Message priority level, normal (1) or high (2).
    * @var int $priority
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
    * SMS Constructor
    * @param string $sender Phone number or name of the sender
    * @param string $message Message content
    */
    public function __construct(string $sender, string $message)
    {
        $this->from = $sender;
        $this->message = $message;
    }
    /**
    * Sets what the content/message of the SMS should be.
    * @param string $message The message the SMS should contain.
    */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    /**
    * Setting priority high (1) will cost 0.10SEK more than setting normal (1) for Swedish customers.
    * For customers outside sweden the priority will be overritten to normal (1) by the API.
    * @param int $priority Message priority level, normal (1) or high (2)
    */
    public function setPriority(int $priority): void
    {
        $this->prio = $priority;
    }
    /**
    * Sets the sender.
    * @param sting $sender Sending name or phone number
    */
    public function setSender(string  $sender): void
    {
        $this->from = $sender;
    }
    /**
    * {@inheritDoc}
    */
    public function jsonSerialize(): \stdClass
    {
        $returnObject = new \stdClass();
        $returnObject->Prio = $this->prio;
        $returnObject->From = $this->from;
        $returnObject->Message = $this->message;
        return $returnObject;
    }
}
