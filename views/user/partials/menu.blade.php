@dropdown([
    'items' => $myPagesMenu['dropdown']['items'],
    'direction' => 'down',
    'popup' => 'click'
])
    @button([
        'text' => $myPagesMenu['dropdown']['text'],
        'icon' => 'person',
        'size' => 'md',
        'style' => 'basic',
        'reversePositions' => true,
        'classList' => ['c-button--my-pages'],
    ])
    @endbutton
@enddropdown
