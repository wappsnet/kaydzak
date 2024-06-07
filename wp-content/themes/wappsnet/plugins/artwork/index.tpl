<div class="plugin-art-work">
    <a href="{$art.link}"
       class="art-work-wrapper">
        <div class="art-work-media">
            {if $art.media.video}
                {$art.media.video}
            {else}
                <img src="{$art.media.image}"/>
            {/if}
        </div>
        <div class="art-work-info">
            <div class="art-work-title art-work-info-wrapper">
                {$art.data->post_title}
            </div>
        </div>
    </a>
</div>