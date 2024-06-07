<?php
namespace Modules;

use Wappsnet\Core\Module;

class Search extends Module
{
	protected function setData() {
        $this->data['primaryTitle'] = get_field('primary_title', 'options');
        $this->data['primaryImage'] = get_field('primary_image', 'options');
        $this->data['secondaryTitle'] = get_field('secondary_title', 'options');
    }
}