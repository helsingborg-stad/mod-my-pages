<div class="u-margin__bottom--4">
    @notice([
        'type' => 'info',
        'message' => [
            'text' =>
                'Vi saknar dina kontaktuppgifter. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in magna eros.',
            'size' => 'sm'
        ],
        'icon' => [
            'name' => 'info',
            'size' => 'md',
            'color' => 'black'
        ]
    ])
    @endnotice
</div>
<div style="max-width: var(--container-width-content,calc(var(--base, 8px)*76));">
    @card([
        'classList' => []
    ])
        <div class="c-card__body ">
            <div class="o-grid o-grid--form">
                <div class="o-grid-12">
                    @typography([
                        'element' => 'h4'
                    ])
                        {{ $session['name'] ?? 'Jan Ove Waldner' }}
                    @endtypography
                    @typography([
                        'element' => 'span'
                    ])
                        {{ $session['ssn'] ?? '1912121212-XXXX' }}
                    @endtypography
                    <div data-js-toggle-item="example" data-js-toggle-class="u-display--none">
                        @typography([
                            'element' => 'h4',
                            'classList' => ['u-margin__top--2']
                        ])
                            E-post
                        @endtypography
                        @typography([
                            'element' => 'span'
                        ])
                            exempel@placeholder.com
                        @endtypography
                        @typography([
                            'element' => 'h4',
                            'classList' => ['u-margin__top--2']
                        ])
                            Telefon
                        @endtypography
                        @typography([
                            'element' => 'span'
                        ])
                            {{ '0700011000' }}
                        @endtypography
                        <div class="u-margin__top--2">
                            @button([
                                'text' => __('Ändra uppgifter', 'event-integration'),
                                'color' => 'primary',
                                'style' => 'filled',
                                'type' => 'submit',
                                'classList' => [],
                                'attributeList' => [
                                    'data-js-toggle-trigger' => 'example',
                                ],
                                'classList' => ['u-width--100@xs', 'u-display--block'],
                            ])
                            @endbutton
                        </div>
                    </div>
                </div>
                <form class="u-display--none" name="submit-my-contact-details" enctype="multipart/form-data"
                    data-js-toggle-item="example" data-js-toggle-class="u-display--none">
                    <div class="o-grid o-grid--form">
                        <div class="o-grid-12">
                            @field([
                                'id' => 'email',
                                'type' => 'email',
                                'label' => 'E-post',
                                'placeholder' => 'exempel@epost.se',
                                'value' => '',
                                'attributeList' => [
                                    'type' => 'email',
                                    'name' => 'email'
                                ]
                            ])
                            @endfield
                        </div>
                        <div class="o-grid-12 u-margin__top--1">
                            @field([
                                'id' => 'email-confirmation',
                                'type' => 'email',
                                'label' => 'Upprepa E-post',
                                'placeholder' => 'exempel@epost.se',
                                'value' => '',
                                'attributeList' => [
                                    'type' => 'email',
                                    'name' => 'email'
                                ]
                            ])
                            @endfield
                        </div>

                        <div class="o-grid-12 u-margin__top--2">
                            @field([
                                'id' => 'phone',
                                'type' => 'tel',
                                'label' => 'Telefon',
                                'placeholder' => '0732000000',
                                'value' => '',
                                'attributeList' => [
                                    'type' => 'email',
                                    'name' => 'email'
                                ]
                            ])
                            @endfield
                        </div>

                        <div class="o-grid-12 u-margin__top--1">
                            @field([
                                'id' => 'phone-confirmation',
                                'type' => 'tel',
                                'label' => 'Upprepa telefon',
                                'placeholder' => '0732000000',
                                'value' => '',
                                'attributeList' => [
                                    'type' => 'email',
                                    'name' => 'email'
                                ]
                            ])
                            @endfield
                        </div>

                        <div class="o-grid-12 u-margin__top--2">
                            <div class="o-grid o-grid--form">
                                <div class="o-grid-fit">
                                    @button([
                                        'text' => __('Spara uppgifter', 'event-integration'),
                                        'color' => 'primary',
                                        'style' => 'filled',
                                        'type' => 'button',
                                        'attributeList' => [
                                            'data-js-toggle-trigger' => 'example',
                                        ],
                                    ])
                                    @endbutton
                                </div>
                                <div class="o-grid-auto">
                                    @button([
                                        'text' => __('Avbryt', 'event-integration'),
                                        'color' => 'primary',
                                        'style' => 'basic',
                                        'type' => 'button',
                                        'attributeList' => [
                                            'data-js-toggle-trigger' => 'example',
                                        ],
                                        'classList' => [
                                            'u-margin__right--auto',
                                            'u-padding__left--3',
                                            'u-padding__right--3',
                                            'u-display--block',
                                        ],
                                    ])
                                    @endbutton

                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endcard
    </div>
