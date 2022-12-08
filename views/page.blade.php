@extends('templates.single')

@section('before-layout')

    @if (!empty($protectedPagePrompt['isProtectedPage']))
        <footer class="hide-authenticated">
            <div class="o-container show-authenticating">
                <div class="section-helper-navigation o-grid u-print-display--none">
                    <div class="o-grid-12">
                        @includeIf('partials.navigation.helper')
                    </div>
                </div>
            </div>

            <div class="protected-page-prompt hide-authenticating">
                <div class="o-container u-margin__bottom--12 u-margin__top--3">
                    <header class="c-article">
                        @typography([
                            'element' => 'h1'
                        ])
                            Logga in för att se innehållet
                        @endtypography

                        @button([
                            'text' => $protectedPagePrompt['loginButton']['text'],
                            'href' => $protectedPagePrompt['loginButton']['url'],
                            'size' => 'md',
                            'style' => 'filled',
                            'color' => 'primary',
                        ])
                        @endbutton

                        @button([
                            'text' => $protectedPagePrompt['homeButton']['text'],
                            'href' => $protectedPagePrompt['homeButton']['url'],
                            'size' => 'md',
                            'style' => 'filled',
                        ])
                        @endbutton
                    </header>
                </div>
            </div>
        </footer>
    @endif
@stop
