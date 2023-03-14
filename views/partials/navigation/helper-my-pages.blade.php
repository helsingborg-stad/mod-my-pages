<div class="nav-helper nav-helper--my-pages">
    @includeIf('partials.navigation.breadcrumb')

    @if (!empty($myPagesSecondaryMenu) && $myPagesSecondaryMenu->active && !empty($myPagesSecondaryMenu->items))
        <div class="my-pages-nav-menu-wrapper">
            @includeIf('user.partials.menu', ['viewModel' => $myPagesSecondaryMenu])
        </div>
    @endif
</div>