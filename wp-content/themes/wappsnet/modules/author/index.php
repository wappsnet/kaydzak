<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;
use WP_Query;

class Author extends Module
{
    protected function setData(): void
    {
        $user = get_userdata($this->args['id']);


        $query = new WP_Query([
            'name' => $user->user_login,
            'post_type' => 'people'
        ]);

        $posts = $query->get_posts();

        $people = $posts[0];

        $author = array(
            'data' => $user,
            'link' => get_author_posts_url($user->ID),
            'post' => Blog::getPostData($people->ID, ['department'])
        );


        $this->data['author'] = $author;
    }
}