import Magnifier from 'magnifier';

PubSub.subscribe('document.ready', function() {
    const magnifier = new Magnifier('.zoom-view-box');
    magnifier.width(300);
    magnifier.height(300);
    magnifier.borderRadius(300);
});