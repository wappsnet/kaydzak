<div class="plugin-login">
    <div class="auth-item">
        <div id="auth-info-messages"
             class="auth-info-messages">
        </div>

        <div class="auth-field">
            <div class="auth-icon">
                <i class="fa fa-user"></i>
            </div>
            <input class="auth-input user_login"
                   id="user_login_email"
                   name="email"
                   data-type="email"
                   placeholder="{$lang.auth_email}"
                   type="email"/>
        </div>
        <div class="auth-field">
            <div class="auth-icon">
                <i class="fa fa-key"></i>
            </div>
            <input class="auth-input user_login"
                   id="user_login_password"
                   name="password"
                   data-type="password"
                   placeholder="{$lang.auth_password}"
                   type="password"/>
        </div>
        <div class="auth-footer">
            <a class="auth-button action-button waves-effect waves-light btn"
               data-action="user_login">
                {$lang.login}
            </a>
            <a class="auth-button waves-effect waves-light btn"
               href="{$links.registration}">
                {$lang.registration}
            </a>
        </div>
    </div>
</div>