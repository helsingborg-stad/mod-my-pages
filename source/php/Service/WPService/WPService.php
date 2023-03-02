<?php

namespace ModMyPages\Service\WPService;

interface WPService extends
    WpGetNavMenuItems,
    GetNavMenuLocations,
    RegisterNavMenu,
    GetPostType,
    HomeUrl,
    IsArchive,
    IsSingle,
    RegisterRestRoute,
    WPNavService
{
}
