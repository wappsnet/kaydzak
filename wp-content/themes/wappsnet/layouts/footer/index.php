<?php
namespace Layouts;

use Wappsnet\Core\Layout;
use Wappsnet\Core\Render;

class Footer extends Layout
{
    protected function setData(): void
    {
        $this->data['social'] = Render::get_plugin('SocialIcons');
        $this->data["navigation"] = Render::get_plugin('Navigation', [
            'name' => 'footer'
        ]);
        $this->data['rights'] = Render::get_plugin('CopyRights');
        $this->data['recaptcha'] = Render::get_plugin('Recaptcha');
    }
}