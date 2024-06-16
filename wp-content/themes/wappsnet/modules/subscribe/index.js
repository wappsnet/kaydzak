import Auth from '../../assets/scripts/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('#subscribe-submit').click(function() {
        Auth.subscribe();
    });
});