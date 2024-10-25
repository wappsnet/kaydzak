<div class="plugin-author">
    <div class="plugin-author__header">
        <div class="row">
            <div class="order-last col-lg-10 col-md-9 col-sm-9 order-lg-0 order-md-0 order-sm-last">
                <div class="plugin-author__info">
                    <h5 class="plugin-author__title">
                        <a href="{$author.post.link}">{$author.post.data->post_title}</a>
                    </h5>
                    <h6 class="plugin-author__departments">
                        {', '|implode:$author.terms}
                    </h6>
                </div>
            </div>
            <div class="order-first col-lg-2 col-md-3 col-sm-3 order-lg-1 order-md-1 order-sm-0 order-sm-first">
                <a href="{$author.post.link}" class="plugin-author__media">
                    <img src="{$author.post.media.image}" alt="{$author.post.data->post_title}" />
                </a>
            </div>
        </div>
    </div>

    <div class="plugin-author__content">
        {$author.post.data->post_content}
    </div>
</div>