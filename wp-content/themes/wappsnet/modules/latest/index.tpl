<div class="module-latest">
    <div class="row">
        {if !empty($items.primary)}
            <div class="col col-lg-3">
                <div class="module-latest__primary">
                    {foreach from=$items.primary item=post}
                        <div class="module-latest__post">
                            {$post}
                        </div>
                    {/foreach}
                </div>
            </div>
        {/if}
        {if !empty($items.main)}
            <div class="col col-lg-6">
                <div class="module-latest__main">
                    {foreach from=$items.main item=post}
                        <div class="module-latest__post">
                            {$post}
                        </div>
                    {/foreach}
                </div>
            </div>
        {/if}
        {if !empty($items.secondary)}
            <div class="col col-lg-3">
                <div class="module-latest__secondary">
                    {foreach from=$items.secondary item=post}
                        <div class="module-latest__post">
                            {$post}
                        </div>
                    {/foreach}
                </div>
            </div>
        {/if}
    </div>
</div>