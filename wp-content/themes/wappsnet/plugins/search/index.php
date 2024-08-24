<?php
namespace Plugins;

use Wappsnet\Core\Plugin;
use \Wappsnet\Core\Blog;

class Search extends Plugin {
    protected function setData(): void
    {
        $args = [
            'fields' => 'ids',
            "post_type" => "post",
            'orderby' => 'post_date',
            'order' => 'DESC',
            's' => $this->args['keyword']
        ];

        $all = get_posts(array_merge($args, [
            'fields' => 'ids',
            'posts_per_page' => -1
        ]));

        $count = count($all);

        $posts = get_posts(array_merge($args, [
            'fields' => 'ids',
            'posts_per_page' => max($count, get_option('posts_per_page'))
        ]));

        foreach ($posts as $key => $postId) {
            $posts[$key] = Blog::getPostData($postId);
        }

        $this->data['posts'] = $posts;
        $this->data['count'] = $count;
        $this->data['keyword'] = $this->args['keyword'];
    }
}