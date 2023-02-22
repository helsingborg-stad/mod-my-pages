@extends('templates.archive')


@section('content')

    @if ($archiveTitle || $archiveLead)
        <article id="article" class="c-article c-article--readable-width s-article u-clearfix js-my-pages-template-string">
            @if ($archiveTitle)
                @typography([
                    'variant' => 'h1',
                    'element' => 'h1',
                    'classList' => ['t-archive-title', 't-' . $postType . '-archive-title']
                ])
                    {{ $archiveTitle }}
                @endtypography
            @endif
            @if ($archiveLead)
                @typography([
                    'variant' => 'p',
                    'element' => 'p',
                    'classList' => ['lead', 't-archive-lead', 't-' . $postType . '-archive-lead']
                ])
                    {{ $archiveLead }}
                @endtypography
            @endif
        </article>
    @endif

    @includeIf('partials.sidebar', ['id' => 'content-area-top', 'classes' => ['o-grid']])

    @includeFirst([
        'partials.archive.archive-' . sanitize_title($postType) . '-filters',
        'partials.archive.archive-filters',
    ])

    <div
        class="archive s-archive s-archive-template-my-pages s-{{ sanitize_title($postType) }}-archive js-my-pages-template-string">

        {!! $hook->loopStart !!}

        @includeIf('partials.sidebar', ['id' => 'content-area', 'classes' => ['o-grid']])

        {!! $hook->loopEnd !!}

    </div>
@stop

@section('before-layout')
    @include('user.partials.protected-page-prompt')
@stop
