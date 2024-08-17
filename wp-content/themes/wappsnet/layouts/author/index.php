<?php
namespace Layouts;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Layout;
use Wappsnet\Core\Render;
use WP_Query;

class Author extends Layout
{
    protected function setData(): void
    {
        $user = get_queried_object();

        $query = new WP_Query([
            'name' => $user->user_login,
            'post_type' => 'people'
        ]);

        $posts = $query->get_posts();

        $people = $posts[0];

        $data = Blog::getPostData($people->ID, ['department']);
        $author = array(
            'data' => $user,
            'post' => $data,
            'terms' => array_map(function($term) {
                return $term->name;
            }, $data['terms']),
        );

        $args = [
            'fields' => 'ids',
            "post_type" => "post",
            "author" => $user->ID,
            'orderby' => 'post_date',
            'order' => 'DESC',
        ];

        $all = get_posts(array_merge($args, [
            'fields' => 'ids',
            'posts_per_page' => -1
        ]));

        $posts = get_posts(array_merge($args, [
            'paged' => get_query_var( 'page', 1 ),
            'fields' => 'ids',
            'posts_per_page' => get_option('posts_per_page')
        ]));

        $count = count($all);

        foreach ($posts as $key => $postId) {
            $posts[$key] =  Render::get_plugin('Post', [
                "id" => $postId,
            ]);
        }

        $pagination = Render::get_plugin('Pagination', [
            'count' => $count
        ]);

        $this->data['posts'] = $posts;
        $this->data['pagination'] = $pagination;
        $this->data['author'] = $author;
    }
}