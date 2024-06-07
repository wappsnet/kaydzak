<?php

namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Footer extends Module
{
	protected function setData() {
        $this->data['socialPart'] = Render::get_plugin('SocialIcons');

        $this->data["navigationPart"] = Render::get_plugin('Navigation');

        $this->data['rightsPart'] = Render::get_plugin('CopyRights');
	}
}