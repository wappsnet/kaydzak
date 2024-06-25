<?php
namespace Layouts;

use Wappsnet\Core\Layout;
use Wappsnet\Core\Parser;
use Wappsnet\Core\Visitor;

class Header extends Layout
{
    protected function generateStyles(): string
    {
        $theme = json_decode(file_get_contents(THEME_PATH.'/theme.json'), true);

        $colors = [];

        foreach ($theme['settings']['color']['palette'] as $item) {
            $color = get_theme_mod($item['slug'], $item['color']);
            $colors[] = "--{$item['slug']}: {$color}";
        }

        $styles = join(';', $colors);

        return ":root {{$styles}}";
    }

    protected function setData(): void
    {
        $this->data["seo"] = Parser::getSeoData();
        $this->data["scripts"] = Parser::getScripts();
        $this->data["class"] = Parser::getBodyData('class');
        $this->data["styles"] = $this->generateStyles();

        $this->data["menu"] = wp_get_nav_menu_items("primary");
        $this->data["user"] = Visitor::get_visitor();
        $this->data["logo"] = get_header_image();
        $this->data["title"] = get_bloginfo('name');
    }
}