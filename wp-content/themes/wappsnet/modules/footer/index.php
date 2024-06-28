<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Parser;

class Footer extends Module
{
	protected function setData(): void
    {
        $this->data["scripts"] = Parser::getScripts();
    }
}