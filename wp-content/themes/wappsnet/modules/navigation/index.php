<?php

namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Navigation extends Module {
    protected $args = [
        'name' => 'footer'
    ];

	protected function setData(): void
    {
		$this->data['menu'] = Render::get_plugin('Navigation', [
            'name' => $this->args['name']
        ]);
	}
}