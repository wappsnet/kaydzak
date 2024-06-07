<div class="plugin-social-icons">
    {foreach from=$items item=item}
        <a class="social-link"
           href="{$item.link}">
            <i class="{$item.icon}"></i>
        </a>
    {/foreach}
</div>