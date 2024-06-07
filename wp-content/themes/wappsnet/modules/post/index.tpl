<div class="module-post">
    <div class="post-header">
        <div class="post-header-wrapper">
            <h1 class="post-title">
                {$post->post_title}
            </h1>
        </div>

        {if $image}
            <img class="post-image" src="{$image}"/>
        {/if}
    </div>

    <div class="post-body">
        <div class="app-fill">
            <div class="post-date">
                <span class="label">{$lang.published_label}</span>
                <span class="value">{$post->post_date_gmt}</span>
            </div>

            <div class="post-share">
                <span class="label">{$lang.social_post_label}</span>
                <div class="value">
                    {$share}
                </div>
            </div>

            <div class="post-content">
                {$post->post_content}
            </div>
        </div>
    </div>

    {if $children}
        <div class="child-posts">
            {foreach from=$children item=item}
                <a class="child-post" href="{$item->post_link}">
                    {$item->post_title}
                </a>
            {/foreach}
        </div>
    {/if}
</div>