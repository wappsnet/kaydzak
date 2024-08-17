<div class="author-page-layout">
    <div class="container-lg">
        <div class="author-page-layout__media">
            <img src="{$author.post.media.image}" alt="{$author.post.data->post_title}" />
        </div>
        <hr/>
        <h1 class="author-page-layout__title">{$author.post.data->post_title}</h1>
        <hr/>
        <h5 class="author-page-layout__departments">
            {', '|implode:$author.terms}
        </h5>
        <div class="author-page-layout__content">
            {$author.post.data->post_content}
        </div>
        <hr/>
        <div class="author-page-layout__posts">
            <div class="row">
                {foreach from=$posts item=post}
                    <div class="col col-lg-3">{$post}</div>
                {/foreach}
            </div>
        </div>
    </div>
</div>