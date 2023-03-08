<?php

namespace ModMyPages\Plugin;

/**
 * @psalm-type FilterHook = list{ string, string }|list{ string, string, ?int, ?int }
 */
interface FilterHookSubscriber
{
    /**
     *
     * @return list{FilterHook}
     */
    public static function addFilters();
}
