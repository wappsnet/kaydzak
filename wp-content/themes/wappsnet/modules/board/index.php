<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;

class Board extends Module
{
    protected $args = array(
        'slug' => 'advisors',
    );

    protected function setData(): void
    {
        $board = get_term_by('slug', $this->args['slug'], 'board');

        $people = get_posts([
            'post_type' => 'people',
            'board' => $board->slug,
        ]);

        foreach ($people as $key => $item) {
            $data = Blog::getPostData($item->ID, ['department']);
            $people[$key] = array(
                'data' => Blog::getPostData($item->ID, ['department']),
                'terms' => array_map(function($term) {
                    return $term->name;
                }, $data['terms']),
                'user' => get_user_by('login', $item->post_name),
            );
        }

        $this->data['board'] = [
            'data' => $board,
            'people' => $people,
        ];
    }
}