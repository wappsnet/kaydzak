<div class="plugin-mobile-icons">
    {foreach from=$items item=item}
        <a class="mobile-link"
           href="{$item.link}"
           style="background-image: url({$item.image.url})">
        </a>
    {/foreach}
</div>