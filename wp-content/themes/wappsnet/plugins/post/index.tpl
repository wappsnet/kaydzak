<div class="plugin-post">
    <a href="{$post.link}" class="plugin-post__media">
        <img src="{$post.media.image}" class="plugin-post__image" alt="{$post.data->post_title}">
    </a>
    <div class="plugin-post__info">
        <h5 class="plugin-post__title"><a href="{$post.link}">{$post.data->post_title}</a></h5>
        <div class="plugin-post__categories">
            {foreach from=$post.categories item=category}
                <a class="plugin-post__categories-item" href="{$category.link}" style="background-color: {$category.fields.term_color.value};">
                    <span class="wp-svg-icon">{$category.fields.term_svg.value}</span>
                    {$category.data->name}
                </a>
            {/foreach}
        </div>
        <a class="plugin-post__author" href="{$post.author.url}">{$post.author.data->display_name}</a>
    </div>
</div>
