@if (!empty($protectedPagePrompt['isProtectedPage']))
    <footer class="hide-authenticated">
        <div class="o-container">
            <div class="section-helper-navigation o-grid u-print-display--none">
                <div class="o-grid-12">
                    @includeIf('partials.navigation.helper-my-pages', ['myPagesSecondaryMenu' => null])
                </div>
            </div>
        </div>

        <div id="protected-page-prompt" class="protected-page-prompt hide-authenticating">
            <div class="o-container u-margin__bottom--12">
                <div class="protected-page-prompt__prompt">
                    <header class="c-article">
                        @typography([
                            'element' => 'h1',
                            'classList' => ['protected-page-prompt__title']
                        ])
                            Logga in för att se innehållet
                        @endtypography

                        <div class="protected-page-prompt__actions">
                            <div class="o-grid o-grid--no-gutter u-margin__top--4">
                                <div class="o-grid-12@xs u-margin__bottom--2">
                                    @button([
                                        'id' => 'protected-page-prompt-login-button',
                                        'text' => $protectedPagePrompt['loginButton']['text'],
                                        'href' => $protectedPagePrompt['loginButton']['url'],
                                        'size' => 'md',
                                        'style' => 'filled',
                                        'color' => 'primary',
                                        'classList' => ['u-width--100'],
                                    ])
                                    @endbutton

                                </div>
                                <div class="o-grid-12@xs">
                                    @button([
                                        'text' => $protectedPagePrompt['homeButton']['text'],
                                        'href' => $protectedPagePrompt['homeButton']['url'],
                                        'size' => 'md',
                                        'style' => 'outlined',
                                        'color' => 'primary',
                                        'classList' => ['u-width--100'],
                                    ])
                                    @endbutton
                                </div>
                            </div>
                        </div>


                    </header>
                </div>

            </div>
        </div>
    </footer>
@endif
