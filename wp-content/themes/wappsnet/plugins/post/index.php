<?php
namespace Plugins;

use Wappsnet\Core\Plugin;
use \Wappsnet\Core\Blog;

class Post extends Plugin {

    protected function setData() {
        $this->data["post"] = Blog::getPostData($this->args["id"]);
    }
}