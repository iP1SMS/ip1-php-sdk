<?php


namespace \IP1\RESTClient\SMS;

class ProcessedOutGoingSMS extends OutGoingSMS
{
    private $bundleID;
    private $status;
    private $statusDescription;
    private $recipient;

    public function getBundleID(): int
    {
        return $this->bundleID;
    }
    public function getStatus(): int
    {
        return $this->status;
    }
    public function getStatusDescription(): string
    {
        return $this->statusDescription;
    }
    public function getRecipient(): string
    {
        return $this->recipient;
    }
}
