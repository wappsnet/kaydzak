<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;

class Areas extends Module
{
    protected $args = array(
        'taxonomy' => 'category',
    );

    protected function setData(): void
    {
        $arguments = array(
            'taxonomy' => $this->args['taxonomy'],
            'type' => 'post',
            'order' => 'DESC',
            'include' => 'all',
            'pad_counts' => false,
            'hide_empty' => false,
        );

        $categories = array_filter(get_categories($arguments), function ($item) {
            return !empty($item->description);
        });

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