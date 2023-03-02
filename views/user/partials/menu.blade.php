@dropdown([
    'id' => $viewModel->id,
    'items' => $viewModel->items,
    'direction' => 'down',
    'popup' => 'click',
    'attributeList' => ['aria-hidden' => 'true'],
    'classList' => [
        'c-dropdown--my-pages-menu',
        'js-my-pages-template-string',
        ...$viewModel->onlyShowForAuthenciated ? ['show-authenticated'] : []
    ]
])
    @if ($viewModel->hideIcon)
        @button([
            'text' => $viewModel->label,
            'icon' => 'expand_more',
            'size' => 'md',
            'style' => 'basic',
            'classList' => [],
            'attributeList' => ['aria-expanded' => 'false', 'role' => 'button'],
        ])
        @endbutton
    @else
        @button([
            'text' => $viewModel->label,
            'icon' => 'person',
            'size' => 'md',
            'style' => 'basic',
            'reversePositions' => true,
            'classList' => ['c-button--my-pages'],
            'attributeList' => ['aria-expanded' => 'false', 'role' => 'button'],
        ])
        @endbutton
    @endif
@enddropdown
