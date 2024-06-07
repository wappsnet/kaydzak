<?php
namespace Modules;

use Plugins\Pagination;
use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class ArtWork extends Module
{
    protected function setData() {
        global $post;

        $similarItems = get_posts([
            "numberposts" => 10,
            "fields" => "ids",
            "post__not_in" => [$post->ID],
            "post_type" => "art"
        ]);

        foreach ($similarItems as $key => $postId) {
            $similarItems[$key] = Render::get_plugin('ArtWork', [
                "id" => $postId,
            ]);
        }

        $this->data['similar'] = Render::get_plugin('Carousel', [
            "items" => $similarItems,
        ]);

        $this->data['art'] = Blog::getPostData($post->ID);
        $this->data['comments'] = Render::get_plugin('Comments', [
            'postId' => $post->ID
        ]);;
    }
}