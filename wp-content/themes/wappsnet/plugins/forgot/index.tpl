<div class="plugin-forgot">
    <div class="auth-item">
        <div id="auth-info-messages"
             class="auth-info-messages">
        </div>

        <div class="auth-field">
            <div class="auth-icon">
                <i class="fa fa-key"></i>
            </div>
            <input class="auth-input user_forgot"
                   id="user_forgot_email"
                   name="email"
                   data-type="email"
                   placeholder="{$langData.auth_email}"
                   type="email"/>
        </div>
        <div class="auth-footer">
            <button id="user-forgot"
                    class="auth-button waves-effect waves-light btn">
                {$langData.recover_password}
            </button>
        </div>
    </div>
</div>