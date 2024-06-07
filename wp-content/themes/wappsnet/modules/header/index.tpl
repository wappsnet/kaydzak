<div class="header-module">
    <div class="app-fill">
        <div class="header-tools">
            <a href="/"
               class="header-tool-item allow-hover">
                <img src="{$logo}"/>
            </a>

            {foreach from=$menu item=menuItem}
                {if !$menuItem->menu_item_parent}
                    <a href="{$menuItem->url}"
                       class="header-tool-item allow-hover">
                        {$menuItem->title}
                    </a>
                {/if}
            {/foreach}
        </div>
    </div>
</div>