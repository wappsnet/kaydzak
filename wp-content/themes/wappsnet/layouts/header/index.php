<?php
namespace Layouts;

use Wappsnet\Core\Layout;
use Wappsnet\Core\Parser;
use Wappsnet\Core\Visitor;

class Header extends Layout
{
	protected function setData() {
        //check to redirect user
        Visitor::checkAllowUser();

		$this->data["seo_data"] = Parser::getSeoData();
		$this->data["build_link"] = Parser::getBuildLink();
		$this->data["body_class"] = Parser::getBodyData('class');
	}
}