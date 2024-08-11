<div class="module-explore">
    <div class="row">
        {foreach from=$items item=category}
            <div class="col col-xl-3 col-md-4 col-sm-6 col-xs-12">
                <div class="module-explore__wrapper">
                    <a class="module-explore__header" href="{$category.link}" style="color: {$category.fields.term_color.value}">
                        {$category.data->name}
                        <span class="wp-svg-icon">{$category.fields.term_svg.value}</span>
                    </a>
                    <ul class="module-explore__posts">
                        {foreach from=$category.posts item=post}
                            <li class="module-explore__post">
                                <a class="module-explore__post-header" href="{$post.link}">{$post.data->post_title}</a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        {/foreach}
    </div>
</div>