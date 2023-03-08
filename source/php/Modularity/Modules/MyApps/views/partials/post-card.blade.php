@card([
    'id' => 'mod-my-apps-' . $ID . '-' . $item->id,
    'link' => $item->link,
    'classList' => [
        'card-item-' . $item->id,
        'c-card--mod-my-apps',
        ...$item->target ? ['c-card--external'] : [],
        ...$item->display === 'disabled' ? ['is-disabled'] : []
    ],
    'attributeList' => [
        'aria-labelledby' => 'mod-my-apps-' . $ID . '-' . $item->id . '-' . 'title',
        'target' => $item->target
    ],
    'context' => 'mod-my-apps'
])
    <div class="c-card__header u-display--flex u-padding__bottom--1@xs">
        @if (!empty($item->icon))
            @icon([
                'icon' => $item->icon,
                'size' => 'md',
                'color' => 'primary',
                'classList' => [
                    'u-margin__right--05@xs',
                    'u-margin__right--2@sm',
                    'u-margin__right--2@md',
                    'u-margin__right--2@lg',
                    'u-margin__right--2@xl'
                ]
            ])
            @endicon
        @endif

        @typography([
            'element' => $hideTitle ? 'h2' : 'h3',
            'variant' => 'h3',
            'id' => 'mod-my-apps-' . $ID . '-' . $item->id . '-' . 'title',
            'classList' => ['u-margin__top--0', 'c-card__title']
        ])
            {{ $item->title }}
        @endtypography
    </div>

    <div class="c-card__body u-padding__top--0">
        @typography([
            'element' => 'p',
            'id' => 'mod-mod-my-apps-' . $item->id,
            'classList' => ['u-margin__top--0']
        ])
            {!! $item->content !!}
        @endtypography

    </div>
    <div class="c-card__footer u-border__top--0 u-padding__top--0 u-display--none@xs">
        @button([
            'style' => 'filled',
            'icon' => 'arrow_forward',
            'size' => 'sm',
            'color' => 'secondary',
            'classList' => ['u-margin__left--auto', 'u-display--block'],
        ])
        @endbutton
    </div>
@endcard
