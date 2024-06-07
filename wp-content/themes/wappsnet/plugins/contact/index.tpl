<div class="contact-plugin">
    <div class="auth-item">
        <div id="auth-info-messages"
             class="auth-info-messages">
        </div>

        <label for="name" class="auth-label">
            <div class="auth-icon">
                <i class="fa fa-user"></i>
            </div>
            <span>{$lang.auth_name}</span>
        </label>
        <div class="auth-field">
            <input class="auth-input contact-field"
                   id="name"
                   name="name"
                   data-type="name"
                   placeholder="{$lang.auth_name}"
                   type="text"/>
        </div>

        <label for="email" class="auth-label">
            <div class="auth-icon">
                <i class="fa fa-envelope"></i>
            </div>
            <span>{$lang.auth_email}</span>
        </label>
        <div class="auth-field">
            <input class="auth-input contact-field"
                   id="email"
                   name="email"
                   data-type="email"
                   placeholder="{$lang.auth_email}"
                   type="email"/>
        </div>

        <label for="message" class="auth-label">
            <div class="auth-icon">
                <i class="fa fa-book"></i>
            </div>
            <span>{$lang.auth_message}</span>
        </label>
        <div class="auth-field auth-text">
            <textarea class="auth-input contact-field"
                      id="message"
                      name="text"
                      data-type="text"
                      placeholder="{$lang.auth_message}">
            </textarea>
        </div>

        <div class="auth-footer">
            <button id="contact-submit"
                    class="auth-button waves-effect waves-light btn">
                {$lang.auth_send}
            </button>
        </div>
    </div>
</div>
