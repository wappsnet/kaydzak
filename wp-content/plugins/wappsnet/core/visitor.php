<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 8/27/16
 * Time: 9:02 PM
 */

namespace Wappsnet\Core;

class Visitor
{
    /**
     * create subscriber
     * @param $request
     * @return array
     */
    public static function subscribe($request): array
    {
        $result = wp_insert_user([
            'user_login' => $request['email'],
            'user_pass' => $request['email'],
            'user_email' => $request['email'],
            'role' => 'subscriber'
        ]);

        if (is_wp_error($result)) {
            return [
                'content' => 'error'
            ];
        }

        return [
            'content' => 'success'
        ];
    }

    public static function search($request): array
    {
        return [
            'content' => Render::get_plugin('Search', [
                'keyword' => $request['keyword']
            ])
        ];
    }
}