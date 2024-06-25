<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 17.06.2018
 * Time: 1:43
 */

namespace Wappsnet\Core;


class Blog {
    protected static $getCategoriesHtml = null;

    public static function getCategoriesHtml() {
        if(self::$getCategoriesHtml == null) {
            $optionsList = [
                'parent' => 0,
                'taxonomy' => 'archive',
                'type' => 'post'
            ];

            $optionsList['currentId'] = get_queried_object_id();

            self::$getCategoriesHtml = Parser::listCategoriesHtml($optionsList);
        }

        return self::$getCategoriesHtml;
    }

    public static function getPostData($postId) {
        $postData = get_post($postId);

        //item media -------------------------------------
        $postMedia = self::getPostMedia($postId);
        //item media -------------------------------------

        //item category--------------------------------------
        $postCategories = self::getPostCategories($postId, $postData->post_type);
        //item category--------------------------------------

        //item author--------------------------------------
        $postAuthor = self::getPostAuthor($postData->post_author);
        //item author--------------------------------------

        //item characters----------------------------------
        $postCharacters = self::getItemCharacters($postId);
        //item characters----------------------------------

        return [
            'data' => $postData,
            'link' => get_permalink($postId),
            'media' => $postMedia,
            'author' => $postAuthor,
            'categories' => $postCategories,
            'characters' => $postCharacters,
        ];
    }

    public static function getPostAuthor($authorId) {
        return get_user_by('id', $authorId);
    }

    public static function getPostMedia($itemId) {
        return array(
            'image' => wp_get_attachment_url(get_post_thumbnail_id($itemId)),
            'video' => get_field('video_link', $itemId)
        );
    }

    public static function getPostCategories($postId) {
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

    public static function getTermPosts($termData) {
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

    public static function getItemCharacters($itemId) {
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