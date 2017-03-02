<?php

namespace IP1\RESTClient\Core;

interface UpdatableComponent extends ProcessedComponent
{
    public function getUpdated(\DateTimeZone $timezone = null): ?\DateTime;
    public function getReadOnly(): bool;
}
