@dropdown([
    'id' => $viewModel->id,
    'items' => $viewModel->items,
    'direction' => 'down',
    'popup' => 'click',
    'attributeList' => ['aria-hidden' => 'true'],
    'classList' => [
        'c-dropdown--right',
        'c-dropdown--my-pages-menu',
        ...$viewModel->onlyShowForAuthenciated ? ['show-authenticated'] : []
    ]
])
    @if ($viewModel->hideIcon)
        @button([
            'text' => $viewModel->label,
            'icon' => 'expand_more',
            'size' => 'md',
            'style' => 'basic',
            'classList' => ['js-my-pages-template-string', 'js-dropdown-button'],
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
            'classList' => [
                'c-button--my-pages',
                'js-my-pages-template-string',
                'js-dropdown-button',
            ],
            'attributeList' => ['aria-expanded' => 'false', 'role' => 'button'],
        ])
        @endbutton
    @endif
@enddropdown
