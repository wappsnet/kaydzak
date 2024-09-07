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

        $author = array(
            'data' => $user,
            'post' => $data,
            'terms' => array_map(function($term) {
                return $term->name;
            }, $data['terms']),
        );

        $this->data['author'] = $author;
    }
}