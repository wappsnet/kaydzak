<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Parser;

class Header extends Module
{
    protected function setData(): void
    {
        $this->data["seo"] = Parser::getSeoData();
        $this->data["scripts"] = Parser::getScripts();
        $this->data["class"] = Parser::getBodyData('class');
    }
}