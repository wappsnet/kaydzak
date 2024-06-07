require('./carousel.js');

(function ($, PubSub) {
    $(document).ready(function(e) {
        PubSub.publish('document.ready', e);
    });

    $(window).on('load', function (e) {
        PubSub.publish('window.load',e);
    });

    $(window).on('resize', function(e) {
        PubSub.publish('window.resize',e);
    });

    $(window).on('scroll', function(e) {
        PubSub.publish('window.scroll',e);
    });
}(jQuery, PubSub));