<nav class="layout-header navbar navbar-expand-md sticky-top">
    <div class="container-fluid justify-content-between" style="{$styles.header}">
        <div class="layout-header__navbar left-menu">
            <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#secondary-nav"
                    aria-controls="secondary-nav">
                <span class="wp-svg-icon">{$icons.bars}</span>
            </button>
            <div class="collapse navbar-collapse layout-header__navbar-menu">
                <ul class="navbar-nav">
                    {foreach from=$menu.primary item=menuItem}
                        {if !$menuItem->menu_item_parent}
                            <li class="nav-item">
                                <a class="nav-link app-nav-item" href="{$menuItem->url}">
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
        <div class="layout-header__navbar right-menu">
            <div class="collapse navbar-collapse layout-header__navbar-menu">
                <ul class="navbar-nav">
                    {foreach from=$menu.secondary item=menuItem}
                        {if !$menuItem->menu_item_parent}
                            <li class="nav-item">
                                <a class="nav-link app-nav-item" href="{$menuItem->url}">
                                    {$menuItem->title}
                                </a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
            <button class="btn btn-light" type="button" id="search-open-toggle">
                <span class="wp-svg-icon">{$icons.search}</span>
            </button>
        </div>
    </div>
</nav>

<div class="layout-canvas offcanvas offcanvas-start" tabindex="-1" aria-labelledby="offcanvasRightLabel"
     id="secondary-nav">
    <div class="offcanvas-header layout-canvas__header">
        <a class="layout-canvas__brand" href="/">
            <img src="{$logo}" alt="${$title}" width="auto" height="35">
            <span class="layout-canvas__title">{$title}</span>
        </a>
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas" aria-label="Close">
            <span class="wp-svg-icon">{$icons.xmark}</span>
        </button>
    </div>
    <div class="layout-canvas__body offcanvas-body">
        {$menu.canvas}
    </div>
</div>