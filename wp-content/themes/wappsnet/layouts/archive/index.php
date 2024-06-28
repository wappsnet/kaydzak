<?php
namespace Layouts;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Layout;
use Wappsnet\Core\Render;

class Archive extends Layout
{
    protected function setData(): void
    {
        $query = get_queried_object();

        $page = get_query_var( 'page' ) ?? 1;

        $args = [
            'category' => $query->slug,
            'fields' => 'ids',
            "post_type" => "post",
            'orderby' => 'post_date',
            'order' => 'DESC',
        ];

        $all = get_posts(array_merge($args, [
            'fields' => 'ids',
            'posts_per_page' => -1
        ]));

        $posts = get_posts(array_merge($args, [
            'paged' => $page,
            'fields' => 'ids',
            'posts_per_page' => get_option('posts_per_page')
        ]));

        $count = count($all);

        foreach ($posts as $key => $postId) {
            $posts[$key] =  Render::get_plugin('Post', [
                "id" => $postId,
            ]);
        }

        $category = [
            'data' => $query,
            'fields' => Blog::getItemCharacters("category_{$query->term_id}"),
            'link' => get_category_link($query),
        ];

        $this->data['category'] = $category;
        $this->data['posts'] = $posts;
        $this->data['pagination'] = Render::get_plugin('Pagination', [
            'count' => $count
        ]);
    }
}