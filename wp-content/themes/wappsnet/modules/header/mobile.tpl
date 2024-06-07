<div class="header-module">
    <div class="app-fill">
        <div class="header-tools">
            <div id="side-menu-toggle"
                 class="header-tool-item allow-hover"
                 data-activates="mobile-menu">
                <span class="header-tool-icon"><i class="fa fa-bars"></i></span>
            </div>

            <a href="/"
               class="header-tool-item allow-hover">
                <img src="{$logo}"/>
            </a>
        </div>
    </div>
</div>

<div id="mobile-menu"
     class="side-nav app-side-nav side-menu-box">
    <div class="app-side-logo">
        <img src="{$logo}"/>
    </div>
    <div class="app-side-wrapper">
        {foreach from=$menu item=menuItem}
            {if !$menuItem->menu_item_parent}
                <a href="{$menuItem->url}"
                   class="app-side-menu-item">
                    {$menuItem->title}
                </a>
            {/if}
        {/foreach}
    </div>
</div>
