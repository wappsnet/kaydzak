<div class="module-art-archive">
    <div class="app-fill">
        <div class="art-archive-wrapper">
            <div class="art-archive-categories">
                {$categories}
            </div>
        </div>

        <div class="art-items-wrapper">
            <div class="app-row">
                {foreach from=$items item=item}
                    <div class="app-column large-4 middle-6 small-12">
                        <div class="art-item">{$item}</div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>

    <div class="pagination-wrapper">
        {$pagination}
    </div>
</div>