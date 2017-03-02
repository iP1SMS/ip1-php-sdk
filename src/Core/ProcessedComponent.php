<?php

namespace IP1\RESTClient\Core;

interface ProcessedComponent extends \JsonSerializable
{
    public function getID(): int;
    public function getCreated(\DateTimeZone $timezone = null): ?\DateTime;
}
