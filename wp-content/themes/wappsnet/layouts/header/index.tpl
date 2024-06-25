<head>
    <!--app statistics settings-->
    <meta name="yandex-verification" content="2376a6f240de4d6c"/>

    <!--app seo settings-->
    <title>{$seo.title}</title>
    <meta charset="{$seo.chars}"/>
    <meta property="og:locale" content="ru_RU"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{$seo.title}">
    <meta property="og:url" content="{$seo.link}">
    <meta property="og:image" content="{$seo.image}">
    <meta property="og:description" content="{$seo.text}">
    <meta name="description" content="{$seo.desc}">

    <!--app view settings-->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <!--app scripts links-->
    <link rel="stylesheet" href="{$scripts['css']}"/>

    <!--app additional settings-->
    <style>
        {$styles}
    </style>
</head>

<body class="{$class}">
<nav class="layout-header navbar navbar-expand-md sticky-top">
    <div class="container-fluid justify-content-start">
        <a class="navbar-brand" href="#">
            <img src="{$logo}" alt="${$title}" width="auto" height="35">
        </a>
        <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#secondary-nav" aria-controls="secondary-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                {foreach from=$menu item=menuItem}
                    {if !$menuItem->menu_item_parent}
                        <li class="nav-item">
                            <a  class="nav-link" href="{$menuItem->url}">
                                {$menuItem->title}
                            </a>
                        </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="offcanvasRightLabel" id="secondary-nav">
    <div class="offcanvas-header layout-header">
        <a class="navbar-brand" href="#">
            <img src="{$logo}" alt="${$title}" width="auto" height="35">
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            {foreach from=$menu item=menuItem}
                {if !$menuItem->menu_item_parent}
                    <li class="nav-item">
                        <a  class="nav-link" href="{$menuItem->url}">
                            {$menuItem->title}
                        </a>
                    </li>
                {/if}
            {/foreach}
        </ul>
    </div>
</div>
