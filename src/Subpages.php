<?php
namespace WpThemeOptions;

class Subpages
{
    public function addSubPages(array $subpages)
    {
        foreach ($subpages as $subpage) {
            add_submenu_page(
                'elr_theme_menu',
                __($subpage['title'], 'elr'),
                __($subpage['title'], 'elr'),
                'administrator',
                'theme_' . $subpage['id']
            );
        }
    }

    private function getActiveTab(array $subpages)
    {
        return isset($_GET['tab']) ? $_GET['tab'] : $subpages[0]['id'];
    }

    private function isActiveTab($active_tab, array $subpage)
    {
        if ($active_tab == $subpage['id']) {
            return true;
        }

        return false;
    }

    private function createNavTabs(array $subpages)
    {
        $active_tab = $this->getActiveTab($subpages);

        $html = '<h2 class="nav-tab-wrapper">';

        foreach ($subpages as $subpage) {
            $html .= $this->createMenuTab($subpage, $active_tab);
        }

        $html .= '</h2>';

        return $html;
    }

    private function createMenuTab(array $subpage, $active_tab)
    {
        if ($this->isActiveTab($active_tab, $subpage)) {
            $tab_class = 'nav-tab nav-tab-active';
        } else {
            $tab_class = 'nav-tab';
        }

        $html = '<a href="?page=theme_options&tab=' . $subpage['id'] . '" class="' . $tab_class . '">';
        $html .= __($subpage['title'], 'elr');
        $html .= '</a>';

        return $html;
    }

    private function createSettingsForm(array $subpage, $active_tab)
    {
        echo '<form method="post" action="options.php">';
        if ($this->isActiveTab($active_tab, $subpage)) {
            settings_fields($subpage['id']);
            do_settings_sections($subpage['id']);
            submit_button();
        }
        echo '</form>';
    }

    public function themeDisplay(array $options)
    {
        $subpages = $options['subpages'];
        $title = $options['title'];
        $active_tab = $this->getActiveTab($subpages);
        echo '<div class="wrap">';
        echo '<h2>' . __($title, 'elr') . '</h2>';
        settings_errors();

        echo $this->createNavTabs($subpages);

        foreach ($subpages as $subpage) {
            $this->createSettingsForm($subpage, $active_tab);
        }

        echo '</div>';
    }
}
