<div class="o-grid o-grid--half-gutter">
    @foreach ($viewModel->items as $item)
        @if ($item->display !== 'hide')
            <div class="o-grid-6 o-grid-6@sm o-grid-4@md u-display--flex">
                @include('partials.post-card')
            </div>
        @endif
    @endforeach
</div>