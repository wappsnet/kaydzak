<?php
namespace Wappsnet\Core;

class Field {
    public static function generateGroup($args = []) {
        $group = array (
            'key' => 'group_connect_module',
            'title' => 'Подключить Модуль',
            'fields' => array(),
            'location' => array(),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        );

        if(isset($args)) {
            foreach ($args as $key => $value) {
                $group[$key] = $value;
            }
        }

        return $group;
    }

    public static function generateField($args = []) {
        $field = array (
            'key' => 'field_wappsnet_name' ,
            'label' => 'Wappsnet',
            'name' => 'wappsnet',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => array (
                '' => '',
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'placeholder' => '',
            'disabled' => 0,
            'readonly' => 0,
        );

        if(isset($args)) {
            foreach ($args as $key => $value) {
                $field[$key] = $value;
            }
        }

        return $field;
    }

    public static function setConnectedPlugins($post_type = 'post') {
        $pluginsList = Render::get_all_plugins();

        $primaryField = self::generateField([
            "key" => "field_connect_plugin".$post_type,
            "label" => "Плагины",
            "name" => "plugins",
            "type" => "repeater",
            "min" => "",
            "max" => "",
            "layout" => "table",
            "button_label" => "Добавить",
            "sub_fields" => array(
                self::generateField([
                    "key" => "field_plugin_title",
                    "label" => "Загаловок",
                    "name" => "title",
                    "type" => "text",
                ]),

                self::generateField([
                    "key" => "field_plugin_name",
                    "label" => "Плагин",
                    "name" => "plugin",
                    "type" => "select",
                    "choices" => $pluginsList,
                ])
            )
        ]);

        $fieldGroup = self::generateGroup([
            "key" => "group_connect_plugin_".$post_type,
            "title" => "Подключить плагин",
            "fields" => array(
                $primaryField
            ),
            "location" => array(
                array(
                    array(
                        "param" => "post_type",
                        "operator" => "==",
                        "value" => $post_type
                    )
                )
            ),
        ]);

        acf_add_local_field_group($fieldGroup);
    }

    public static function getConnectedPlugins() {
        global $post;

        $pluginsList = get_field('plugins', $post->ID);

        $pluginsHtml = [];

        if(is_array($pluginsList)) {
            foreach ( $pluginsList as $item ) {
                $pluginsHtml[] = Array(
                    'title' => $item['title'],
                    'plugin' => Render::get_plugin($item['plugin'])
                );
            }
        }

        return $pluginsHtml;
    }
}