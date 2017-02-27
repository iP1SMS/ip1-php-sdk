<?php

namespace \IP1\RESTClient\Core;

interface UpdatableComponent extends ProcessedComponent
{
    public function getUpdated(): DateTime;
    public function getReadOnly(): bool;
}
