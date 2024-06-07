<?php

namespace Plugins;

use Wappsnet\Core\Parser;
use Wappsnet\Core\Plugin;
use Wappsnet\Core\Mailer;
use Wappsnet\Core\Visitor;

class Categories extends Plugin
{
    protected function setData() {
        $categories = get_categories([
            'post_type' => $this->args["type"]
        ]);

        foreach ($categories as $key => $category) {
            $categories[$key] = [
                'data' => $category,
                'link' => '/'.$this->args["type"].'/?category='.$category->slug,
            ];
        }

        $this->data['categories'] = $categories;
        $this->data['active'] = $_GET['category'];
    }
}