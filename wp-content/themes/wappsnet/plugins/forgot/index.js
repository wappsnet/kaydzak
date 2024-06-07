import Auth from '../../assets/js/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('#user-forgot').click(function() {
        Auth.actionUser('user_forgot');
    });
});