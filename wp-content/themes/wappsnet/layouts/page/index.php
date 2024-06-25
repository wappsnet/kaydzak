<?php
namespace Layouts;

use Wappsnet\Core\Layout;

class Page extends Layout
{
	protected function setData() {
        global $post;

        $this->data['page'] = $post;
    }
}