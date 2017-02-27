<?php

use IP1\RESTClient\Core\Component;

namespace \IP1\RESTClient\SMS;

abstract class SMS implements Component
{
    protected $prio;
    protected $from;
    protected $message;

    public function __construct(string $sender)
    {
        $this->from = $sender;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    public function setPriority(int $priority): void
    {
        $this->prio = $priority;
    }
}
