<div class="module-profile">
    <div class="app-fill">
        <div class="profile-content">
            {if $post->post_title}
                <h1 class="profile-title">
                    {$post->post_title}
                </h1>
            {/if}

            {if $post->post_content}
                <div class="profile-text">
                    {$post->post_content}
                </div>
            {/if}
        </div>

        <div class="profile-plugins">
            {foreach from=$plugins item=item}
                <div class="profile-plugin">
                    {$item.plugin}
                </div>
            {/foreach}
        </div>
    </div>
</div>