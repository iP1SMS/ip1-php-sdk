<?php

namespace \IP1\RESTClient\Core;

interface ProcesseComponent extends Component
{
    public function getID(): int;
    public function getCreated(): DateTime;
}
