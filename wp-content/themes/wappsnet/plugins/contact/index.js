import Auth from '../../assets/scripts/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('#contact-submit').click(function() {
        Auth.actionUser('contact-field');
    });
});