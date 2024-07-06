<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;

class Contributors extends Module
{
    protected function setData(): void
    {
        $people = get_posts([
            'post_type' => 'people',
        ]);

        foreach ($people as $key => $item) {
            $people[$key] = array(
                'data' => Blog::getPostData($item->ID, ['department']),
                'user' => get_user_by('login', $item->post_name),
            );
        }

        $this->data['items'] = $people;
    }
}