<?php
namespace Plugins;

use Wappsnet\Core\Plugin;

class Recaptcha extends Plugin {
	protected function setData() {
        $patterns = new \WP_Query([
            'name' => 'block-pattern-recaptcha',
            'post_type' => 'wp_block',
        ]);

        $this->data['content'] = do_blocks($patterns->post->post_content);
	}
}