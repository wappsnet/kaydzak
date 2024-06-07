<?php
namespace Plugins;

use Wappsnet\Core\Parser;
use Wappsnet\Core\Plugin;

class Forgot extends Plugin
{
    protected function setData() {
        $this->data = Array(
            "langData"  => Parser::getLangNotes(),
        );
    }
}