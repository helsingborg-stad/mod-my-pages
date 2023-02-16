@dropdown([
    'id' => 'my-pages-menu',
    'items' => $myPagesMenu['dropdown']['items'],
    'direction' => 'down',
    'popup' => 'click',
    'attributeList' => ['aria-hidden' => 'true'],
    'classList' => ['c-dropdown--my-pages-menu']
])
    @button([
        'text' => $myPagesMenu['dropdown']['text'],
        'icon' => 'person',
        'size' => 'md',
        'style' => 'basic',
        'reversePositions' => true,
        'classList' => ['c-button--my-pages'],
        'attributeList' => ['aria-expanded' => 'false', 'role' => 'button'],
    ])
    @endbutton
@enddropdown
