<?php
namespace Modules;

use Wappsnet\Core\Module;

class Page extends Module
{
    protected function setData() {
        global $post;

        $this->data['page'] = $post;
    }
}