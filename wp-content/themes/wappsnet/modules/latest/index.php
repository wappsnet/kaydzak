<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Latest extends Module
{
    protected $args = array(
        'size' => 9
    );

    protected function setData(): void
    {
        $posts = Blog::getLatestPosts(["numberposts" => $this->args["size"]]);

        foreach ($posts as $key => $postId) {
            $posts[$key] =  Render::get_plugin('Post', [
                "id" => $postId,
            ]);
        }

        $fractions = array(
          'main' => array_slice($posts, 0, 1),
          'primary' => array_slice($posts, 2, 2),
          'secondary' => array_slice($posts, 4, 2)
        );

        $this->data['items'] = $fractions;
    }
}