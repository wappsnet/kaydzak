<?php

namespace Plugins;

use Wappsnet\Core\Plugin;

class Navigation extends Plugin {
    protected $args = [
        'name' => 'footer'
    ];

	protected function setData(): void
    {
		$this->data['menu'] = wp_get_nav_menu_items($this->args['name']);
	}
}