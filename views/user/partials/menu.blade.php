@dropdown([
    'items' => $myPagesMenu['dropdown']['items'],
    'direction' => 'down',
    'popup' => 'click'
])
    @button([
        'text' => $myPagesMenu['dropdown']['text'],
        'icon' => 'keyboard_arrow_down',
        'size' => 'md',
        'style' => 'basic',
    ])
    @endbutton
@enddropdown

