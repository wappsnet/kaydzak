import Auth from '../../assets/js/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('#subscribe-submit').click(function() {
        Auth.subscribe();
    });
});