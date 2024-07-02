<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 17.06.2018
 * Time: 1:43
 */

namespace Wappsnet\Core;


use WP_Error;

class Blog {
    public static function getPostData($postId, $terms = ['category']): array
    {
        $postData = get_post($postId);

        //item media -------------------------------------
        $postMedia = self::getPostMedia($postId);
        //item media -------------------------------------

        //item category--------------------------------------
        $postCategories = self::getPostCategories($postId);
        //item category--------------------------------------

        //item author--------------------------------------
        $postAuthor = self::getPostAuthor($postData->post_author);
        //item author--------------------------------------

        //item characters----------------------------------
        $postCharacters = self::getItemCharacters($postId);
        //item characters----------------------------------

        $post = [
            'data' => $postData,
            'link' => get_permalink($postId),
            'media' => $postMedia,
            'author' => $postAuthor,
            'categories' => $postCategories,
            'characters' => $postCharacters,
        ];

        if (!empty($terms)) {
            $post['terms'] = wp_get_post_terms($postId, $terms);
        }

        return $post;
    }

    public static function getPostAuthor($authorId): \WP_User|bool
    {
        return get_user_by('id', $authorId);
    }

    public static function getPostMedia($itemId): array
    {
        return array(
            'image' => wp_get_attachment_url(get_post_thumbnail_id($itemId)),
            'video' => get_field('video_link', $itemId)
        );
    }

    public static function getPostCategories($postId): WP_Error|array
    {
        $categories = wp_get_post_terms($postId, ['category']);

        foreach ($categories as $key => $category) {
            $categories[$key] = [
                'data' => $category,
                'fields' => self::getItemCharacters("category_{$category->term_id}"),
                'link' => get_category_link($category),
            ];
        }

        return $categories;
    }

    public static function getPostTerms($postId, $taxonomies = ['category']): WP_Error|array
    {
        $terms = wp_get_post_terms($postId, $taxonomies);

        foreach ($terms as $key => $term) {
            $terms[$key] = [
                'data' => $term,
                'link' => get_term_link($term),
            ];
        }

        return $terms;
    }

    public static function getTermPosts($termData): array
    {
        $arguments = array(
            'post_type' => 'post',
            'fields' => 'ids',
            'numberposts' => get_option('posts_per_page'),
            'tax_query' => array(
                array(
                    'taxonomy' => $termData->taxonomy,
                    'field' => 'slug',
                    'terms' => $termData->slug,
                )
            )
        );

        return get_posts($arguments);
    }

    public static function getItemCharacters($itemId): array
    {
        $fields = get_fields($itemId);
        $characters = [];

        if(is_array($fields)) {
            foreach ($fields as $key => $value) {
                $characters[$key] = get_field_object($key, $itemId);
            }
        }

        return $characters;
    }
}