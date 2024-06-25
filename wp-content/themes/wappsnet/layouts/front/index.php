<?php
namespace Layouts;

use Wappsnet\Core\Layout;

class Front extends Layout
{
	protected function setData(): void
    {
        global $post;
        $post->post_content = apply_filters('the_content', $post->post_content);

        $this->data['data'] = $post;
    }
}