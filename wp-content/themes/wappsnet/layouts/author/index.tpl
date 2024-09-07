<div class="author-page-layout">
    <div class="container-lg" style="{$styles.page}">
        <div class="author-page-layout__media">
            <img src="{$author.post.media.image}" alt="{$author.post.data->post_title}" />
        </div>
        <hr/>
        {if isset($author.post.data->post_title)}
            <h1 class="author-page-layout__title app-page-title">{$author.post.data->post_title}</h1>
            <hr/>
        {/if}
        {if isset($author.terms)}
            <h5 class="author-page-layout__departments">
                {', '|implode:$author.terms}
            </h5>
        {/if}
        {if isset($author.post.data->post_content)}
            <div class="author-page-layout__content">
                {$author.post.data->post_content}
            </div>
            <hr/>
        {/if}
        {if isset($meta)}
            <div class="author-page-layout__meta">{$meta}</div>
            <hr/>
        {/if}
        <div class="author-page-layout__posts">
            <div class="row">
                {foreach from=$posts item=post}
                    <div class="col col-lg-3">{$post}</div>
                {/foreach}
            </div>
        </div>
    </div>
</div>