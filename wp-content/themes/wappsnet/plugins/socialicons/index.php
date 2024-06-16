<?php
namespace Plugins;

use Wappsnet\Core\Plugin;

class SocialIcons extends Plugin
{
	protected function setData() {
        $patterns = new \WP_Query([
            'name' => 'block-pattern-social-icons',
            'post_type' => 'wp_block',
        ]);

        $this->data['icons'] = do_blocks($patterns->post->post_content);
	}
}