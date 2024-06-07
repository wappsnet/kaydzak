<div class="module-popular">
    <div class="module-popular-categories">
        <div class="app-fill">
            <div class="popular-wrapper">
                <h3 class="popular-title">
                    {$lang.find_by_category}
                </h3>
                <div class="popular-categories-items">
                    {$categories}
                </div>
            </div>
        </div>
    </div>
    <div class="module-popular-art">
        <div class="app-fill">
            <div class="popular-wrapper">
                <h3 class="popular-title">
                    {$lang.popular_art_title}
                </h3>
                <div class="popular-art-items">
                    <div class="app-row">
                        {foreach from=$art item=chunk}
                            <div class="app-column large-4 middle-6 small-12">
                                {foreach from=$chunk item=item}
                                    <a href="{$item.link}" class="popular-art-item">
                                        <img src="{$item.media.image}"/>
                                        <div class="popular-art-item-info">
                                            <h2 class="popular-art-item-title">{$item.data->post_title}</h2>
                                        </div>
                                    </a>
                                {/foreach}
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
        <div class="popular-footer">
            <a href="{$links.art}" class="waves-effect waves-light btn app-button popular-button">
                {$lang.explore_all_art}
            </a>
        </div>
    </div>
    <div class="module-popular-shop">
        <div class="app-fill">
            <div class="popular-wrapper">
                <h3 class="popular-title">
                    {$lang.popular_shop_title}
                </h3>
                <div class="popular-shop-items">
                    {$shop}
                </div>
            </div>
        </div>
        <div class="popular-footer">
            <a href="{$links.shop}" class="waves-effect waves-light btn app-button popular-button">
                {$lang.explore_all_shop}
            </a>
        </div>
    </div>
</div>