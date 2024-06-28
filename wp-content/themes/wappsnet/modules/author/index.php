<?php
namespace Modules;

use Wappsnet\Core\Blog;
use Wappsnet\Core\Module;

class Author extends Module
{
    protected function setData(): void
    {
        $author = get_userdata($this->args['id']);
        $this->data['data'] = $author;
    }
}