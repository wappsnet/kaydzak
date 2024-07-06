<?php
namespace Layouts;

use Wappsnet\Core\Layout;
use Wappsnet\Core\Render;

class Footer extends Layout
{
    protected function setData(): void
    {
        $this->data['footer'] = Render::get_plugin('Footer');
    }
}