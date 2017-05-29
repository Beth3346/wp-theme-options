<?php
namespace WpThemeOptions;

class Menu
{
    public function addThemeMenu(array $options)
    {
        $page = new Subpages;

        $this->createThemePage($options);
        $this->createMenuPage($options);
        $page->addSubPages($options['subpages']);
    }

    private function createThemePage(array $options)
    {
        add_theme_page(
            $options['title'],
            $options['title'],
            'administrator',
            'theme_options',
            function () use ($options) {
                $page = new Subpages;
                $page->themeDisplay($options);
            }
        );
    }

    private function createMenuPage(array $options)
    {
        add_menu_page(
            $options['title'],
            $options['title'],
            'administrator',
            'theme_menu',
            function () use ($options) {
                $page = new Subpages;
                $page->themeDisplay($options);
            }
        );
    }
}
