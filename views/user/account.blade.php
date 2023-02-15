@includeWhen(
    !empty($myPagesMenu['dropdown']) && !empty($myPagesMenu['position']) && $myPagesMenu['position'] === 'header',
    'user.partials.menu')
