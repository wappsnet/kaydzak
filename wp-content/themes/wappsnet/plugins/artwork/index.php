<?php
namespace Plugins;

use Wappsnet\Core\Plugin;
use \Wappsnet\Core\Blog;

class ArtWork extends Plugin {
    protected function setData() {
        $this->data["art"] = Blog::getPostData($this->args["id"]);
    }
}