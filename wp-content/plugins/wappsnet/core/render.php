<?php
namespace Wappsnet\Core;

use DirectoryIterator;

class Render {
    public static $existingPlugins = [];
    public static $existingModules = [];

    public static function get_all_plugins() {
        if(count(self::$existingPlugins) > 0) {
            return self::$existingPlugins;
        }

        $directory = new DirectoryIterator(get_template_directory().'/plugins');

        foreach ($directory as $fileInfo) {
            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                self::$existingPlugins[$fileInfo->getFilename()] = $fileInfo->getFilename();
            }
        }

        return self::$existingPlugins;
    }

    public static function get_all_modules() {
        if(count(self::$existingModules) > 0) {
            return self::$existingModules;
        }

        $directory = new DirectoryIterator(get_template_directory().'/modules');

        foreach ($directory as $fileInfo) {
            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                self::$existingModules[$fileInfo->getFilename()] = $fileInfo->getFilename();
            }
        }

        return self::$existingModules;
    }

    public static function load_widget($widgetName,  $args = false) {
		$widget = '\Widgets\\'.$widgetName;
		$widget = new $widget();
		$widget->init($args);
	}

	public static function get_widget($widgetName,  $args = false){
		$widget = '\Widgets\\'.$widgetName;
		$widget = new $widget;
		return $widget->init_get($args);
	}

	public static function load_module($moduleName,  $args = false) {
		$module = '\Modules\\'.$moduleName;
		$module = new $module();

		$module->init($args);
	}

	public static function get_module($moduleName,  $args = false){
		$module = '\Modules\\'.$moduleName;
		$module = new $module;

		return $module->init_get($args);
	}

	public static function load_layout($layoutName,  $args = false) {
        $layout = '\Layouts\\'.$layoutName;
        $layout = new $layout();

        $layout->init($args);
	}

	public static function load_plugin($pluginName,  $args = false) {
		$plugin = '\Plugins\\'.$pluginName;
		$plugin = new $plugin();

		$plugin->init($args);
	}

	public static function get_plugin($pluginName,  $args = false){
		$plugin = '\Plugins\\'.$pluginName;
		$plugin = new $plugin;
		return $plugin->init_get($args);
	}
}