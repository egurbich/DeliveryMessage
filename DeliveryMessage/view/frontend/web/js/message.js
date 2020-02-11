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
                $(messageContainer).html(result.message); // regular message in case of success
            } else if (result.success === false) {
                $(messageContainer).html(result.message); // something went wrong, can be styled in different way
            }
        });
    }

    return function() {
        deliveryMessage();
    }
});