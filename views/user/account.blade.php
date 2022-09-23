@php
use ModMyPages\Session\Profile;
@endphp

@includeWhen(!Profile::isAuthenticated(), 'user.partials.login')
@includeWhen(Profile::isAuthenticated(), 'user.partials.menu')