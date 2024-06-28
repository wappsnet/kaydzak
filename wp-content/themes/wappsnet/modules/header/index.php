<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Parser;

class Header extends Module
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
    }
}