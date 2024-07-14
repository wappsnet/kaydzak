<div class="module-contribution">
    {foreach from=$items item=category}
        <div class="module-contribution__area">
            <div class="module-contribution__area-icon" style="color: {$category.fields.term_color.value}">
                <span class="wp-svg-icon">{$category.fields.term_svg.value}</span>
            </div>
            <div class="module-contribution__area-content">
                <a class="module-contribution__area-title" href="{$category.link}" style="color: {$category.fields.term_color.value}">
                    {$category.data->name}
                </a>
                <p class="module-contribution__area-description">{$category.data->description}</p>
            </div>
        </div>
    {/foreach}
</div>