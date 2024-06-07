<?php
namespace Plugins;

use Wappsnet\Core\Plugin;
use \Wappsnet\Core\Blog;

class Product extends Plugin {

    protected function setData() {

        $this->data["product"] = Blog::getPostData($this->args["id"]);
    }
}