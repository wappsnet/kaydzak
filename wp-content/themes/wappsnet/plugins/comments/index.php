<?php

namespace Plugins;

use Wappsnet\Core\Parser;
use Wappsnet\Core\Plugin;
use Wappsnet\Core\Mailer;
use Wappsnet\Core\Visitor;

class Comments extends Plugin
{
    protected function setData() {
        $this->data["postId"] = $this->args['postId'];
        $this->data["comments"] = self::getComments($this->args['postId']);
        $this->data["user"] = Visitor::get_visitor(false);
    }

    public static function getComments($postId) {
        $commentsArgs = Array(
            'number' => 50
        );

        if($postId) {
            $commentsArgs['post_id'] = $postId;
            $commentsArgs['number']  = 10;
        }

        $comments = get_comments($commentsArgs);

        return $comments;
    }
}