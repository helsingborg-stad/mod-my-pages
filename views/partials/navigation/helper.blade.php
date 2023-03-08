<div class="nav-helper">
    @includeIf('partials.navigation.breadcrumb')

    @if (!empty($myPagesSecondaryMenu) && $myPagesSecondaryMenu->active && !empty($myPagesSecondaryMenu->items))
        <div class="my-pages-nav-menu-wrapper">
            @includeIf('user.partials.menu', ['viewModel' => $myPagesSecondaryMenu])
        </div>
    @else
        @includeIf('partials.navigation.accessibility')
    @endif
</div>
