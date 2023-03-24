<?php

namespace ModMyPages\Admin;

use Exception;
use ModMyPages\Plugin\FilterHookSubscriber;

class AcfSelectIcons implements FilterHookSubscriber
{
    public function __construct()
    {
    }

    /**
     *
     * TODO: Lift out as a service and inject as a dependency
     * @return array<string, string>
     */
    public function getIcons()
    {
        $list = [];
        try {
            $requestUrl =
                'https://raw.githubusercontent.com/helsingborg-stad/styleguide/master/assets/data/icons.json';
            $request = curl_init($requestUrl);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Content-Type: application/json',
            ]);

            $request = curl_exec($request);
            $response = json_decode($request, true);

            foreach ($response['icons'] as $icon) {
                /** @var string $icon['name']  */
                $list[$icon['name']] = $icon['name'];
            }
        } catch (Exception $e) {
            if (defined('WP_DEBUG')) {
                error_log(print_r($e->getMessage(), true));
            }
        }

        return $list;
    }

    public static function addFilters()
    {
        return [['acf/load_field/key=field_6400c3d95249e', 'iconFieldChoices']];
    }

    public function iconFieldChoices($field)
    {
        $field['choices'] = $this->getIcons();

        return $field;
    }
}
