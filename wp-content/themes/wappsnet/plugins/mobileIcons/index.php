<?php
namespace Plugins;

use Wappsnet\Core\Plugin;

class MobileIcons extends Plugin
{
	protected function setData() {
        $this->data['items'] = get_field('mobile_apps', 'options');
	}
}