<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Visitor;

class Header extends Module
{
	protected $hasMobile = true;

	protected function setData() {
		$this->data["menu"] = wp_get_nav_menu_items("primary");
		$this->data["user"] = Visitor::get_visitor();
	}
}