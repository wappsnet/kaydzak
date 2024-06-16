import Auth from '../../assets/scripts/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('#user-forgot').click(function() {
        Auth.actionUser('user_forgot');
    });
});