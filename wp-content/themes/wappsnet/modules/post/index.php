<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Post extends Module
{
    protected function setData(): void
    {
        global $post;

        $this->data['post'] = $post;
        $this->data['image'] = get_the_post_thumbnail_url($post->ID);
        $this->data['share'] = Render::get_plugin('SocialShare', [
            'link' => get_permalink($post->ID)
        ]);
    }
}