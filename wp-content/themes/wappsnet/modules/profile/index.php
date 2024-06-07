<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Parser;

class Profile extends Module
{
	protected function setData() {
		global $post;

		$this->data["post"] = $post;
	}
}