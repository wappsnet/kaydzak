<?php
namespace Plugins;

use Wappsnet\Core\Parser;
use Wappsnet\Core\Plugin;

class SocialIcons extends Plugin
{
	protected function setData() {
        $this->data['items'] = get_field('social_links', 'options');
	}
}