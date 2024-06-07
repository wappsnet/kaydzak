import Auth from '../../assets/js/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('#user-comment').click(function() {
        Auth.actionUser('user_comment');
    });
});