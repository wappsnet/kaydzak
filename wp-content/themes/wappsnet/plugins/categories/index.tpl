<div class="categories-plugin">
    <div class="categories-items">
        {foreach from=$categories item=category}
            <a href="{$category.link}"
               class="waves-effect waves-light btn app-button category {if $active eq $category.data->slug} active {/if}">
                {$category.data->cat_name}
            </a>
        {/foreach}
    </div>
</div>