<div class="plugin-post">
    <a href="{$post.link}"
       class="post-wrapper">
        <div class="post-media">
            {if $post.media.video}
                {$post.media.video}
            {else}
                <img src="{$post.media.image}"/>
            {/if}
        </div>
        <div class="post-info">
            <div class="post-date post-info-wrapper">
                {$post.data->post_date}
            </div>

            <div class="post-title post-info-wrapper">
                {$post.data->post_title}
            </div>
        </div>
    </a>
</div>