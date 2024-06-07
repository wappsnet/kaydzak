<?php
namespace Plugins;

use Wappsnet\Core\Plugin;

class SocialShare extends Plugin
{
	protected function setData() {
        $this->data['items'] = get_field('social_share', 'options');
        $this->data['link'] = $this->args['link'];
	}
}