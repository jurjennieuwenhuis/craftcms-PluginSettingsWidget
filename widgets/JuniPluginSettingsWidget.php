<?php
namespace Craft;

/**
 * Class JuniPluginSettingsWidget
 *
 * @package Craft
 */
class JuniPluginSettingsWidget extends BaseWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return Craft::t('Plugin Settings');
    }

    /**
     * {@inheritdoc}
     */
    public function getBodyHtml()
    {
        $settings = $this->getSettings();

        $plugins = $this->getAllowedPlugins($settings);

        return craft()->templates->render('junipluginsettings/widget', array(
            'plugins' => $plugins,
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function defineSettings()
    {
        return array(
            'allowed_plugins' => array(AttributeType::Mixed),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsHtml()
    {
        return craft()->templates->render('junipluginsettings/settings', array(
            'settings' => $this->getSettings(),
            'pluginOptions' => $this->getPlugins(),
        ));
    }

    /**
     * Retrieve list of all enabled plugins with a settings panel. Indexed by name and with url as value.
     *
     * @return array
     */
    private function getPlugins()
    {
        $plugins = craft()->plugins->getPlugins();

        $ret = array();

        foreach ($plugins as $plugin)
        {
            if ((null != $plugin->getSettingsUrl() || null != $plugin->getSettingsHtml()))
            {
                if (null !== $plugin->getSettingsUrl())
                {
                    $url = $plugin->getSettingsUrl();
                }
                else
                {
                    // no settings url provided, but since there is settings html we'll
                    // create one: /settings/plugins/{handle}
                    $url = UrlHelper::getCpUrl('/settings/plugins/' . $plugin->getClassHandle());
                }

                $ret[$plugin->getName()] = $url;
            }
        }

        return $ret;
    }

    /**
     * Retrieve list with allowable widgets, index by name and with url as value.
     *
     * @param Model $settings
     * @return array
     */
    private function getAllowedPlugins(Model $settings)
    {
        $plugins = $this->getPlugins();

        if (null != $settings['allowed_plugins'])
        {
            foreach ($plugins as $name => $url)
            {
                if (!in_array($name, $settings['allowed_plugins']))
                {
                    unset($plugins[$name]);
                }
            }
        }

        return $plugins;
    }
}
