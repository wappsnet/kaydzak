<?php
namespace Plugins;

use Wappsnet\Core\Plugin;
use WP_Query;

class Author extends Plugin
{
    protected function setData(): void
    {
        $patterns = new WP_Query([
            'name' => 'block-pattern-about-author',
            'post_type' => 'wp_block',
        ]);

        $patterns->post->post_content = apply_filters('the_content', $patterns->post->post_content);

        $this->data['content'] = do_blocks($patterns->post->post_content);
    }
}