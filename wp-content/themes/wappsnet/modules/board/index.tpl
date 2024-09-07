<div class="module-board">
    <div class="row justify-content-center">
        {foreach from=$board.people item=item}
            <div class="col-12 col-lg-4 col-md-6 col-sm-12">
                <div class="module-board__item">
                    <div class="module-board__item-wrapper">
                        <a class="module-board__item-avatar" href="{$item.data.link}">
                            <img src="{$item.data.media.image}" alt="{$item.user->display_name}"/>
                        </a>
                        <h5 class="module-board__item-header">
                            <a class="module-board__item-title" href="{$item.data.link}">
                                {$item.user->display_name}
                            </a>
                        </h5>
                        <h6 class="module-board__item-departments">
                            {', '|implode:$item.terms}
                        </h6>
                        <div class="module-board__item-content">
                            {$item.user->description|truncate:150:"..."}
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
    </div>
</div>