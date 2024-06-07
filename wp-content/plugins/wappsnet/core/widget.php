<?php
namespace Wappsnet\Core;

class Widget {

    protected $data = array();

    protected $args = array();

    protected $WidgetName;

    public function __construct(){
        $className = get_called_class();
        $className = explode('\\', $className);

        $widget = strtolower(array_pop($className));
        $widget = str_replace('-', '_', $widget);

        $this->WidgetName = $widget;
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
        $template_link  = $this->widget_link();
        $template_class = Template::getInstance();

        foreach($this->data as $key => $value){
            $template_class->assign($key, $value);
        }

        $template_class->display($template_link);
    }

    protected function render_get() {
        $template_link  = $this->widget_link();
        $template_class = Template::getInstance();

        foreach($this->data as $key => $value){
            $template_class->assign($key, $value);
        }

        return $template_class->fetch($template_link);
    }

    protected function widget_link() {
        $template_path = WP_WAPPSNET.'widgets'.DIRECTORY_SEPARATOR;
        $template_dist = $template_path.$this->WidgetName.DIRECTORY_SEPARATOR;
        $template_link = $template_dist.'index.tpl';

        return $template_link;
    }
}