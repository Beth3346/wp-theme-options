<?php
namespace WpThemeOptions;

class ThemeOptions
{
    public function initializeThemeSettings(array $options)
    {
        $menu = new Menu;
        $settings = new Options;

        $menu->addThemeMenu($options);
        $settings->addSubpageOptions($options['subpages']);
    }
}
