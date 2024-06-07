<?php
namespace Plugins;

use Wappsnet\Core\Plugin;

class Carousel extends Plugin
{
    protected function setData() {
        $carouselItems = $this->args['items'];

        $this->data = Array(
            'carouselItems' => $carouselItems
        );
    }
}