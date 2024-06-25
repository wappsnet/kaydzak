<div class="plugin-post">
    <div class="card">
        <a href="{$post.link}">
            <img src="{$post.media.image}" class="card-img-top" alt="{$post.data->post_title}">
        </a>
        <div class="card-body">
            <h5 class="card-title"><a class="plugin-post__title" href="{$post.link}">{$post.data->post_title}</a></h5>
            <p class="card-text"><small class="text-muted">{$post.data->post_date}</small></p>
            <div class="plugin-post__categories">
                {foreach from=$post.categories item=category}
                    <a class="plugin-post__categories-item card-link" href="{$category.link}" style="color: {$category.fields.term_color.value};">
                        <span class="{$category.fields.term_icon.value.type} {$category.fields.term_icon.value.value}"></span>
                        {$category.data->name}
                    </a>
                {/foreach}
            </div>
        </div>
    </div>
</div>