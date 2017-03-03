<?php

namespace IP1\RESTClient\Core;

interface ProcessedComponent extends \JsonSerializable
{

    /**
    * @return int Component ID from the API
    */
    public function getID(): int;
    /**
    * @param  DateTimeZone $timezone (optional) The timezone that the user wants to get the DateTime in. Default is UTC
    * @return DateTime  When the Component was added
    */
    public function getCreated(\DateTimeZone $timezone = null): ?\DateTime;
}
