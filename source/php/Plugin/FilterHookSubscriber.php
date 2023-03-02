<?php

namespace ModMyPages\Plugin;

interface FilterHookSubscriber
{
    /**
     *
     * @return list{list{ string, string }|list{ string, string, ?int, ?int }}
     */
    public static function addFilters();
}
