<?php
namespace WpThemeOptions;

class Options
{
    private function deslugify($str)
    {
        return ucwords(str_replace('_', ' ', $str));
    }

    public function addSubpageOptions(array $subpages)
    {
        foreach ($subpages as $subpage) {
            $this->initializeOptions($subpage);
        }
    }

    private function initializeOptions(array $subpage)
    {
        $section = $subpage['id'] . '_section';

        $this->addOptionToDatabase($subpage['id'], $subpage['fields']);
        $this->addSettingsHeading($subpage, $section);
        $this->addFields($subpage['fields'], $subpage['id'], $section);
        $this->registerSettings($subpage['id']);
    }

    private function addOptionToDatabase($subpage_id, array $fields)
    {
        $form = null;

        if (get_option($subpage_id) == false) {
            $form = new Forms;
            // $default = apply_filters([$form, 'defaultOptions'], $form->applyDefaultOptions($fields));
            // var_dump($default);

            add_option($subpage_id);
        }
    }

    private function registerSettings($subpage_id, $sanitize = null)
    {
        register_setting(
            $subpage_id,
            $subpage_id,
            $sanitize
        );
    }

    private function addSettingsHeading(array $subpage, $section)
    {
        add_settings_section(
            $section,
            __($subpage['title'], 'elr'),
            function () use ($subpage) {
                echo '<p>' . __($subpage['description'], 'elr') . '</p>';
            },
            $subpage['id']
        );
    }

    private function getLabel($field)
    {
        return isset($field['label']) ? $field['label'] . ':' : $this->deslugify($field['id']) . ':';
    }

    private function addFields(array $fields, $subpage_id, $section)
    {
        foreach ($fields as $field) {
            $this->addField($field, $subpage_id, $section);
        }
    }

    private function addField($field, $subpage_id, $section)
    {
        $id = $field['id'];
        $label = $this->getLabel($field);

        add_settings_field(
            $id,
            $label,
            function () use ($field, $subpage_id) {
                $form = new Forms;
                $form->fieldCallback($field, $subpage_id);
            },
            $subpage_id,
            $section
        );
    }
}
