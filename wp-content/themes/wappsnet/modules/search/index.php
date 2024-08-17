<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Parser;

class Search extends Module
{
	protected function setData(): void
    {
        $this->data["icons"] = Parser::getSvgIcons();
        $this->data["title"] = get_bloginfo('name');
    }
}