<?php
namespace Layouts;

use Wappsnet\Core\Layout;

class Header extends Layout
{
    protected function setData(): void
    {
        $this->data["menu"] = wp_get_nav_menu_items("primary");
        $this->data["logo"] = get_header_image();
        $this->data["title"] = get_bloginfo('name');
    }
}