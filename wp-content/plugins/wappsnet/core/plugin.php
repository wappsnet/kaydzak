<?php
namespace Wappsnet\Core;

class Plugin {

    protected $data = array();

    protected $args = array();

    public $isMobile = false;

    protected $hasMobile = false;

    protected $pluginName;

    public function __construct() {
        $className = get_called_class();
        $className = explode('\\', $className);
        $module = strtolower(array_pop($className));
        $module = str_replace('-', '_', $module);

        $this->pluginName = $module;
        $this->isMobile = wp_is_mobile();

        if(empty($this->data['lang'])) {
            $this->data['lang'] = Parser::getConfig('lang');
            $this->data['links'] = Parser::getConfig('link');
            $this->data['logo'] = Parser::getThemeLogo();
        }
    }

    protected function setData(){
        $this->data = array();
    }

    public function init($args = false) {
        $this->args = ($args != false) ? $args : $this->args;
        $this->setData();
        $this->render();
    }

    public function init_get($args = false) {
        $this->args = ($args != false) ? $args : $this->args;
        $this->setData();
        return $this->render_get();
    }

    protected function render() {
        $template_link  = $this->plugin_link();
        $template_class = Template::getInstance();

        foreach($this->data as $key => $value){
            $template_class->assign($key, $value);
        }

        $template_class->display($template_link);
    }

    protected function render_get() {
        $template_link  = $this->plugin_link();
        $template_class = Template::getInstance();

        foreach($this->data as $key => $value){
            $template_class->assign($key, $value);
        }

        return $template_class->fetch($template_link);
    }

    protected function plugin_link() {
        $template_dir  = get_template_directory().DIRECTORY_SEPARATOR;
        $template_path = $template_dir.'plugins'.DIRECTORY_SEPARATOR;
        $template_dist = $template_path.$this->pluginName.DIRECTORY_SEPARATOR;
        $template_link = $template_dist.'index.tpl';

        if($this->isMobile) {
            if ($this->hasMobile) {
                $template_link = $template_dist . 'mobile.tpl';
            }
        }

        return $template_link;
    }
}