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
    public function jsonSerialize(): \stdClass
    {
        $returnObject = parent::toStdClass();
        if (!empty($this->bundleID)) {
            $returnObject->BundleID = $this->bundleID;
        }
        if (!empty($this->status)) {
            $returnObject->Status = $this->status;
        }
        if (!empty($this->statusDescription)) {
            $returnObject->StatusDescription = $this->statusDescription;
        }
        if (!empty($this->recipient)) {
            $returnObject->Recipient = $this->recipient;
        }
        return $returnObject;
    }
}
