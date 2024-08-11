<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;

class Explore extends Module
{
    protected $args = array(
        'taxonomy' => 'category',
        'posts_per_page' => 4,
    );

    protected function setData(): void
    {
        $tax_arguments = array(
            'taxonomy' => $this->args['taxonomy'],
            'include' => 'all'
        );

        $posts_arguments = array(
            "post_type" => "post",
            'orderby' => 'post_date',
            'order' => 'DESC',
        );

        $categories = get_categories($tax_arguments);

        foreach ($categories as $key => $category) {
            $latest = get_posts(array_merge($posts_arguments, [
                'category' => $category->slug,
                'posts_per_page' => +$this->args['posts_per_page']
            ]));

            foreach ($latest as $postKey => $post) {
                $latest[$postKey] = [
                    'data' => $post,
                    'link' => get_permalink($post->ID)
                ];
            }

            $categories[$key] = [
                'data' => $category,
                'fields' => Blog::getItemCharacters("category_{$category->term_id}"),
                'link' => get_category_link($category),
                'posts' => $latest
            ];
        }

        $this->data['items'] = $categories;
    }
}