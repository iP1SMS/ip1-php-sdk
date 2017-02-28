<?php
namespace \IP1\RESTClient\SMS;

class LoggedOutGoingSMS extends ProcessedOutGoingSMS implements UpdatableComponent
{
    private $updated;
    private $created;
    const IS_READ_ONLY = true;


    public function getReadOnly()
    {
        return IS_READ_ONLY;
    }
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }
    public function getCreated(): DateTime
    {
        return $this->created;
    }
    public function toStdClass(): stdClass
    {
        $returnObject = parent::toStdClass();
        $returnObject->UpdatedDate = $this->updated;
        $returnObject->CreatedDate = $this->created;
        return $returnObject;
    }
}
