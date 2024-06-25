<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Latest extends Module
{
    protected $args = array(
        'size' => 9
    );

    protected function setData() {
        $posts = get_posts([
            "numberposts" => $this->args["size"],
            "fields" => "ids",
            "post_type" => "post",
            'orderby' => 'post_date',
            'order' => 'DESC',
        ]);

        foreach ($posts as $key => $postId) {
            $posts[$key] =  Render::get_plugin('Post', [
                "id" => $postId,
            ]);
        }

        $this->data['items'] = $posts;
    }
}