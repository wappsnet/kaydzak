<?php
namespace Wappsnet\Core;

class Parser {
    public static $config = [];
    public static $notes = [];
    public static $links = [];

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function getConfig($name) {
        if(empty(self::$config[$name])) {
            switch ($name) {
                case "lang":
                    self::$config[$name] = self::getLangNotes();
                    break;
                case "link":
                    self::$config[$name] = self::getLinkNotes();
                    break;
                default:
                    self::$config[$name] = json_decode(file_get_contents(WAPPSNET_PATH.'/config/'.$name.'/index.json'), true);
                    break;
            }
        }

        return self::$config[$name];
    }

    public static function getLangNotes() {
        if (count(self::$notes) == 0) {
            $notes = get_field( 'language_notes', 'options' );

            if(is_array($notes)) {
                foreach ( $notes as $item ) {
                    self::$notes[ $item['key_name'] ] = $item['value'];
                }
            }
        }

        return self::$notes;
    }

    public static function getLinkNotes() {
        if (count(self::$links) == 0) {
            $notes = get_field( 'link_notes', 'options' );

            if(is_array($notes)) {
                foreach ( $notes as $item ) {
                    self::$links[ $item['link_key'] ] = $item['link_value'];
                }
            }
        }

        return self::$links;
    }

    /**
     * @return mixed
     */
    public static function getThemeLogo() {
        if(empty(self::$config['logo'])) {
            $customLogoId = get_theme_mod( 'custom_logo' );
            self::$config['logo'] = wp_get_attachment_image_src( $customLogoId, 'full' );
        }

        return self::$config['logo'];
    }

    /**
     * @return mixed
     */
    public static function getThemeIcon() {
        if(empty(self::$config['logo'])) {
            $customLogoId = get_theme_mod( 'custom_logo' );
            self::$config['logo'] = wp_get_attachment_image_src( $customLogoId, 'full' )[0];
        }

        return self::$config['logo'];
    }

    /**
     * @param bool $type
     *
     * @return array|mixed
     */
    public static function getSeoData($type = false) {
        global $post;

        $return = Array(
            'title' => get_bloginfo('name'),
            'text'  => get_bloginfo('description'),
            'desc'  => get_bloginfo('description'),
            'link'  => get_home_url(),
            'image' => null,
            'chars' => get_bloginfo('charset'),
        );

        if($post) {
            if($post->post_title) {
                $return['title'] = $post->post_title;
            }

            if($post->post_content) {
                $return['text'] = $post->post_content;
                $return['desc'] = $post->post_content;
            }

            $return['link']  = get_permalink($post->ID);
            $return['image'] = get_the_post_thumbnail_url($post->ID, 'medium');
        }

        $return['title'] = htmlspecialchars(wp_strip_all_tags($return['title']));
        $return['desc']  = htmlspecialchars(wp_strip_all_tags($return['text']));
        $return['text']  = htmlspecialchars(wp_strip_all_tags($return['text']));
        $return['desc']  = substr($return['desc'], 0, 250);
        $return['link']  = urldecode_deep($return['link']);

        if($type === false) {
            return $return;
        } else {
            return $return[$type];
        }
    }

    /**
     * @param bool $type
     * @param string $path
     *
     * @return array|mixed
     */
    public static function getScripts($type = false, $path = null) {
        $theme_url = get_bloginfo('template_directory');

        $scripts = Array(
            'css' => $theme_url.'/assets/build/app.min.css',
            'js'  => $theme_url.'/assets/build/app.min.js',
        );

        if($type === false) {
            return $scripts;
        } else {
            return $scripts[$type];
        }
    }

    public static function getBuildLink($path = '/') {
        $theme_url = get_bloginfo('template_directory');
        $asset_url = $theme_url.'/assets/build/'.$path;
        return $asset_url;
    }

    public static function getBodyData($type = 'class') {
        switch ($type) {
            case "class":
                return implode(" ", get_body_class());
                break;
        }

        return null;
    }

    public static function getCategoryList($options = array()) {
        $categoryArgs = Array(
            'type' => 'post',
            'child_of' => 0,
            'parent' => '',
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 1,
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'number' => 0,
            'taxonomy' => 'category',
            'pad_counts' => false,
        );

        foreach ($options as $key => $value) {
            $categoryArgs[$key] = $value;
        }

        return get_categories($categoryArgs);
    }

    public static function listCategoriesHtml($options = array(), $categoriesHtml = '') {
        $categoriesList = self::getCategoryList($options);

        $categoriesHtml .= '<ul class="categories-list">';

        foreach ($categoriesList as $category) {
            $categoryClass = "category-item";

            if(isset($options["currentId"])) {
                if ( $options["currentId"] == $category->cat_ID ) {
                    $categoryClass .= " active";
                }
            }

            $categoriesHtml .= '<li class="'.$categoryClass.'">';
            $categoriesHtml .= '<a href="'.get_category_link($category->cat_ID).'">';
            $categoriesHtml .= '<span class="cat-name">';
            $categoriesHtml .= $category->name;
            $categoriesHtml .= '</span>';
            $categoriesHtml .= '<span class="cat-count">';
            $categoriesHtml .= '('.$category->count.')';
            $categoriesHtml .= '</span>';
            $categoriesHtml .= '</a>';

            $options['parent'] = $category->cat_ID;

            $childList = self::getCategoryList($options);

            if(count($childList) > 0) {
                $categoriesHtml .= self::listCategoriesHtml($options);
            }

            $categoriesHtml .= '</li>';
        }

        $categoriesHtml .= '</ul>';

        return $categoriesHtml;
    }

    public static function getCurrentCategory($category = false) {
        if(!$category) {
            $category = get_query_var('cat');
        }

        return get_category($category);
    }

    public static function getChildPosts($postId, $postType) {
        $children =  get_posts([
            'post_type' => $postType,
            'post_parent' => $postId,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'posts_per_page' => -1
        ]);

        foreach ($children as $child) {
            $child->post_link = get_permalink($child->ID);
        }

        return $children;
    }
}