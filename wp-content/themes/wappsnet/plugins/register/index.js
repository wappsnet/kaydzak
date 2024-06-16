import Auth from '../../assets/scripts/partials/auth';

PubSub.subscribe('document.ready', function() {
    $('.plugin-register .action-button').click(function() {
        let actionName = $(this).attr('data-action');

        console.log(actionName);

        Auth.actionUser(actionName);
        return false;
    });
});