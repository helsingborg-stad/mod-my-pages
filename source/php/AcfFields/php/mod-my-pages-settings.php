<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_6328267265e02',
    'title' => __('My Pages Settings', 'mod-my-pages'),
    'fields' => array(
        0 => array(
            'key' => 'field_63282ab922787',
            'label' => __('API URL', 'mod-my-pages'),
            'name' => 'mod_my_pages_api_url',
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
            'key' => 'field_6329bafc7006a',
            'label' => __('Session Length', 'mod-my-pages'),
            'name' => 'mod_my_pages_session_length_in_seconds',
            'type' => 'number',
            'instructions' => __('eg. 600 = 10 minutes', 'mod-my-pages'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 600,
            'placeholder' => '',
            'prepend' => '',
            'append' => __('Seconds', 'mod-my-pages'),
            'min' => 1,
            'max' => '',
            'step' => '',
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