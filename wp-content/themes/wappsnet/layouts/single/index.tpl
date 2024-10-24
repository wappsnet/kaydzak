<div class="single-page-layout">
    <div class="container-lg">
        <div class="single-page-layout__media">
            <img alt="{$post.data->post_title}" src="{$post.media.image}"/>
        </div>
        <hr/>
        <h1 class="app-page-title">{$post.data->post_title}</h1>
        <hr/>
        <div class="single-page-layout__wrapper" style="{$styles.post}">
            <div class="single-page-layout__categories">
                {foreach from=$post.categories item=category}
                    <a class="single-page-layout__categories-item" href="{$category.link}" style="background-color: {$category.fields.term_color.value};">
                        <span class="wp-svg-icon">{$category.fields.term_svg.value}</span>
                        {$category.data->name}
                    </a>
                {/foreach}
            </div>
            <hr/>
            <div class="single-page-layout__meta">
                {$meta}
            </div>
            <hr/>
            <div class="single-page-layout__content">
                {$post.data->post_content}
            </div>
            <div class="single-page-layout__author">
                {$author}
            </div>
        </div>
    </div>
</div>