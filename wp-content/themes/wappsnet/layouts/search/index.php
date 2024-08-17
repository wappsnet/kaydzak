<?php
namespace Layouts;

use Wappsnet\Core\Layout;
use Wappsnet\Core\Parser;
use WP_Query;

class Search extends Layout
{
    protected function setData(): void
    {
        $patterns = new WP_Query([
            'name' => 'block-pattern-wp-search',
            'post_type' => 'wp_block',
        ]);

        $this->data["icons"] = Parser::getSvgIcons();
        $this->data["content"] = do_blocks(apply_filters('the_content', $patterns->post->post_content));
    }
}