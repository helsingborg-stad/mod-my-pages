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
            <form name="submit-my-contact-details" enctype="multipart/form-data">
                <div class="o-grid o-grid--form">

                    <div class="o-grid-12">
                        @field([
                            'id' => 'name',
                            'type' => 'text',
                            'label' => 'Namn',
                            'placeholder' => 'name',
                            'value' => $session['name'],
                            'attributeList' => [
                                'type' => 'text',
                                'name' => 'Name',
                                'readonly' => 1
                            ]
                        ])
                        @endfield
                    </div>

                    <div class="o-grid-12">
                        @field([
                            'id' => 'ssn',
                            'type' => 'text',
                            'label' => 'Personnummer',
                            'placeholder' => 'ssn',
                            'value' => $session['ssn'],
                            'icon' => 'user',
                            'attributeList' => [
                                'type' => 'text',
                                'name' => 'ssn',
                                'readonly' => 1
                            ]
                        ])
                        @endfield
                    </div>

                    <div class="o-grid-12">
                        @typography([
                            'element' => 'h3'
                        ])
                            Kontaktuppgifter
                        @endtypography
                    </div>
                    <div class="o-grid-12">
                        @field([
                            'id' => 'email',
                            'type' => 'email',
                            'label' => 'E-post',
                            'placeholder' => 'exempel@placeholder.com',
                            'value' => '',
                            'attributeList' => [
                                'type' => 'email',
                                'name' => 'email'
                            ]
                        ])
                        @endfield
                    </div>

                    <div class="o-grid-12">
                        @field([
                            'id' => 'ssn',
                            'type' => 'tel',
                            'label' => 'Telefon',
                            'placeholder' => '0700011000',
                            'value' => '123',
                            'classList' => ['is-invalid'],
                            'helperText' => 'Felaktigt telefonnummer',
                            'attributeList' => [
                                'type' => 'tel',
                                'name' => 'phone',
                                'data-invalid-message' => 'You need to add a valid E-mail!'
                            ]
                        ])
                        @endfield
                    </div>


                    <div class="o-grid-12 u-margin__top--2">
                        @button([
                            'text' => __('Spara uppgifter', 'event-integration'),
                            'color' => 'primary',
                            'style' => 'filled',
                            'type' => 'submit',
                            'classList' => [],
                        ])
                        @endbutton
                    </div>


                    <div class="o-grid-12 u-margin__top--2">
                        @notice([
                            'type' => 'success',
                            'message' => [
                                'text' => 'Uppgifterna är uppdaterade.',
                                'size' => 'sm'
                            ],
                            'icon' => [
                                'name' => 'done',
                                'size' => 'md',
                                'color' => 'black'
                            ]
                        ])
                        @endnotice
                    </div>

            </form>
        </div>
    @endcard
</div>
