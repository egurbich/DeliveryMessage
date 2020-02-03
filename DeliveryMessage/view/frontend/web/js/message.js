define([
    "jquery",
    'mage/url'
], function ($, url) {
    var messageContainer = '.delivery-message';

    /**
     * Get Delivery message
     */
    function deliveryMessage() {
        $.ajax({
            url: url.build('magecom/delivery/message'),
            context: this
        }).done(function (result) {
            if (result.success === true) {
                $(messageContainer).html(result.message);
            }
        });
    }

    return function() {
        deliveryMessage();
    }
});