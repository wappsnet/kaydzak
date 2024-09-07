<?php
namespace Layouts;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Layout;

class Page extends Layout
{
	protected function setData(): void
    {
        global $post;
        $post->post_content = apply_filters('the_content', $post->post_content);

        $this->data['page'] = $post;
        $this->data['styles'] = Blog::getLayoutStyles();
    }
}