<nav class="layout-header navbar navbar-expand-md sticky-top">
    <div class="container-fluid justify-content-between">
        <div class="layout-header__navbar left-menu">
            <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#secondary-nav"
                    aria-controls="secondary-nav">
                <span class="wp-svg-icon">{$icons.bars}</span>
            </button>
            <button class="btn btn-light" type="button" id="search-open-toggle">
                <span class="wp-svg-icon">{$icons.search}</span>
            </button>
            <div class="collapse navbar-collapse layout-header__navbar-menu">
                <ul class="navbar-nav">
                    {foreach from=$menu.primary item=menuItem}
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
        <div class="layout-header__navbar right-menu">
            <div class="collapse navbar-collapse layout-header__navbar-menu">
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

<div class="layout-canvas offcanvas offcanvas-start" tabindex="-1" aria-labelledby="offcanvasRightLabel"
     id="secondary-nav">
    <div class="offcanvas-header layout-canvas__header">
        <a class="navbar-brand" href="/">
            <img src="{$image}" alt="${$title}" width="auto" height="35">
        </a>
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas" aria-label="Close">
            <span class="wp-svg-icon">{$icons.xmark}</span>
        </button>
    </div>
    <div class="layout-canvas__body offcanvas-body">
        {$menu.canvas}
    </div>
</div>

<div class="layout-search-popup" id="search-container">
    <div class="layout-search-popup__header">
        <button class="btn btn-light" type="button" id="search-close-toggle">
            <span class="wp-svg-icon">{$icons.xmark}</span>
        </button>
    </div>
    <div class="layout-search-popup__body">
        <div class="container-md">
            <div class="layout-search-popup__form">
                <div class="layout-search-popup__form-wrapper">
                    <label for="search-input" class="layout-search-popup__form-icon">
                        <span class="wp-svg-icon">{$icons.search}</span>
                    </label>
                    <input
                            id="search-input"
                            class="layout-search-popup__form-input"
                            type="text"
                            autocomplete="true"
                            name="search"
                            placeholder="{$title}"
                    />
                </div>
            </div>
            <div class="layout-search-popup__results">

            </div>
        </div>
    </div>
</div>
