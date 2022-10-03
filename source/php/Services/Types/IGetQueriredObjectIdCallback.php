<?php

namespace ModMyPages\Services\Types;

interface IGetQueriredObjectIdCallback
{
    public function __invoke(): int;
}
