<div class="module-areas">
    {foreach from=$items item=category}
        <div class="module-areas__item">
            <div class="module-areas__item-icon" style="color: {$category.fields.term_color.value}">
                <span class="wp-svg-icon">{$category.fields.term_svg.value}</span>
            </div>
            <div class="module-areas__item-content">
                <a class="module-areas__item-title" href="{$category.link}" style="color: {$category.fields.term_color.value}">
                    {$category.data->name}
                </a>
                <p class="module-areas__item-description">{$category.data->description}</p>
            </div>
        </div>
    {/foreach}
</div>