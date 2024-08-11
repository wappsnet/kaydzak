<nav class="layout-header navbar navbar-expand-md sticky-top">
    <div class="container-fluid justify-content-between">
        <div class="layout-header__navbar">
            <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#secondary-nav" aria-controls="secondary-nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse layout-header__navbar-menu header-menu">
                <ul class="navbar-nav">
                    {foreach from=$menu.header item=menuItem}
                        {if !$menuItem->menu_item_parent}
                            <li class="nav-item">
                                <a class="nav-link" href="{$menuItem->url}">
                                    {$menuItem->title}
                                </a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
        <div class="layout-header__image">
            <a class="layout-header__icon" href="/" id="app-header-icon">
                <img src="{$logo}" alt="{$title}" width="auto" height="100%">
            </a>
        </div>
        <div class="layout-header__navbar">
            <div class="collapse navbar-collapse layout-header__navbar-menu secondary-menu">
                <ul class="navbar-nav">
                    {foreach from=$menu.secondary item=menuItem}
                        {if !$menuItem->menu_item_parent}
                            <li class="nav-item">
                                <a class="nav-link" href="{$menuItem->url}">
                                    {$menuItem->title}
                                </a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="layout-canvas offcanvas offcanvas-start" tabindex="-1" aria-labelledby="offcanvasRightLabel" id="secondary-nav">
    <div class="offcanvas-header layout-canvas__header">
        <a class="navbar-brand" href="/">
            <img src="{$image}" alt="${$title}" width="auto" height="35">
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="layout-canvas__body offcanvas-body">
        {$menu.canvas}
    </div>
</div>
