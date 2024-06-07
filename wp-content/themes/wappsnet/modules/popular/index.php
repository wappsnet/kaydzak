<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class Popular extends Module
{
    protected function setData() {
        $artItems = get_posts([
            "numberposts" => 15,
            "fields" => "ids",
            "post_type" => "art"
        ]);

        foreach ($artItems as $key => $postId) {
            $artItems[$key] = Blog::getPostData($postId);
        }

        $shopItems = get_posts([
            "numberposts" => 10,
            "fields" => "ids",
            "post_type" => "shop"
        ]);

        foreach ($shopItems as $key => $postId) {
            $shopItems[$key] = Render::get_plugin('Product', [
              "id" => $postId,
            ]);
        }

        $categories = get_categories([
            'post_type' => 'art'
        ]);

        foreach ($categories as $key => $category) {
            $categories[$key] = [
              'data' => $category,
              'link' => '/art/'.$category->slug,
            ];
        }


        $this->data['categories'] = Render::get_plugin('Categories', ['type' => 'art']);;
        $this->data['art'] = array_chunk($artItems, count($artItems) / 3, true);
        $this->data['shop'] = Render::get_plugin('Carousel', [
            "items" => $shopItems,
        ]);
    }
}