<?php
namespace Wappsnet\Core;

$smarty = null;

class Template
{

    public static function smarty_create_temp_dir($smarty) {
        if (is_array($smarty->template_dir)) {
            foreach ($smarty->template_dir as $template_dir) {
                if (@file_exists($template_dir) === false) {
                    @mkdir($template_dir);
                }
            }
        } else {
            if (file_exists($smarty->template_dir) === false) {
                mkdir($smarty->template_dir);
            }
        }
        if (is_array($smarty->compile_dir)) {
            foreach ($smarty->compile_dir as $compile_dir) {
                if (@file_exists($compile_dir) === false) {
                    @mkdir($compile_dir);
                }
            }
        } else {
            if (file_exists($smarty->compile_dir) === false) {
                mkdir($smarty->compile_dir);
            }
        }
        if (is_array($smarty->config_dir)) {
            foreach ($smarty->config_dir as $config_dir) {
                if (@file_exists($config_dir) === false) {
                    @mkdir($config_dir);
                }
            }
        } else {
            if (file_exists($smarty->config_dir) === false) {
                mkdir($smarty->config_dir);
            }
        }
        if (file_exists($smarty->cache_dir) === false) {
            mkdir($smarty->cache_dir);
            chmod($smarty->cache_dir, 0777);
        }
    }

    public static function getInstance() {
        require_once(WAPPSNET_PATH."/smarty/Smarty.class.php");

        global $smarty;

        $smarty = new \Smarty();

        $theme_path = get_template_directory();

        if (defined('WP_USE_THEMES') && WP_USE_THEMES == true) {
            $smarty->template_dir = $theme_path . "/templates";
            $smarty->compile_dir = $theme_path . "/templates_c";
            $smarty->config_dir = $theme_path . "/config";
            $smarty->cache_dir = $theme_path . "/cache";
        } else if (defined('SMARTY_PATH')) {
            $smarty->template_dir = SMARTY_PATH . "/templates";
            $smarty->compile_dir = SMARTY_PATH . "/templates_c";
            $smarty->config_dir = SMARTY_PATH . "/config";
            $smarty->cache_dir = SMARTY_PATH . "/cache";
        }

        self::smarty_create_temp_dir($smarty);

        $smarty->auto_literal = false;
        $smarty->caching = true;
        $smarty->cache_lifetime = 86400;
        $smarty->cache_modified_check = false;
        $smarty->config_booleanize = false;
        $smarty->config_overwrite = false;
        $smarty->config_read_hidden = false;
        $smarty->debugging = false;
        $smarty->force_compile = true;
        $smarty->use_sub_dirs = false;

        return $smarty;
    }
}