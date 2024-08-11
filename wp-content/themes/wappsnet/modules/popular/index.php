<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Popular extends Module {
    protected $args = [
        'size' => 12
    ];

    protected function setData(): void
    {
        $posts = get_posts([
            "numberposts" => $this->args['size'],
            "orderby" => "wpb_post_views_count",
            "fields" => "ids",
            "post_type" => "post"
        ]);

        foreach ($posts as $key => $postId) {
            $posts[$key] =  Render::get_plugin('Post', [
                "id" => $postId,
            ]);
        }

        $this->data['items'] = $posts;
    }
}