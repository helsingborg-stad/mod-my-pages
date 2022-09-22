<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_632c26d221ea2',
    'title' => __('My Pages Protected Page', 'mod-my-pages'),
    'fields' => array(
        0 => array(
            'key' => 'field_632c26daf7a57',
            'label' => __('Protected Page', 'mod-my-pages'),
            'name' => 'mod_my_pages_protected_page',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => __('Enabled', 'mod-my-pages'),
            'ui_off_text' => __('Disabled', 'mod-my-pages'),
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
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