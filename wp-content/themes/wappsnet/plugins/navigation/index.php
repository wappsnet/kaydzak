<?php

namespace Plugins;

use Wappsnet\Core\Plugin;

class Navigation extends Plugin
{
	protected function setData() {
	    if(empty($this->args["name"])) {
            $this->args["name"] = "secondary";
        }

		$this->data['menu'] = wp_nav_menu([
            'echo' => false,
            'menu' => $this->args["name"],
            'container' => 'div',
            'container_class' => 'menu-section',
        ]);
	}
}