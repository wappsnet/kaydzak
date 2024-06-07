<div class="module-art-work">
    <div class="app-fill">
        <div class="art-work-wrapper">
            <div class="art-work-header">
                <h1 class="art-work-title">{$art.data->post_title}</h1>
            </div>
            <div class="art-work-info">
                <div class="app-row">
                    <div class="app-column large-6 middle-12 small-12">
                        <div class="art-work-media">
                            <img class="zoom-view-box" src="{$art.media.image}"/>
                        </div>
                    </div>
                    <div class="app-column large-6 middle-12 small-12">
                        <div class="art-work-data">
                            <div class="art-work-data-section">
                                <div class="art-work-data-label">{$lang.author}</div>
                                <div class="art-work-data-value">
                                    {$art.author->nickname}
                                </div>
                            </div>
                            <div class="art-work-data-section">
                                <div class="art-work-data-label">{$lang.categories}</div>
                                <div class="art-work-data-value">
                                    {foreach from=$art.categories item=category}
                                        <a class="art-work-data-value-badge" href="{$category.link}">{$category.data->name}</a>
                                    {/foreach}
                                </div>
                            </div>

                            {foreach from=$art.characters item=character}
                                {if $character.value}
                                    <div class="art-work-data-section">
                                        <div class="art-work-data-label">{$character.label}</div>
                                        <div class="art-work-data-value">
                                            {if !$character.value->name}
                                                {foreach from=$character.value item=item}
                                                    <span class="art-work-data-value-badge">{$item->name}</span>
                                                {/foreach}
                                            {else}
                                                <span class="art-work-data-value-badge">{$character.value->name}</span>
                                            {/if}
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
            <div class="art-work-description">
                <h2 class="art-work-content-title">{$lang.about_work}</h2>
                <div class="art-work-content">
                    {$art.data->post_content}
                </div>
            </div>
            <div class="art-work-comments">
                {$comments}
            </div>
            <div class="art-work-similar">
                <h2 class="art-work-similar-title">{$lang.similar_items}</h2>
                <div class="art-work-similar-items">
                    {$similar}
                </div>
            </div>
        </div>
    </div>
</div>