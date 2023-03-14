@extends('templates.single')

@section('before-layout')
    @include('user.partials.protected-page-prompt')
@stop

@section('helper-navigation')
    @includeIf('partials.navigation.helper-my-pages')
@stop