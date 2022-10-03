<?php

namespace ModMyPages\Services;

use ModMyPages\Services\Types\IGetQueriredObjectIdCallback;

class GetQueriedObjectId implements IGetQueriredObjectIdCallback
{
    public function __invoke(): int
    {
        return get_queried_object_id();
    }
}
