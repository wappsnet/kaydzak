<div class="module-author">
    <div class="row">
        <div class="col col-lg-3 col-lg-3 col-sm-12">
            <a href="{$author.link}" class="justify-content-sm-center">
                <img class="module-author__avatar" width="100%" height="auto" alt="{$author.data->display_name}" src="{$author.post.media.image}"/>
            </a>
        </div>
        <div class="col col-lg-9 col-lg-9 col-sm-12">
            <div class="module-author__info">
                <div class="module-author__header">
                    <h4><a href="{$author.link}">{$author.data->display_name}</a></h4>
                    <h5>
                        {foreach from=$author.post.terms item=term}
                            <span>{$term->name}</span>
                        {/foreach}
                    </h5>
                    <a href="{$author.data->user_url}">{$author.data->user_url}</a>
                </div>
                <div class="module-author__bio">{$author.post.data->post_content}</div>
            </div>
        </div>
    </div>
</div>