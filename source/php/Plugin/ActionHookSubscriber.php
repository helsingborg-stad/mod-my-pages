<?php

namespace ModMyPages\Plugin;

interface ActionHookSubscriber
{
    /**
     *
     * @return list{list{ string, string }|list{ string, string, ?int, ?int }}
     */
    public static function addActions();
}
