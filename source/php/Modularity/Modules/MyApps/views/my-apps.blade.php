@if (!$hideTitle && !empty($postTitle))
    @typography([
        'id' => 'mod-posts-' . $ID . '-label',
        'element' => 'h2',
        'variant' => 'h2',
        'classList' => ['module-title']
    ])
        {!! $postTitle !!}
    @endtypography
@endif

@if (!empty($viewModel->items))
    <div class="o-grid o-grid--half-gutter">
        @foreach ($viewModel->items as $item)
            @if ($item->display === 'hide')
                @continue
            @endif
            <div class="o-grid-6 o-grid-6@sm o-grid-4@md u-display--flex">
                @card([
                    'id' => 'mod-my-apps-' . $ID . '-' . $item->id,
                    'link' => $item->link,
                    'classList' => [
                        'card-item-' . $item->id,
                        ...$item->target ? ['c-card--external'] : [],
                        ...$item->display === 'disabled' ? ['is-disabled'] : []
                    ],
                    'attributeList' => [
                        'aria-labelledby' => 'mod-my-apps-' . $ID . '-' . $item->id . '-' . 'title',
                        'target' => $item->target
                    ],
                    'context' => 'mod-my-apps'
                ])
                    <div class="c-card__header u-display--flex">
                        @if (!empty($item->icon))
                            @icon([
                                'icon' => $item->icon,
                                'size' => 'md',
                                'color' => 'primary',
                                'classList' => ['u-margin__right--2']
                            ])
                            @endicon
                        @endif

                        @typography([
                            'element' => $hideTitle ? 'h2' : 'h3',
                            'variant' => 'h3',
                            'id' => 'mod-my-apps-' . $ID . '-' . $item->id . '-' . 'title',
                            'classList' => ['u-margin__top--0']
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
                    <div class="c-card__footer u-border__top--0  u-padding__top--0">
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
            </div>
        @endforeach
    </div>
@endif
