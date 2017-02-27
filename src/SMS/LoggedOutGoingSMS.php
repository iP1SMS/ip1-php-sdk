<?php
namespace \IP1\RESTClient\SMS;

class LoggedOutGoingSMS extends ProcessedOutGoingSMS implements UpdatableComponent
{
    private $updated;
    const IS_READ_ONLY = true;


    public function getReadOnly()
    {
        return IS_READ_ONLY;
    }
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }
}
