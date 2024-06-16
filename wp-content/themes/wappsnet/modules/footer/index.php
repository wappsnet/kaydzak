<?php

namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Footer extends Module
{
	protected function setData() {
        $this->data['social'] = Render::get_plugin('SocialIcons');

        $this->data["navigation"] = Render::get_plugin('Navigation', 'secondary');

        $this->data['rights'] = Render::get_plugin('CopyRights');
	}
}