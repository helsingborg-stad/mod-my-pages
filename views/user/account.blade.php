@php
use ModMyPages\Session\Profile;
@endphp

@includeWhen(!empty($myPagesMenu['login']), 'user.partials.login')
@includeWhen(!empty($myPagesMenu['dropdown']), 'user.partials.menu')