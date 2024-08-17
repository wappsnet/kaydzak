<?php
namespace Layouts;

use Wappsnet\Core\Layout;
use WP_Query;

class Footer extends Layout
{
    protected function setData(): void
    {
        $patterns = new WP_Query([
            'name' => 'block-pattern-wp-footer',
            'post_type' => 'wp_block',
        ]);

        $this->data['content'] = do_blocks(apply_filters('the_content', $patterns->post->post_content));
    }
}