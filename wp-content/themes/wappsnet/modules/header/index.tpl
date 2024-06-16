<nav class="navbar navbar-expand-md sticky-top bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{$logo}" alt="${$title}" width="30" height="auto">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-nav">
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
