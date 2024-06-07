import Auth from '../../assets/js/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('#contact-submit').click(function() {
        Auth.actionUser('contact-field');
    });
});