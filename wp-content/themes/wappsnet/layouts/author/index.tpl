<div class="author-page-layout">
    <div class="container-lg">
        <h1>{$author.post.data->post_title}</h1>
        <hr/>
        <h5>
            {foreach from=$author.post.terms item=term}
                <span>{$term->name}</span>
            {/foreach}
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