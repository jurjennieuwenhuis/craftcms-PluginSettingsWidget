<?php
namespace Craft;

/**
 * Class JuniPluginSettingsPlugin
 *
 * Plugin containing a dashboard widget showing links to the settings panel of selected plugins.
 *
 * @package Craft
 */
class JuniPluginSettingsPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('Juni Plugin Settings Widget');
    }

    public function getVersion()
    {
        return '1.0';
    }

    public function getDeveloper()
    {
        return 'Jurjen Nieuwenhuis';
    }

    public function getDeveloperUrl()
    {
        return 'http://www.kasanova.nl';
    }
}
