<?php

namespace ModMyPages\Services\Mock;

use ModMyPages\Services\Types\IGetQueriredObjectIdCallback;

class MockGetQueriedObjectId implements IGetQueriredObjectIdCallback
{
    public int $id;

    public function __construct(int $id = 1)
    {
        $this->id = $id;
    }

    public function __invoke(): int
    {
        return $this->id;
    }
}
