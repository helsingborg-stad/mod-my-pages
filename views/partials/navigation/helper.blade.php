<div class="nav-helper">
    @includeIf('partials.navigation.breadcrumb')

    @if (!empty($myPagesSecondaryMenu) && $myPagesSecondaryMenu->active && !empty($myPagesSecondaryMenu->items))
        @includeIf('user.partials.menu', ['viewModel' => $myPagesSecondaryMenu])
    @else
        @includeIf('partials.navigation.accessibility')
    @endif
</div>
