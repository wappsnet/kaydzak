<ul class="plugin-navigation nav justify-content-center">
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
