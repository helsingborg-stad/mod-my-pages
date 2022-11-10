@button([
    'href' => '',
    'text' => 'Open Modal',
    'floating' => false,
    'attributeList' => ['data-open' => 'notice-modal'],
    'classList' => ['u-display--none', 'js-press-on-dom-loaded'],
])
@endbutton

@modal([
    'isPanel' => false,
    'id' => 'notice-modal',
    'overlay' => 'dark',
    'size' => 'sm',
    'classList' => []
])
    <div class="u-text-align--center">
        <header class="u-margin__bottom--4">
            <div class="u-margin__bottom--2">
                @icon(['icon' => 'logout', 'size' => 'xl', 'color' => 'primary'])
                @endicon
            </div>
            <div>
                @typography([
                    'element' => 'h2',
                    'variant' => 'h2',
                    'classList' => []
                ])
                    {{ $labels['modalTitle'] ?? 'You have been automatically logged out.' }}
                @endtypography
            </div>
        </header>
        <div class="u-margin__bottom--2">
            @button([
                'href' => '',
                'isOutlined' => false,
                'color' => 'primary',
                'text' => $labels['buttonText'] ?? 'close',
                'attributeList' => ['data-close' => 'notice-modal'],
            ])
            @endbutton
        </div>
    </div>
@endmodal
