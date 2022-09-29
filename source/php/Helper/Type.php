<?php

namespace ModMyPages\Helper;

class Type
{
    public static function cast(array $array, string $className)
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            \strlen($className),
            $className,
            strstr(strstr(serialize((object) $array), '"'), ':')
        ));
    }
}
