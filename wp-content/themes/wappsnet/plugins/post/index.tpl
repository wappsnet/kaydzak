<div class="plugin-post">
    <div class="card">
        <a href="{$post.link}">
            <img src="{$post.media.image}" class="card-img-top" alt="{$post.data->post_title}">
        </a>
        <div class="card-body">
            <h5 class="card-title plugin-post__title"><a href="{$post.link}">{$post.data->post_title}</a></h5>
            <div class="plugin-post__categories">
                {foreach from=$post.categories item=category}
                    <a class="plugin-post__categories-item" href="{$category.link}" style="color: {$category.fields.term_color.value};">
                        <span class="wp-svg-icon">
                            {$category.fields.term_svg.value}
                        </span>
                        {$category.data->name}
                    </a>
                {/foreach}
            </div>
            <a class="plugin-post__author" href="{$post.author->user_url}">{$post.author->display_name}</a>
        </div>
    </div>
</div>