<?php
namespace Layouts;

use Wappsnet\Core\Layout;

class Header extends Layout
{
    protected function setData(): void
    {

        $this->data["menu"] = [
            'header' => wp_get_nav_menu_items("header"),
            'canvas' => wp_nav_menu([
                "menu" => "canvas",
                "depth" => 2,
                "echo" => false,
                "menu_class" => "wp-canvas-menu"
            ]),
        ];
        $this->data["logo"] = get_header_image();
        $this->data["title"] = get_bloginfo('name');
    }
}