<?php

namespace \IP1\RESTClient\Core;

interface Component
{
    public function toJson(int $styleArg = 0): string;
}
