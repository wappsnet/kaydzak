<div class="module-categories">
    <div class="row justify-content-center">
        {foreach from=$items item=category}
            <div class="col col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12" style="color: {$category.fields.term_color.value}">
                <a class="module-category__item" href="{$category.link}">
                        <span class="module-category__item-icon">
                        <span class="wp-svg-icon">{$category.fields.term_svg.value}</span>
                        </span>
                    <span class="module-category__item-label">{$category.data->name}</span>
                </a>
            </div>
        {/foreach}
    </div>
</div>