<?php
namespace Plugins;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Plugin;

class Author extends Plugin
{
    protected function setData(): void
    {
        $user = get_user_by('id', $this->args['authorId']);
        $people = Blog::getPeopleByName($user->user_login);
        $data = Blog::getPostData($people->ID, ['department']);
        $field = get_field('user-social-links', $people->ID);
        $links = array_filter($field['sub_fields'], function ($link) {
            return !empty($link['value']);
        });

        print_r($links);

        $author = array(
            'data' => $user,
            'post' => $data,
            'links' => $links,
            'terms' => array_map(function($term) {
                return $term->name;
            }, $data['terms']),
        );

        $this->data['author'] = $author;
    }
}