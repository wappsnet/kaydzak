<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Parser;
use Wappsnet\Core\Visitor;

class Header extends Module
{
	protected $hasMobile = true;

	protected function setData() {
        $logo = Parser::getThemeLogo();
		$this->data["menu"] = wp_get_nav_menu_items("primary");
		$this->data["user"] = Visitor::get_visitor();
		$this->data["logo"] = $logo[0];
		$this->data["title"] = get_bloginfo('name');
	}
}