<?php
namespace Modules;

use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Featured extends Module {
    protected $args = [
        'size' => 12,
        'slug' => 'featured',
    ];

    protected function setData(): void
    {
        $term = get_term_by('slug', $this->args['slug'], 'board');

        $posts = get_posts([
            "numberposts" => $this->args['size'],
            "orderby" => "wpb_post_views_count",
            "fields" => "ids",
            "post_type" => "post",
            'section' => $term->slug,
        ]);

        foreach ($posts as $key => $postId) {
            $posts[$key] =  Render::get_plugin('Post', [
                "id" => $postId,
            ]);
        }

        $this->data['items'] = $posts;
    }
}