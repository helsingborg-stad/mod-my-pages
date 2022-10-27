@php
    use ModMyPages\Session\Profile;
@endphp

@includeWhen(!empty($myPagesMenu['dropdown']), 'user.partials.menu')
