<?php
namespace Layouts;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Layout;
use Wappsnet\Core\Render;
use WP_Query;

class Single extends Layout
{
    protected function setData(): void
    {
        global $post;

        $details = Blog::getPostData($post->ID);
        $pattern = new WP_Query([
            'name' => 'block-pattern-wp-post-meta',
            'post_type' => 'wp_block',
        ]);

        $meta = do_blocks(apply_filters('the_content', $pattern->post->post_content));
        $meta = str_replace('{author}', '<a href="'.$details['author']['url'].'">'.$details['author']['data']->display_name.'</a>', $meta);
        $meta = str_replace('{date}', get_the_date( 'F j, Y', $post ), $meta);
        $meta = str_replace('{time}', Blog::getReadingTime(wp_strip_all_tags($details['data']->post_content), 100), $meta);

        $this->data['post'] = $details;
        $this->data['meta'] = $meta;

        $author = new WP_Query([
            'name' => 'block-pattern-wp-author',
            'post_type' => 'wp_block',
        ]);
        $author = do_blocks(apply_filters('the_content', $author->post->post_content));

        $plugin = Render::get_plugin('Author', [
            'authorId' => $post->post_author
        ]);

        $this->data['author'] = str_replace('{author}', $plugin, $author);
        $this->data['styles'] = Blog::getLayoutStyles();
    }
}