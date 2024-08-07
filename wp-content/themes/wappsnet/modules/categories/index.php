<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;

class Categories extends Module
{
    protected $args = array(
        'taxonomy' => 'category',
    );

    protected function setData(): void
    {
        $arguments = array(
            'taxonomy' => $this->args['taxonomy'],
            'include' => 'all'
        );

        $categories = get_categories($arguments);

        foreach ($categories as $key => $category) {
            $categories[$key] = [
                'data' => $category,
                'fields' => Blog::getItemCharacters("category_{$category->term_id}"),
                'link' => get_category_link($category),
            ];
        }

        $this->data['items'] = $categories;
    }
}