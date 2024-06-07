<div class="plugin-register">
    <div class="auth-item">
        <div id="auth-info-messages"
             class="auth-info-messages">
        </div>

        <div class="auth-field">
            <div class="auth-icon">
                <i class="fa fa-user"></i>
            </div>
            <input class="auth-input user_register"
                   id="user_register_email"
                   name="email"
                   data-type="email"
                   placeholder="{$lang.auth_email}"
                   type="email"/>
        </div>
        <div class="auth-field">
            <div class="auth-icon">
                <i class="fa fa-key"></i>
            </div>
            <input class="auth-input user_register"
                   id="user_register_password"
                   name="password"
                   data-type="password"
                   placeholder="{$lang.auth_password}"
                   type="password"/>
        </div>
        <div class="auth-field">
            <input class="auth-input user_register"
                   id="user_register_first_name"
                   name="first_name"
                   data-type="name"
                   placeholder="{$lang.auth_first_name}"
                   type="text"/>
        </div>
        <div class="auth-field">
            <input class="auth-input user_register"
                   id="user_register_last_name"
                   name="last_name"
                   data-type="name"
                   placeholder="{$lang.auth_last_name}"
                   type="text"/>
        </div>
        <div class="auth-field">
            <div class="auth-icon">
                <i class="fa fa-phone"></i>
            </div>
            <input class="auth-input user_register"
                   id="user_register_phone"
                   name="phone"
                   data-type="phone"
                   placeholder="{$lang.auth_phone}"
                   type="tel"/>
        </div>
        <div class="auth-footer">
            <a class="auth-button action-button waves-effect waves-light btn"
               data-action="user_register">
                {$lang.registration}
            </a>
            <a class="auth-button waves-effect waves-light btn"
               href="{$links.login}">
                {$lang.login}
            </a>
        </div>
    </div>
</div>