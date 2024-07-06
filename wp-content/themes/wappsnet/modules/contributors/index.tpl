<div class="module-contributors">
    <hr/>
    <div class="row justify-content-center">
        {foreach from=$items item=item}
            <div class="col col-lg-6 col-xl-6 col-12">
                <div class="module-contributors__item">
                    <div class="module-contributors__item-wrapper">
                        <a class="module-contributors__item-avatar" href="{$item.data.link}">
                            <img src="{$item.data.media.image}" alt="{$item.user->display_name}"/>
                        </a>
                        <h4>
                            <a class="module-contributors__item-title" href="{$item.data.link}">
                                {$item.user->display_name}
                            </a>
                        </h4>
                        <h5>
                            {foreach from=$item.data.terms item=term}
                                <span>{$term->name}</span>
                            {/foreach}
                        </h5>
                        <div class="module-contributors__item-content">
                            {$item.user->description}
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
    </div>
</div>