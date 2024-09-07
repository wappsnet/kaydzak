<?php
namespace Plugins;

use Wappsnet\Core\Parser;
use Wappsnet\Core\Plugin;

class Response extends Plugin {
    protected function setData(): void
    {
        $this->data['icons'] = Parser::getSvgIcons();
        $this->data['title'] = $this->args['title'];
        $this->data['content'] = $this->args['content'];
    }
}