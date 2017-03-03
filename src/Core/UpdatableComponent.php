<?php

namespace IP1\RESTClient\Core;

interface UpdatableComponent extends ProcessedComponent
{
    /**
    * @param  DateTimeZone $timezone (optional) The timezone that the user wants to get the DateTime in. Default is UTC
    * @return DateTime When the contact was updated/modified last
    */
    public function getUpdated(\DateTimeZone $timezone = null): ?\DateTime;
    /**
    * @return bool Whether the object is read only or not
    */
    public function isReadOnly(): bool;
}
