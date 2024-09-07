<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 17.06.2018
 * Time: 1:43
 */

namespace Wappsnet\Core;


use WP_Error;
use WP_Query;

class Blog {
    public static function getReadingTime($text, $wpm = 100): float
    {
        $totalWords = str_word_count(strip_tags($text));
        return floor($totalWords / $wpm);
    }
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
            'text' => wp_strip_all_tags($postData->post_content),
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

    public static function getPeopleByName($slug = '') {
        $query = new WP_Query([
            "post_type" => "people",
            "name" => $slug,
        ]);

        return $query->have_posts() ? reset($query->posts) : null;
    }

    public static function getPostAuthor($authorId): array
    {
        $user = get_user_by('id', $authorId);
        $people = self::getPeopleByName($user->user_login);

        return array(
            'data' => get_user_by('id', $authorId),
            'url' => get_permalink($people->ID),
        );
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

    public static function getLayoutStyles(): array
    {
        $cache = wp_cache_get( 'layout-styles');

        if (!$cache) {
            $layouts = [
                "header" => [
                    [
                        "key" => "max-width",
                        "value" => get_theme_mod('header_layout_size'),
                    ]
                ],
                "footer" => [
                    [
                        "key" => "max-width",
                        "value" => get_theme_mod('footer_layout_size'),
                    ]
                ],
                "page" => [
                    [
                        "key" => "max-width",
                        "value" => get_theme_mod('page_layout_size'),
                    ]
                ],
                "post" => [
                    [
                        "key" => "max-width",
                        "value" => get_theme_mod('post_layout_size'),
                    ]
                ]
            ];

            $styles = [
                "header" => array_reduce($layouts["header"], function ($carry, $item) {
                    return $carry . $item['key'] . ': ' . $item['value'] . '; ';
                }, ""),
                "footer" => array_reduce($layouts["footer"], function ($carry, $item) {
                    return $carry . $item['key'] . ': ' . $item['value'] . '; ';
                }, ""),
                "post" => array_reduce($layouts["post"], function ($carry, $item) {
                    return $carry . $item['key'] . ': ' . $item['value'] . '; ';
                }, ""),
                "page" => array_reduce($layouts["page"], function ($carry, $item) {
                    return $carry . $item['key'] . ': ' . $item['value'] . '; ';
                }, "")
            ];

            wp_cache_set('layout-styles', $styles);

            return $styles;
        }

        return $cache;
    }
}