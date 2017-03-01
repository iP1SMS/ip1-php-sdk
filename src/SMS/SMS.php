<?php

namespace IP1\RESTClient\SMS;

abstract class SMS implements \JsonSerializable
{
    protected $prio;
    protected $from;
    protected $message;

    public function __construct(string $sender, string $message)
    {
        $this->from = $sender;
        $this->message = $message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    public function setPriority(int $priority): void
    {
        $this->prio = $priority;
    }
    public function setSender(string  $sender): void
    {
        $this->from = $sender;
    }
    public function jsonSerialize(): \stdClass
    {
        $returnObject = new \stdClass();
        $returnObject->Prio = $this->prio;
        $returnObject->From = $this->from;
        $returnObject->Message = $this->message;
        return $returnObject;
    }
}
