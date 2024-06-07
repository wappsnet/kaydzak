<div class="plugin-product">
    <a href="{$product.link}"
       class="product-wrapper">
        <div class="product-media">
            {if $product.media.video}
                {$product.media.video}
            {else}
                <img src="{$product.media.image}"/>
            {/if}
        </div>
        <div class="product-info">
            <div class="product-date product-info-wrapper">
                {$product.data->product_date}
            </div>

            <div class="product-title product-info-wrapper">
                {$product.data->product_title}
            </div>
        </div>
    </a>
</div>