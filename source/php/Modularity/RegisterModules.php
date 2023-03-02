<?php

namespace ModMyPages\Modularity;


use ModMyPages\Modularity\Modules\MyApps\MyApps;
use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\Plugin\FilterHookSubscriber;

class RegisterModules implements ActionHookSubscriber, FilterHookSubscriber
{
    /**
     * @return array<string, class-string>
     * @psalm-suppress MissingDependency
     */
    public static function modules(): array
    {
        // Register modules here
        return [
            'mod-my-apps' => MyApps::class
        ];
    }

    public static function addActions()
    {
        return [
            ['plugins_loaded', 'registerModules', 1]
        ];
    }
    public static function addFilters()
    {
        return [
            ['/Modularity/externalViewPath', 'registerViewPaths', 1, 3]
        ];
    }

    /**
     * @param class-string $class
     * @psalm-suppress MissingDependency
     */
    public function getClassNameWithoutNamespace(string $class): string
    {
        $path = explode('\\', $class);
        return array_pop($path);
    }

    public function registerModules(): void
    {
        foreach (self::modules() as $class) {
            $name = $this->getClassNameWithoutNamespace($class);
            if (function_exists('modularity_register_module')) {
                modularity_register_module(
                    MOD_MY_PAGES_MODULE_PATH . "/" . $name,
                    $name
                );
            }
        }
    }

    /**
     *
     * @param array<string, string> $paths
     * @return array<string, string>
     */
    public function registerViewPaths(array $paths): array
    {
        foreach (self::modules() as $slug => $class) {
            $name = $this->getClassNameWithoutNamespace($class);
            $paths[$slug] = MOD_MY_PAGES_MODULE_PATH . $name . "/" . "views";
        }
        return $paths;
    }
}
