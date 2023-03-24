<?php

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key' => 'group_6328267265e02',
        'title' => __('My Pages Settings', 'mod-my-pages'),
        'fields' => [
            0 => [
                'key' => 'field_63282ab922787',
                'label' => __('Auth API URL', 'mod-my-pages'),
                'name' => 'mod_my_pages_api_url',
                'type' => 'url',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
            ],
            1 => [
                'key' => 'field_63402f643ecf5',
                'label' => __('Auth API Secret', 'mod-my-pages'),
                'name' => 'mod_my_pages_api_auth_secret',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ],
            2 => [
                'key' => 'field_63f62315da0e2',
                'label' => __('Primary Menu for My Pages', 'mod-my-pages'),
                'name' => 'my_pages_primary_menu',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'layout' => 'block',
                'sub_fields' => [
                    0 => [
                        'key' => 'field_63f6245d9a96b',
                        'label' => __('Active', 'mod-my-pages'),
                        'name' => 'active',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'message' => '',
                        'default_value' => 0,
                        'ui_on_text' => __('Enabled', 'mod-my-pages'),
                        'ui_off_text' => __('Disabled', 'mod-my-pages'),
                        'ui' => 1,
                    ],
                    1 => [
                        'key' => 'field_63f6248e9a96c',
                        'label' => __('Label', 'mod-my-pages'),
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => [
                            0 => [
                                0 => [
                                    'field' => 'field_63f6245d9a96b',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                        'wrapper' => [
                            'width' => '60',
                            'class' => '',
                            'id' => '',
                        ],
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => __('My Pages', 'mod-my-pages'),
                        'prepend' => '',
                        'append' => '',
                    ],
                    2 => [
                        'key' => 'field_63f626d69ed3b',
                        'label' => __('Hide label', 'mod-my-pages'),
                        'name' => 'hide_label',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => [
                            0 => [
                                0 => [
                                    'field' => 'field_63f6245d9a96b',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                        'wrapper' => [
                            'width' => '40',
                            'class' => '',
                            'id' => '',
                        ],
                        'message' => '',
                        'default_value' => 0,
                        'ui' => 0,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ],
                    3 => [
                        'key' => 'field_63f776842419c',
                        'label' => __('After sign in redirect url', 'mod-my-pages'),
                        'name' => 'after_sign_in_redirect_url',
                        'type' => 'link',
                        'instructions' => __(
                            'Leave empty to redirect to same page',
                            'mod-my-pages'
                        ),
                        'required' => 0,
                        'conditional_logic' => [
                            0 => [
                                0 => [
                                    'field' => 'field_63f6245d9a96b',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'return_format' => 'url',
                    ],
                    4 => [
                        'key' => 'field_63f776ceb6a40',
                        'label' => __('After sign out redirect url', 'mod-my-pages'),
                        'name' => 'after_sign_out_redirect_url',
                        'type' => 'link',
                        'instructions' => __(
                            'Leave empty to redirect to same page',
                            'mod-my-pages'
                        ),
                        'required' => 0,
                        'conditional_logic' => [
                            0 => [
                                0 => [
                                    'field' => 'field_63f6245d9a96b',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'return_format' => 'url',
                    ],
                ],
            ],
            3 => [
                'key' => 'field_63f627ce8b4f9',
                'label' => __('Secondary Menu for My Pages', 'mod-my-pages'),
                'name' => 'my_pages_secondary_menu',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'layout' => 'block',
                'sub_fields' => [
                    0 => [
                        'key' => 'field_63f627ce8b4fa',
                        'label' => __('Active', 'mod-my-pages'),
                        'name' => 'active',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'message' => '',
                        'default_value' => 0,
                        'ui_on_text' => __('Enabled', 'mod-my-pages'),
                        'ui_off_text' => __('Disabled', 'mod-my-pages'),
                        'ui' => 1,
                    ],
                    1 => [
                        'key' => 'field_63f627ce8b4fb',
                        'label' => __('Label', 'mod-my-pages'),
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => [
                            0 => [
                                0 => [
                                    'field' => 'field_63f627ce8b4fa',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                        'wrapper' => [
                            'width' => '60',
                            'class' => '',
                            'id' => '',
                        ],
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => __('{user.name}', 'mod-my-pages'),
                        'prepend' => '',
                        'append' => '',
                    ],
                    2 => [
                        'key' => 'field_63f627ce8b4fc',
                        'label' => __('Hide label', 'mod-my-pages'),
                        'name' => 'hide_label',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => [
                            0 => [
                                0 => [
                                    'field' => 'field_63f627ce8b4fa',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                        'wrapper' => [
                            'width' => '40',
                            'class' => '',
                            'id' => '',
                        ],
                        'message' => '',
                        'default_value' => 0,
                        'ui' => 0,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ],
                    3 => [
                        'key' => 'field_63f7771db6a42',
                        'label' => __('After sign out redirect url', 'mod-my-pages'),
                        'name' => 'after_sign_out_redirect_url',
                        'type' => 'link',
                        'instructions' => __(
                            'Leave empty to redirect to same page',
                            'mod-my-pages'
                        ),
                        'required' => 0,
                        'conditional_logic' => [
                            0 => [
                                0 => [
                                    'field' => 'field_63f627ce8b4fa',
                                    'operator' => '==',
                                    'value' => '1',
                                ],
                            ],
                        ],
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'return_format' => 'url',
                    ],
                ],
            ],
            4 => [
                'key' => 'field_641b1128767d3',
                'label' => __('Login Prompt', 'mod-my-pages'),
                'name' => 'login_prompt',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'layout' => 'block',
                'acfe_seamless_style' => 0,
                'acfe_group_modal' => 0,
                'sub_fields' => [
                    0 => [
                        'key' => 'field_641b1142767d4',
                        'label' => __('Title', 'mod-my-pages'),
                        'name' => 'title',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => __('Logga in för att se innehållet', 'mod-my-pages'),
                        'prepend' => '',
                        'append' => '',
                    ],
                    1 => [
                        'key' => 'field_641b116b767d5',
                        'label' => __('Content', 'mod-my-pages'),
                        'name' => 'content',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'default_value' => '',
                        'delay' => 1,
                        'tabs' => 'all',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                    ],
                    2 => [
                        'key' => 'field_641b117e767d6',
                        'label' => __('Login button label', 'mod-my-pages'),
                        'name' => 'login_button_label',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => __('Login', 'mod-my-pages'),
                        'prepend' => '',
                        'append' => '',
                    ],
                    3 => [
                        'key' => 'field_641b1194767d7',
                        'label' => __('Home button label', 'mod-my-pages'),
                        'name' => 'home_button_label',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => __('Back to homepage', 'mod-my-pages'),
                        'prepend' => '',
                        'append' => '',
                    ],
                ],
            ],
        ],
        'location' => [
            0 => [
                0 => [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'my-pages-settings',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfe_display_title' => '',
        'acfe_autosync' => '',
        'acfe_form' => 0,
        'acfe_meta' => '',
        'acfe_note' => '',
    ]);
}
