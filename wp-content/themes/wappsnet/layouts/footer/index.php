<?php
namespace Layouts;

use Wappsnet\Core\Layout;
use Wappsnet\Core\Parser;

class Footer extends Layout
{
	protected function setData() {
        $this->data["build_link"] = Parser::getBuildLink();
    }
}