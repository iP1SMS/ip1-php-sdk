<?php

namespace \IP1\RESTClient\Core;

interface ProcesseComponent extends \JsonSerializable
{
    public function getID(): int;
    public function getCreated(): \DateTime;
}
