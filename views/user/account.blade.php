@if (!empty($myPagesPrimaryMenu))
    @includeWhen($myPagesPrimaryMenu->active && !empty($myPagesPrimaryMenu->items), 'user.partials.menu', [
        'viewModel' => $myPagesPrimaryMenu,
    ])
@endif
