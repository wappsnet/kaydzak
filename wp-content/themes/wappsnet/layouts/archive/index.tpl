<div class="archive-page-layout">
    <div class="container-lg">
        <h1 class="app-page-title">
            <span class="wp-svg-icon">{$category.fields.term_svg.value}</span>
            {$category.data->name}
        </h1>
        <hr/>
        {if !empty($category.data->description)}
            <p>{$category.data->description}</p>
            <hr/>
        {/if}

        <div class="row">
            {foreach from=$posts item=post}
                <div class="col col-lg-4">{$post}</div>
            {/foreach}
        </div>
        <div class="archive-page-layout__pagination">
            {$pagination}
        </div>
    </div>
</div>