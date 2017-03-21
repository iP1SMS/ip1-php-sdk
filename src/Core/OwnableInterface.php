<?php
namespace IP1\RESTClient\Core;

interface OwnableInterface
{

    /**
    * Returns ID of account owning the implemented object.
    * @return ID of account owning the implemented object.
    */
    public function getOwnerID(): string;
}
