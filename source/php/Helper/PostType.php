<?php

namespace ModMyPages\Helper;

class PostType
{
    public $postTypeName;
    public $nameSingular;
    public $namePlural;
    public $postTypeArgs;
    public $postTypeRestArgs;
    public $postTypeLabels;

    public $taxonomies = [];

    protected static $_registredTaxonomies = [];

    /* Class constructor */
    public function __construct(
        string $postTypeName,
        string $nameSingular,
        string $namePlural,
        array $args = [],
        array $labels = [],
        array $restArgs = []
    ) {
        // Set some important variables
        $this->postTypeName = $postTypeName;
        $this->nameSingular = $nameSingular;
        $this->namePlural = $namePlural;
        $this->postTypeArgs = $args;
        $this->postTypeRestArgs = $restArgs;
        $this->postTypeLabels = $labels;

        // Add action to register the post type, if the post type doesnt exist
        if (!post_type_exists($this->postTypeName)) {
            add_action('init', [&$this, 'registerPostType']);
            add_action('rest_api_init', [$this, 'registerAcfMetadataInApi']);
            add_action('rest_prepare_' . $postTypeName, [$this, 'removeResponseKeys'], 10, 3);
        }
    }

    /* Method which registers the post type */
    public function registerPostType(): void
    {
        // We set the default labels based on the post type name and plural. We overwrite them with the given labels.
        $labels = array_merge(
            // Default
            [
                'name' => $this->namePlural,
                'singular_name' => $this->nameSingular,
                'add_new' => sprintf(
                    __('Add new %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->nameSingular)
                ),
                'add_new_item' => sprintf(
                    __('Add new %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->nameSingular)
                ),
                'edit_item' => sprintf(
                    __('Edit %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->nameSingular)
                ),
                'new_item' => sprintf(
                    __('New %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->nameSingular)
                ),
                'view_item' => sprintf(
                    __('View %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->nameSingular)
                ),
                'search_items' => sprintf(
                    __('Search %s', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->namePlural)
                ),
                'not_found' => sprintf(
                    __('No %s found', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->namePlural)
                ),
                'not_found_in_trash' => sprintf(
                    __('No %s found in trash', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->namePlural)
                ),
                'parent_item_colon' => sprintf(
                    __('Parent %s:', MOD_MY_PAGES_TEXT_DOMAIN),
                    strtolower($this->nameSingular)
                ),
                'menu_name' => $this->namePlural,
            ],
            // Given labels
            $this->postTypeLabels
        );

        // Same principle as the labels. We set some default and overwite them with the given arguments.
        $args = array_merge(
            // Default
            [
                'label' => $this->namePlural,
                'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'supports' => ['title', 'editor'],
                'show_in_nav_menus' => true,
                '_builtin' => false,
            ],
            // Given args
            $this->postTypeArgs
        );

        // Register the post type
        register_post_type($this->postTypeName, $args);
    }

    /**
     * @return void
     */
    public function registerAcfMetadataInApi()
    {
        if (empty($this->postTypeArgs['show_in_rest'])) {
            return;
        }

        // Collect ACF field groups
        $groups = acf_get_field_groups(['post_type' => $this->postTypeName]);

        // List of field types to skip
        $skipTypes = ['tab', 'accordion'];

        // Loop over field groups
        foreach ($groups as $key => $group) {
            // Get all fields
            $fields = acf_get_fields($group['key']);
            // Bail if empty
            if (empty($fields)) {
                continue;
            }
            // Loop over meta fields and register to rest response
            foreach ($fields as $key => $field) {
                if (!$field['name'] || in_array($field['type'], $skipTypes)) {
                    continue;
                }
                // Register meta as rest field
                register_rest_field($this->postTypeName, $field['name'], [
                    'get_callback' => [$this, 'getCallback'],
                    'schema' => null,
                ]);
            }
        }
    }

    public function getCallback($object, $fieldName, $request)
    {
        if (function_exists('get_field')) {
            $fieldObj = get_field_object($fieldName);
            $type = $fieldObj['type'] ?? 'text';
            // Return different values based on field type
            switch ($type) {
                case 'true_false':
                    $value = get_field($fieldName, $object['id']);
                    break;

                default:
                    // Return null if value is empty
                    $value = !empty(get_field($fieldName, $object['id']))
                        ? get_field($fieldName, $object['id'])
                        : null;
                    break;
            }

            return $value;
        }

        return get_post_meta($object['id'], $fieldName, true);
    }

    public function removeResponseKeys($response, $post, $request)
    {
        // List of blacklisted keys
        $excludeKeys = $this->postTypeRestArgs['exclude_keys'] ?? [];
        // Remove blacklisted keys from rest response
        $response->data = array_diff_key($response->data, array_flip($excludeKeys));

        return $response;
    }

    /* Method to attach the taxonomy to the post type */
    public function addTaxonomy(
        $taxonomySlug,
        $nameSingular,
        $namePlural,
        $args = [],
        $labels = []
    ): void {
        if (!empty($nameSingular)) {
            // We need to know the post type name, so the new taxonomy can be attached to it.
            $postTypeName = $this->postTypeName;

            // Taxonomy properties
            $taxonomyLabels = $labels;
            $taxonomyArgs = $args;
            $hasBeenRegistred = in_array($taxonomySlug, self::$_registredTaxonomies);

            if (!taxonomy_exists($taxonomySlug) && !$hasBeenRegistred) {
                self::$_registredTaxonomies[] = $taxonomySlug;

                // Default labels, overwrite them with the given labels.
                $labels = array_merge(
                    // Default
                    [
                        'name' => $namePlural,
                        'singular_name' => $nameSingular,
                        'search_items' => sprintf(
                            __('Search %s', MOD_MY_PAGES_TEXT_DOMAIN),
                            strtolower($namePlural)
                        ),
                        'all_items' => sprintf(
                            __('All %s', MOD_MY_PAGES_TEXT_DOMAIN),
                            strtolower($namePlural)
                        ),
                        'parent_item' => sprintf(
                            __('Parent %s:', MOD_MY_PAGES_TEXT_DOMAIN),
                            strtolower($nameSingular)
                        ),
                        'parent_item_colon' =>
                            sprintf(
                                __('Parent %s:', MOD_MY_PAGES_TEXT_DOMAIN),
                                strtolower($nameSingular)
                            ) . ':',
                        'edit_item' => sprintf(
                            __('Edit %s', MOD_MY_PAGES_TEXT_DOMAIN),
                            strtolower($nameSingular)
                        ),
                        'update_item' => sprintf(
                            __('Update %s', MOD_MY_PAGES_TEXT_DOMAIN),
                            strtolower($nameSingular)
                        ),
                        'add_new_item' => sprintf(
                            __('Add new %s', MOD_MY_PAGES_TEXT_DOMAIN),
                            strtolower($nameSingular)
                        ),
                        'new_item_name' => sprintf(
                            __('New %s Name', MOD_MY_PAGES_TEXT_DOMAIN),
                            strtolower($nameSingular)
                        ),
                        'menu_name' => $namePlural,
                    ],
                    // Given labels
                    $taxonomyLabels
                );

                // Default arguments, overwitten with the given arguments
                $args = array_merge(
                    [
                        'label' => $namePlural,
                        'labels' => $labels,
                        'public' => true,
                        'show_ui' => true,
                        'show_in_nav_menus' => true,
                        '_builtin' => false,
                    ],
                    $taxonomyArgs
                );
                // Add the taxonomy to the post type
                add_action('init', function () use ($taxonomySlug, $postTypeName, $args) {
                    register_taxonomy($taxonomySlug, $postTypeName, $args);
                });
            } else {
                add_action('init', function () use ($taxonomySlug, $postTypeName) {
                    register_taxonomy_for_object_type($taxonomySlug, $postTypeName);
                });
            }
        }
    }

    public function enableArchiveModules(): void
    {
        add_filter('Modularity/Options/Archives/Modules::EnabledPostTypes', [
            $this,
            'allowArchiveModulesForPostType',
        ]);
    }

    public function allowArchiveModulesForPostType($postTypes)
    {
        if (is_array($postTypes) && !in_array($this->postTypeName, $postTypes)) {
            $postTypes[] = $this->postTypeName;
        }

        return $postTypes;
    }
}
