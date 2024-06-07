<?php
namespace Plugins;

use Wappsnet\Core\Plugin;

class CopyRights extends Plugin
{
	protected function setData() {
        $this->data['copyRights'] = get_field('copy_rights', 'options');
	}
}