<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Popular extends Module {
    protected $args = [
        'count' => 9
    ];

    protected function setData() {
        $posts = get_posts([
            "numberposts" => $this->args['count'],
            "fields" => "ids",
            "post_type" => "post"
        ]);

        foreach ($posts as $key => $postId) {
            $posts[$key] =  Render::get_plugin('Post', [
                "id" => $postId,
            ]);
        }

        print_r($posts);

        $this->data['items'] = $posts;
    }
}