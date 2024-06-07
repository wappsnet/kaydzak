<div class="comments-plugin">
    <div class="create-comment">
        <div class="auth-item">
            <div id="auth-info-messages"
                 class="auth-info-messages">
            </div>

            <div class="auth-field">
                <div class="auth-icon">
                    <i class="fa fa-user"></i>
                </div>
                <input class="auth-input user_comment"
                       id="user_comment_name"
                       name="name"
                       data-type="name"
                       placeholder="{$lang.auth_name}"
                       type="text"/>
            </div>

            <div class="auth-field">
                <div class="auth-icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <input class="auth-input user_comment"
                       id="user_comment_email"
                       name="email"
                       data-type="email"
                       placeholder="{$lang.auth_email}"
                       type="email"/>
            </div>

            <div class="auth-field auth-text">
                <div class="auth-icon">
                    <i class="fa fa-book"></i>
                </div>
                <textarea class="auth-input user_comment"
                          id="user_comment_text"
                          name="text"
                          data-type="text"
                          placeholder="{$lang.comment_text}"></textarea>
            </div>

            <input class="auth-input user_comment"
                   id="user_comment_post_id"
                   type="hidden"
                   data-type="hidden"
                   value="{$postId}"
                   name="post_id">

            <div class="auth-footer">
                <button id="user-comment"
                        class="auth-button waves-effect waves-light btn">
                    {$lang.add_comment}
                </button>
            </div>
        </div>
    </div>

    {if count($comments) > 0}
        <div class="comments-list">
            {foreach $comments as $commentItem}
                <div class="comment-item">
                    <div class="comment-item-header">
                        <span class="comment-author">{$commentItem->comment_author}</span>
                        <span class="comment-date">{$commentItem->comment_date}</span>
                    </div>
                    <div class="comment-item-body">
                        {$commentItem->comment_content}
                    </div>
                </div>
            {/foreach}
        </div>
    {else}
        <div class="empty-comments">
            {$lang.empty_comments}
        </div>
    {/if}
</div>