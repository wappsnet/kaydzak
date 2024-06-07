<?php
namespace Wappsnet\Core;

class Layout {

    protected $data = array(

    );

    protected $args = array(

    );

    protected $layoutName;

    public function __construct() {
        $className = get_called_class();
        $className = explode('\\', $className);
        $layout = strtolower(array_pop($className));
        $layout = str_replace('-', '_', $layout);

        $this->layoutName = $layout;
        $this->data = [];
    }

    protected function setData() {
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
        $template_link  = $this->layout_link();
        $template_class = Template::getInstance();

        foreach($this->data as $key => $value){
            $template_class->assign($key, $value);
        }

        $template_class->display($template_link);
    }

    protected function render_get() {
        $template_link  = $this->layout_link();
        $template_class = Template::getInstance();

        foreach($this->data as $key => $value){
            $template_class->assign($key, $value);
        }

        return $template_class->fetch($template_link);
    }

    protected function layout_link() {
        $template_dir  = get_template_directory().DIRECTORY_SEPARATOR;
        $template_path = $template_dir.'layouts'.DIRECTORY_SEPARATOR;
        $template_dist = $template_path.$this->layoutName.DIRECTORY_SEPARATOR;
        $template_link = $template_dist.'index.tpl';

        return $template_link;
    }
}