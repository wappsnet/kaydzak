import Auth from '../../assets/scripts/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('.plugin-login .action-button').click(function() {
        let actionName = $(this).attr('data-action');
        Auth.actionUser(actionName);
        return false;
    });
});