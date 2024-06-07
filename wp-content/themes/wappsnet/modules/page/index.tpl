<div class="module-page">
    <div class="page-header">
        <div class="app-fill">
            <h1 class="page-title">
                {$page->post_title}
            </h1>
        </div>
    </div>

    <div class="page-body">
        <div class="app-fill">
            <div class="page-content">
                {$page->post_content}
            </div>
        </div>
    </div>

    {if $children}
        <div class="child-pages">
            {foreach from=$children item=item}
                <a class="child-page" href="{$item->post_link}">
                    {$item->post_title}
                </a>
            {/foreach}
        </div>
    {/if}

    <div class="page-plugins">
        <div class="app-fill">
            {foreach from=$plugins item=item}
                <div class="page-plugin">
                    {$item.plugin}
                </div>
            {/foreach}
        </div>
    </div>
</div>