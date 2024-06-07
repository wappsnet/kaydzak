<div class="plugin-social-share">
    {foreach from=$items item=item}
        <a class="social-share"
           href="{$item.link|replace:'{url}':$link}"
           target="_blank">
            <i class="{$item.icon}"></i>
        </a>
    {/foreach}
</div>