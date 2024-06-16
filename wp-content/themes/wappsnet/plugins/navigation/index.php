<?php

namespace Plugins;

use Wappsnet\Core\Plugin;

class Navigation extends Plugin
{
	protected function setData($name = 'secondary') {
		$this->data['menu'] =  wp_get_nav_menu_items($name);
	}
}