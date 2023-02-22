<div class="nav-helper js-my-pages-template-string">
    @includeIf('partials.navigation.breadcrumb')

    @if (!empty($myPagesMenu['dropdown']) && !empty($myPagesMenu['position']) && $myPagesMenu['position'] === 'helper')
        @includeIf('user.partials.menu')
    @else
        @includeIf('partials.navigation.accessibility')
    @endif
</div>
