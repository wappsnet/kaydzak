<?php
namespace Layouts;

use Wappsnet\Core\Layout;
use Wappsnet\Core\Parser;

class Header extends Layout
{
    protected function setData(): void
    {

        $this->data["menu"] = [
            'header' => wp_get_nav_menu_items("header"),
            'secondary' => wp_get_nav_menu_items("secondary"),
            'canvas' => wp_nav_menu([
                "menu" => "canvas",
                "depth" => 2,
                "echo" => false,
                "menu_class" => "wp-canvas-menu"
            ]),
        ];
        $this->data["image"] = Parser::getThemeImage();
        $this->data["logo"] = Parser::getThemeLogo();
        $this->data["title"] = get_bloginfo('name');
    }
}