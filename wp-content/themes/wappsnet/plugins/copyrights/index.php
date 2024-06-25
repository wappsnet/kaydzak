<?php
namespace Plugins;

use Wappsnet\Core\Plugin;

class CopyRights extends Plugin
{
	protected function setData() {
        $patterns = new \WP_Query([
            'name' => 'block-pattern-copy-rights',
            'post_type' => 'wp_block',
        ]);

        $this->data['content'] = do_blocks($patterns->post->post_content);
	}
}