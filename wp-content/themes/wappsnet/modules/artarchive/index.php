<?php
namespace Modules;

use Plugins\Pagination;
use Wappsnet\Core\Module;
use Wappsnet\Core\Render;

class ArtArchive extends Module
{
    protected function setData() {
        $pagination = Pagination::getPaginationData();
        $artArgs = [
            "fields" => "ids",
            "post_type" => "art",
            'post_status' => 'publish',
            'posts_per_page' => $pagination['limit'],
            'paged' => $pagination['page'],
        ];

        if (isset($_GET['category'])) {
            $artArgs['category'] = $_GET['category'];
        }

        $artItems = get_posts($artArgs);
        $artWorks = [];

        foreach ($artItems as $key => $postId) {
            $artWorks[] = Render::get_plugin('ArtWork', [
                "id" => $postId,
            ]);
        }


        $this->data['items'] = $artWorks;
        $this->data['categories'] = Render::get_plugin('Categories', ['type' => 'art']);
        $this->data['pagination'] = Render::get_plugin('Pagination');
    }
}