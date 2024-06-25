<?php
namespace Plugins;

use Wappsnet\Core\Parser;
use Wappsnet\Core\Plugin;
use \Wappsnet\Core\Blog;
use WP_Query;

class Post extends Plugin {
    protected function setData(): void
    {
        $this->data["post"] = Blog::getPostData($this->args["id"]);
    }
}