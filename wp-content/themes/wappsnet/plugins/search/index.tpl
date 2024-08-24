<div class="plugin-search">
    <p class="plugin-search__summary">
        Founded <b> {$count} </b> matching items by: <b>"{$keyword}"</b>
    </p>
    <hr/>
    <div class="plugin-search__results">
        {foreach from=$posts item=item}
            <div class="plugin-search__item">
                <div class="plugin-search__item-header">
                    <a href="{$item.link}" class="plugin-search__item-image">
                        <img alt="{$item.data->post_title}" src="{$item.media.image}" width="60" height="45"/>
                    </a>
                    <h6 class="plugin-search__item-title">
                        <a href="{$item.link}">{$item.data->post_title}</a>
                    </h6>
                </div>
                <p class="plugin-search__item-content">{$item.text|truncate:300:"..."}</p>
            </div>
        {/foreach}
    </div>
</div>
