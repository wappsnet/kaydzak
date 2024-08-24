<div class="module-search">
    <div class="module-search__form">
        <label for="wp-search-input" class="module-search__form-icon">
            <span class="wp-svg-icon">{$icons.search}</span>
        </label>
        <input
                id="wp-search-input"
                class="module-search__form-input"
                type="search"
                autocomplete="true"
                name="search"
                placeholder="{$title}"
        />
    </div>
    <div class="module-search__results">
        <span class="loader"></span>
        <div class="module-search__output" id="wp-search-output"></div>
    </div>
</div>