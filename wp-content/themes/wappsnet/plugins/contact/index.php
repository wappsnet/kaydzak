<?php

namespace Plugins;

use Wappsnet\Core\Parser;
use Wappsnet\Core\Plugin;
use Wappsnet\Core\Mailer;
use Wappsnet\Core\Visitor;

class Contact extends Plugin
{
    protected function setData() {
        $this->data["user"] = Visitor::get_visitor(false);
    }
}