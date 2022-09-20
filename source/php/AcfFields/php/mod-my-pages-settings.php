<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_6328267265e02',
    'title' => __('My Pages Settings', 'mod-my-pages'),
    'fields' => array(
        0 => array(
            'key' => 'field_63282ab922787',
            'label' => __('API URL', 'mod-my-pages'),
<<<<<<< HEAD
            'name' => 'api_url',
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
        ),
        1 => array(
            'key' => 'field_63282ad122788',
            'label' => __('Login Redirect URL', 'mod-my-pages'),
            'name' => 'login_redirect_url',
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
        ),
        2 => array(
            'key' => 'field_63282af122789',
            'label' => __('Logout Redirect URL', 'mod-my-pages'),
            'name' => 'logout_redirect_url',
=======
            'name' => 'mod_my_pages_api_url',
>>>>>>> 695677b (export field groups)
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'my-pages-settings',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
));
}