<?php

namespace Xitara\Accordion;

use Backend;
use Event;
use Xitara\Accordion\Classes\AccordionSearchProvider;
use System\Classes\PluginBase;

/**
 * Accordion Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'xitara.accordion::lang.plugin.name',
            'description' => 'xitara.accordion::lang.plugin.description',
            'author' => 'xitara.accordion::lang.plugin.author',
            'homepage' => 'xitara.accordion::lang.plugin.homepage',
            'icon' => '',
            'iconSvg' => '/plugins/xitara/accordion/assets/images/icon.svg',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        Event::listen('offline.sitesearch.extend', function () {
            return new AccordionSearchProvider();
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            '\Xitara\Accordion\Components\ListOutput' => 'accordion',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'xitara.accordion.edit' => [
                'tab' => 'Accordion',
                'label' => 'Edit accordion',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'accordion' => [
                'label' => 'xitara.accordion::lang.plugin.name',
                'url' => Backend::url('xitara/accordion/textlists'),
                'icon' => '',
                'iconSvg' => '/plugins/xitara/accordion/assets/images/icon.svg',
                'permissions' => ['xitara.accordion.*'],
                'order' => 500,
            ],
        ];
    }

    public function registerPageSnippets()
    {
        return [
            '\Xitara\Accordion\Components\ListOutput' => 'accordion',
        ];
    }
}
