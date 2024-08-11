<?php
namespace Layouts;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Layout;
use Wappsnet\Core\Render;

class Single extends Layout
{
    protected function setData(): void
    {
        global $post;

        $this->data['post'] = Blog::getPostData($post->ID);
    }
}